<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $user = Auth::user();
        
        if ($user->isAdmin()) {
            // Admin: rediriger vers la liste des étudiants
            return redirect()->route('etudiants.index');
        } elseif ($user->isEtudiant()) {
            // Étudiant: rediriger vers son profil
            if ($user->etudiant_id) {
                return redirect()->route('etudiants.mon-profil');
            } else {
                return redirect()->route('profile.edit');
            }
        }
        
        return view('home');
    }
}