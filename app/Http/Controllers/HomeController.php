<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        if (auth()->check()) {
            if (auth()->user()->isAdmin()) {
                return redirect()->route('etudiants.index');
            } elseif (auth()->user()->isEtudiant()) {
                return redirect()->route('etudiants.mon-profil');
            }
        }
        
        return view('home');
    }
}