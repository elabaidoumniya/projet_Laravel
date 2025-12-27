<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Etudiant;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run()
    {
        // Créer un admin (sans etudiant_id)
        User::create([
            'name' => 'Administrateur',
            'email' => 'admin@ensat.ac.ma',
            'password' => Hash::make('admin123'),
            'role' => 'admin'
        ]);

     
$etudiant1 = Etudiant::create([
    'cin' => 'AB123456',
    'nom' => 'Dupont',
    'prenom' => 'Jean',
    'email' => 'jean.dupont@ensat.ac.ma',
    'filiere' => 'GINF',
    'niveau' => '2AC',
    'date_naissance' => '2000-01-01',
]);

$etudiant2 = Etudiant::create([
    'cin' => 'CD789012',
    'nom' => 'Martin',
    'prenom' => 'Sophie',
    'email' => 'sophie.martin@ensat.ac.ma',
    'filiere' => 'GINDUS',
    'niveau' => '3AC',
    'date_naissance' => '1999-05-15',
]);

        // Créer des utilisateurs étudiants
        User::create([
            'name' => 'Jean Dupont',
            'email' => 'etudiant1@ensat.ac.ma',
            'password' => Hash::make('etudiant123'),
            'role' => 'etudiant',
            'etudiant_id' => $etudiant1->id
        ]);

        User::create([
            'name' => 'Sophie Martin',
            'email' => 'etudiant2@ensat.ac.ma',
            'password' => Hash::make('etudiant456'),
            'role' => 'etudiant',
            'etudiant_id' => $etudiant2->id
        ]);
    }
}