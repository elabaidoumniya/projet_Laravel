<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Etudiant;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Str;

class GoogleAuthController extends Controller
{
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
{
    try {
        $googleUser = Socialite::driver('google')->stateless()->user();
        
        // DEBUG: Vérifiez que l'email est reçu
        \Log::info('Google Auth Attempt', [
            'email' => $googleUser->email,
            'name' => $googleUser->name
        ]);
        
        // Vérifier que c'est un email ENSAT
        if (!$this->isEnsatEmail($googleUser->email)) {
            return redirect('/login')->with('error', 
                '🚫 Accès refusé ! Seuls les emails @ensat.ac.ma ou @etu.uae.ac.ma sont autorisés.<br><br>'
                . '<strong>Email utilisé :</strong> ' . $googleUser->email);
        }
        
        // Chercher ou créer l'utilisateur
        $user = User::where('email', $googleUser->email)->first();
        
        if (!$user) {
            $user = $this->createUserFromGoogle($googleUser);
            $message = '✅ Compte créé avec succès ! Bienvenue ' . $user->name;
        } else {
            // Mettre à jour les infos Google
            $user->update([
                'google_id' => $googleUser->id,
                'avatar' => $googleUser->avatar,
            ]);
            
            // Si c'est un étudiant sans profil, le créer
            if ($user->isEtudiant() && !$user->etudiant_id) {
                $nameParts = explode(' ', $googleUser->name);
                $etudiant = Etudiant::firstOrCreate(
                    ['email' => $googleUser->email],
                    [
                        'cin' => 'TEMP' . strtoupper(Str::random(4)),
                        'nom' => end($nameParts) ?: 'Inconnu',
                        'prenom' => $nameParts[0] ?? 'Inconnu',
                        'filiere' => 'GINF',
                        'niveau' => 'AP1',
                        'date_naissance' => '2000-01-01',
                        'user_id' => $user->id,
                    ]
                );
                $user->etudiant_id = $etudiant->id;
                $user->save();
            }
            
            $message = '✅ Connexion réussie ! Bon retour ' . $user->name;
        }
        
        // Connecter l'utilisateur
        Auth::login($user, true);
        
        \Log::info('User logged in', [
            'id' => $user->id,
            'email' => $user->email,
            'role' => $user->role
        ]);
        
        // === CORRECTION ICI : Redirection directe ===
        if ($user->role === 'admin') {
            return redirect()->route('home')->with('success', $message);
        } else {
            // Pour les étudiants, rediriger vers leur profil
            return redirect()->route('etudiants.mon-profil')->with('success', $message);
        }
        
    } catch (\Exception $e) {
        \Log::error('Google Auth Error', ['error' => $e->getMessage()]);
        return redirect('/login')->with('error', 
            '❌ Erreur technique : ' . $e->getMessage());
    }
}
    private function isEnsatEmail($email)
    {
        return preg_match('/@(ensat\.ac\.ma|etu\.uae\.ac\.ma)$/', $email);
    }
    
    private function createUserFromGoogle($googleUser)
    {
        // Déterminer le rôle (admin si email spécifique)
        $role = $this->determineRole($googleUser->email);
        
        // Créer l'utilisateur
        $user = User::create([
            'name' => $googleUser->name,
            'email' => $googleUser->email,
            'google_id' => $googleUser->id,
            'avatar' => $googleUser->avatar,
            'password' => bcrypt(Str::random(24)), // Mot de passe aléatoire
            'role' => $role,
        ]);
        
        // Si c'est un étudiant, créer un profil étudiant
        if ($role === 'etudiant') {
            $etudiant = $this->createStudentProfile($user, $googleUser);
            $user->etudiant_id = $etudiant->id;
            $user->save();
        }
        
        return $user;
    }
    
    private function determineRole($email)
    {
        // Par défaut étudiant
        $role = 'etudiant';
        
        // Si email admin spécifique
        if ($email === 'admin@ensat.ac.ma' || str_contains($email, 'admin')) {
            $role = 'admin';
        }
        
        return $role;
    }
    
    private function createStudentProfile($user, $googleUser)
    {
        // Extraire nom/prénom
        $nameParts = explode(' ', $googleUser->name);
        
        // Créer ou récupérer l'étudiant
        $etudiant = Etudiant::firstOrCreate(
            ['email' => $googleUser->email],
            [
                'cin' => 'TEMP' . strtoupper(Str::random(4)),
                'nom' => end($nameParts) ?: 'Inconnu',
                'prenom' => $nameParts[0] ?? 'Inconnu',
                'filiere' => 'GINF',
                'niveau' => 'AP1',
                'date_naissance' => '2000-01-01',
                'user_id' => $user->id,
            ]
        );
        
        return $etudiant;
    }
    
    private function redirectBasedOnRole($user)
    {
        if ($user->isAdmin()) {
            return redirect()->route('etudiants.index');
        } elseif ($user->isEtudiant()) {
            return redirect()->route('etudiants.mon-profil');
        }
        
        return redirect('/');
    }
    
    public function logout()
    {
        Auth::logout();
        return redirect('/');
    }
}