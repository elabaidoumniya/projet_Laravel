<?php

namespace App\Http\Controllers;

use App\Services\FirebaseService;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class FirebaseAuthController extends Controller
{
    protected $firebase;
    
    public function __construct(FirebaseService $firebase)
    {
        $this->firebase = $firebase;
    }
    
    // Afficher le formulaire de connexion
    public function showLoginForm()
    {
        return view('auth.login');
    }
    
    // Traiter la connexion
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);
        
        try {
            // 1. Authentification avec Firebase
            $firebaseResult = $this->firebase->signInWithEmailPassword(
                $request->email,
                $request->password
            );
            
            // 2. Vérifier le token JWT
            $decodedToken = $this->firebase->verifyIdToken($firebaseResult['idToken']);
            
            // 3. Synchroniser avec la base de données locale
            $user = $this->syncUserFromFirebase($decodedToken, $firebaseResult);
            
            // 4. Connecter l'utilisateur dans Laravel
            Auth::login($user);
            
            // 5. Stocker le token Firebase en session
            session(['firebase_token' => $firebaseResult['idToken']]);
            session(['firebase_refresh_token' => $firebaseResult['refreshToken']]);
            
            // 6. Rediriger selon le rôle
            return $this->redirectToDashboard($user);
            
        } catch (\Exception $e) {
            return back()->withErrors([
                'email' => 'Identifiants incorrects ou problème d\'authentification'
            ])->withInput();
        }
    }
    
    // Afficher le formulaire d'inscription
    public function showRegisterForm()
    {
        return view('auth.register');
    }
    
    // Traiter l'inscription
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users|ends_with:@ensat.ac.ma',
            'password' => 'required|min:8|confirmed',
            'role' => 'required|in:admin,etudiant'
        ]);
        
        try {
            // 1. Créer l'utilisateur dans Firebase
            $firebaseUser = $this->firebase->createUser(
                $request->email,
                $request->password,
                $request->name
            );
            
            // 2. Créer l'utilisateur dans la base de données locale
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'firebase_uid' => $firebaseUser['localId'],
                'role' => $request->role
            ]);
            
            // 3. Connecter automatiquement
            Auth::login($user);
            session(['firebase_token' => $firebaseUser['idToken']]);
            
            return redirect()->route('home')->with('success', 'Compte créé avec succès !');
            
        } catch (\Exception $e) {
            return back()->withErrors([
                'email' => 'Erreur lors de la création du compte: ' . $e->getMessage()
            ])->withInput();
        }
    }
    
    // Afficher le formulaire de réinitialisation
    public function showResetForm()
    {
        return view('auth.passwords.email');
    }
    
    // Envoyer l'email de réinitialisation
    public function sendResetLink(Request $request)
    {
        $request->validate(['email' => 'required|email']);
        
        try {
            $this->firebase->sendPasswordResetEmail($request->email);
            
            return back()->with('status', 
                'Un email de réinitialisation a été envoyé à ' . $request->email
            );
            
        } catch (\Exception $e) {
            return back()->withErrors([
                'email' => 'Erreur: ' . $e->getMessage()
            ]);
        }
    }
    
    // Déconnexion
    public function logout()
    {
        Auth::logout();
        session()->forget(['firebase_token', 'firebase_refresh_token']);
        
        return redirect('/');
    }
    
    // Synchroniser l'utilisateur Firebase avec la DB locale
    private function syncUserFromFirebase($decodedToken, $firebaseResult)
    {
        $firebaseUid = $decodedToken->user_id;
        $email = $decodedToken->email ?? $firebaseResult['email'];
        $name = $decodedToken->name ?? explode('@', $email)[0];
        
        return User::updateOrCreate(
            ['firebase_uid' => $firebaseUid],
            [
                'email' => $email,
                'name' => $name,
                'role' => 'etudiant' // Rôle par défaut
            ]
        );
    }
    
    // Redirection selon le rôle
    private function redirectToDashboard($user)
    {
        if ($user->isAdmin()) {
            return redirect()->route('etudiants.index');
        } else {
            return redirect()->route('home');
        }
    }
}