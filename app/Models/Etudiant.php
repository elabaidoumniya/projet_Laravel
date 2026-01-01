<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Etudiant extends Model
{
    use HasFactory;

    protected $fillable = [
        'cin', 'nom', 'prenom', 'email', 'filiere', 'niveau',
        'date_naissance', 'photo', 'telephone', 'adresse', 'user_id'
    ];

    // Règles de validation conditionnelles
    public static function rules($niveau = null)
    {
        $rules = [
            'cin' => 'required|size:8|unique:etudiants,cin',
            'nom' => 'required|string|max:50',
            'prenom' => 'required|string|max:50',
            'email' => 'required|email|ends_with:@ensat.ac.ma,@etu.uae.ac.ma|unique:etudiants,email',
            'niveau' => 'required|in:AP1,AP2,1AC,2AC,3AC',
            'date_naissance' => 'required|date|before:today',
            'telephone' => 'nullable|regex:/^[0-9]{10}$/',
            'adresse' => 'nullable|string|max:255',
            'photo' => 'nullable|image|max:2048',
        ];

        // La filière est obligatoire seulement pour les années de cycle
        if ($niveau && in_array($niveau, ['1AC', '2AC', '3AC'])) {
            $rules['filiere'] = 'required|in:GINF,GINDUS,GCYBER,G2EI,GSR';
        } else {
            $rules['filiere'] = 'nullable|in:GINF,GINDUS,GCYBER,G2EI,GSR';
        }

        return $rules;
    }

    // Accessor pour nom complet
    public function getNomCompletAttribute()
    {
        return $this->nom . ' ' . $this->prenom;
    }

    // Accessor pour l'âge
    public function getAgeAttribute()
    {
        return \Carbon\Carbon::parse($this->date_naissance)->age;
    }

    // Relation avec l'utilisateur
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}