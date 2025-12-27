<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Etudiant;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class RegisterController extends Controller
{
    use RegistersUsers;

    protected $redirectTo = '/home';

    public function __construct()
    {
        $this->middleware('guest');
    }

    protected function validator(array $data)
    {
        $rules = [
            'nom' => ['required', 'string', 'max:100'],
            'prenom' => ['required', 'string', 'max:100'],
            'email' => [
                'required', 
                'string', 
                'email', 
                'max:255', 
                'unique:users',
                'regex:/@ensat\.ac\.ma$/'
            ],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'role' => ['required', 'in:admin,etudiant'],
        ];

        // Si étudiant, on vérifie que l'email existe dans la table etudiants
        if ($data['role'] === 'etudiant') {
            $rules['email'][] = Rule::exists('etudiants', 'email');
        }

        return Validator::make($data, $rules);
    }

    protected function create(array $data)
    {
        if ($data['role'] === 'etudiant') {
            // Trouver l'étudiant existant par email
            $etudiant = Etudiant::where('email', $data['email'])->first();
            
            if (!$etudiant) {
                // Rediriger avec erreur
                return redirect()->back()
                    ->withInput()
                    ->withErrors(['email' => 'Aucun étudiant trouvé avec cet email. Contactez l\'administration.']);
            }
            
            // Vérifier que l'étudiant n'a pas déjà de compte
            if ($etudiant->user_id) {
                return redirect()->back()
                    ->withInput()
                    ->withErrors(['email' => 'Cet étudiant a déjà un compte. Connectez-vous.']);
            }
            
            // Créer l'utilisateur avec la référence à l'étudiant
            $user = User::create([
                'name' => $data['nom'] . ' ' . $data['prenom'],
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
                'role' => $data['role'],
                'etudiant_id' => $etudiant->id,
            ]);
            
            // Mettre à jour l'étudiant avec l'ID de l'utilisateur
            $etudiant->update(['user_id' => $user->id]);
            
            return $user;
        }

        // Si admin
        return User::create([
            'name' => $data['nom'] . ' ' . $data['prenom'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'role' => $data['role'],
        ]);
    }
}