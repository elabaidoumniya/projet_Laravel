<?php

namespace App\Http\Controllers;

use App\Models\Etudiant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class EtudiantController extends Controller
{
    /**
     * Affiche la liste des étudiants
     */
    public function index(Request $request)
{
    $query = Etudiant::query();
    
    // Recherche
    if ($request->has('search')) {
        $search = $request->search;
        $query->where(function($q) use ($search) {
            $q->where('nom', 'like', "%{$search}%")
              ->orWhere('prenom', 'like', "%{$search}%")
              ->orWhere('cin', 'like', "%{$search}%")
              ->orWhere('email', 'like', "%{$search}%");
        });
    }
    
    // Filtre filière (spécial pour prépa)
    if ($request->has('filiere') && $request->filiere != '') {
        if ($request->filiere == 'prepa') {
            $query->whereIn('niveau', ['AP1', 'AP2']);
        } else {
            $query->where('filiere', $request->filiere);
        }
    }
    
    // Filtre niveau
    if ($request->has('niveau') && $request->niveau != '') {
        $query->where('niveau', $request->niveau);
    }
    
    $etudiants = $query->orderBy('nom')->paginate(10);
    
    return view('etudiants.index', compact('etudiants'));
}
    
    /**
     * Affiche le formulaire de création
     */
    public function create()
    {
        return view('etudiants.create');
    }
    
    /**
     * Enregistre un nouvel étudiant
     */
    public function store(Request $request)
{
    $rules = Etudiant::rules($request->niveau);
    $validated = $request->validate($rules, [
        'email.ends_with' => 'L\'email doit se terminer par @ensat.ac.ma ou @etu.uae.ac.ma.',
    ]);
    
    if (in_array($request->niveau, ['AP1', 'AP2'])) {
        $validated['filiere'] = null;
    }
    
    if ($request->hasFile('photo')) {
        $validated['photo'] = $request->file('photo')->store('etudiants', 'public');
    }
    
    Etudiant::create($validated);
    
    return redirect()->route('etudiants.index')
        ->with('success', 'Étudiant ajouté avec succès !');
}

public function update(Request $request, Etudiant $etudiant)
{
    $rules = Etudiant::rules($request->niveau);
    $rules['cin'] = 'required|size:8|unique:etudiants,cin,' . $etudiant->id;
    $rules['email'] = 'required|email|ends_with:@ensat.ac.ma,@etu.uae.ac.ma|unique:etudiants,email,' . $etudiant->id;
    
    $validated = $request->validate($rules, [
        'email.ends_with' => 'L\'email doit se terminer par @ensat.ac.ma ou @etu.uae.ac.ma.',
    ]);
    if (in_array($request->niveau, ['AP1', 'AP2'])) {
        $validated['filiere'] = null;
    }
    
    if ($request->hasFile('photo')) {
        if ($etudiant->photo) {
            Storage::disk('public')->delete($etudiant->photo);
        }
        $validated['photo'] = $request->file('photo')->store('etudiants', 'public');
    }
    
    $etudiant->update($validated);
    
    return redirect()->route('etudiants.index')
        ->with('success', 'Étudiant modifié avec succès !');
}

    /**
     * Affiche les détails d'un étudiant
     */
    public function show(Etudiant $etudiant)
{
    $user = Auth::user();
    
    // Si l'utilisateur est étudiant, vérifier qu'il voit son propre profil
    if ($user->isEtudiant()) {
        if ($user->etudiant_id !== $etudiant->id) {
            abort(403, 'Accès non autorisé. Vous ne pouvez voir que votre propre profil.');
        }
    }
    
    return view('etudiants.show', compact('etudiant'));
}
    /**
     * Affiche le formulaire d'édition
     */
    public function edit(Etudiant $etudiant)
    {
        return view('etudiants.edit', compact('etudiant'));
    }
    
    /**
     * Supprime un étudiant
     */
    public function destroy(Etudiant $etudiant)
    {
        if ($etudiant->photo) {
            Storage::disk('public')->delete($etudiant->photo);
        }
        
        $etudiant->delete();
        
        return redirect()->route('etudiants.index')
            ->with('success', 'Étudiant supprimé avec succès !');
    }
    
    /**
     * Export des données
     */
    public function export($format = 'csv')
    {
        $etudiants = Etudiant::all();
        
        if ($format === 'csv') {
            $filename = 'etudiants_ensat_' . date('Y-m-d') . '.csv';
            
            return response()->streamDownload(function() use ($etudiants) {
                $handle = fopen('php://output', 'w');
                
                fputcsv($handle, [
                    'CIN', 'Nom', 'Prénom', 'Email', 'Filière', 
                    'Niveau', 'Date Naissance', 'Téléphone', 'Adresse'
                ]);
                
                foreach ($etudiants as $etudiant) {
                    fputcsv($handle, [
                        $etudiant->cin,
                        $etudiant->nom,
                        $etudiant->prenom,
                        $etudiant->email,
                        $etudiant->filiere,
                        $etudiant->niveau,
                        $etudiant->date_naissance,
                        $etudiant->telephone,
                        $etudiant->adresse
                    ]);
                }
                
                fclose($handle);
            }, $filename);
        }
        
        return redirect()->route('etudiants.index')
            ->with('info', 'Format d\'export non supporté');
    }
    
    /**
     * Affiche le profil étudiant
     */
    public function monProfil()
    {
        $user = Auth::user();
        
        if (!$user->isEtudiant() || !$user->etudiant_id) {
            abort(403, 'Accès non autorisé');
        }
        
        $etudiant = Etudiant::findOrFail($user->etudiant_id);
        return view('etudiants.mon-profil', compact('etudiant'));
    }
    
    /**
     * Met à jour le profil étudiant
     */
    public function updateMonProfil(Request $request)
    {
        $user = Auth::user();
        
        if (!$user->isEtudiant() || !$user->etudiant_id) {
            abort(403, 'Accès non autorisé');
        }
        
        $etudiant = Etudiant::findOrFail($user->etudiant_id);
        
        $rules = [
            'telephone' => 'nullable|regex:/^[0-9]{10}$/',
            'adresse' => 'nullable|string|max:255',
            'photo' => 'nullable|image|max:2048',
        ];
        
        $validated = $request->validate($rules);
        
        if ($request->hasFile('photo')) {
            if ($etudiant->photo) {
                Storage::disk('public')->delete($etudiant->photo);
            }
            $validated['photo'] = $request->file('photo')->store('etudiants', 'public');
        }
        
        $etudiant->update($validated);
        
        return redirect()->route('etudiants.mon-profil')
            ->with('success', 'Profil mis à jour avec succès !');
    }
}