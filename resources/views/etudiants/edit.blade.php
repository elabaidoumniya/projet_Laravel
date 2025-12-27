{{-- resources/views/etudiants/edit.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-md-8 offset-md-2">
        <div class="card">
            <div class="card-header bg-warning">
                <h3 class="mb-0">Modifier l'Étudiant</h3>
            </div>
            <div class="card-body">
                <form action="{{ route('etudiants.update', $etudiant->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    
                    <div class="form-group">
                        <label for="cin">CIN *</label>
                        <input type="text" class="form-control @error('cin') is-invalid @enderror"
                               id="cin" name="cin" value="{{ old('cin', $etudiant->cin) }}" required maxlength="8">
                        @error('cin')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="nom">Nom *</label>
                        <input type="text" class="form-control @error('nom') is-invalid @enderror"
                               id="nom" name="nom" value="{{ old('nom', $etudiant->nom) }}" required>
                        @error('nom')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="prenom">Prénom *</label>
                        <input type="text" class="form-control @error('prenom') is-invalid @enderror"
                               id="prenom" name="prenom" value="{{ old('prenom', $etudiant->prenom) }}" required>
                        @error('prenom')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="email">Email ENSAT *</label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror"
                               id="email" name="email" value="{{ old('email', $etudiant->email) }}" required 
                               placeholder="exemple@ensat.ac.ma">
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
    <label for="filiere">Filière *</label>
    <select id="filiere" class="form-control @error('filiere') is-invalid @enderror" 
            name="filiere" required>
        <option value="">Sélectionner une filière</option>
        <option value="GINF" {{ old('filiere', $etudiant->filiere) == 'GINF' ? 'selected' : '' }}>Génie Informatique (GINF)</option>
        <option value="GINDUS" {{ old('filiere', $etudiant->filiere) == 'GINDUS' ? 'selected' : '' }}>Génie Industriel (GINDUS)</option>
        <option value="GCYBER" {{ old('filiere', $etudiant->filiere) == 'GCYBER' ? 'selected' : '' }}>Génie Cybersécurité (GCYBER)</option>
        <option value="G2EI" {{ old('filiere', $etudiant->filiere) == 'G2EI' ? 'selected' : '' }}>Génie Énergétique (G2EI)</option>
        <option value="GSR" {{ old('filiere', $etudiant->filiere) == 'GSR' ? 'selected' : '' }}>Génie Systèmes Réseaux (GSR)</option>
    </select>
    @error('filiere')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>
                   <div class="form-group">
    <label for="niveau">Niveau *</label>
    <select id="niveau" class="form-control @error('niveau') is-invalid @enderror" 
            name="niveau" required>
        <option value="">Sélectionner un niveau</option>
        <option value="AP1" {{ old('niveau', $etudiant->niveau) == 'AP1' ? 'selected' : '' }}>Année Préparatoire 1 (AP1)</option>
        <option value="AP2" {{ old('niveau', $etudiant->niveau) == 'AP2' ? 'selected' : '' }}>Année Préparatoire 2 (AP2)</option>
        <option value="1AC" {{ old('niveau', $etudiant->niveau) == '1AC' ? 'selected' : '' }}>1ère Année Cycle (1AC)</option>
        <option value="2AC" {{ old('niveau', $etudiant->niveau) == '2AC' ? 'selected' : '' }}>2ème Année Cycle (2AC)</option>
        <option value="3AC" {{ old('niveau', $etudiant->niveau) == '3AC' ? 'selected' : '' }}>3ème Année Cycle (3AC)</option>
    </select>
    @error('niveau')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>
                    <div class="form-group">
                        <label for="date_naissance">Date de naissance *</label>
                        <input type="date" class="form-control @error('date_naissance') is-invalid @enderror"
                               id="date_naissance" name="date_naissance" value="{{ old('date_naissance', $etudiant->date_naissance) }}" required>
                        @error('date_naissance')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="telephone">Téléphone</label>
                        <input type="text" class="form-control @error('telephone') is-invalid @enderror"
                               id="telephone" name="telephone" value="{{ old('telephone', $etudiant->telephone) }}">
                        @error('telephone')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="adresse">Adresse</label>
                        <textarea id="adresse" class="form-control @error('adresse') is-invalid @enderror" 
                                  name="adresse" rows="3">{{ old('adresse', $etudiant->adresse) }}</textarea>
                        @error('adresse')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="photo">Photo</label>
                        @if($etudiant->photo)
                            <div class="mb-2">
                                <img src="{{ asset('storage/' . $etudiant->photo) }}" alt="Photo" 
                                     class="img-thumbnail" style="max-width: 150px;">
                                <br>
                                <small>Photo actuelle</small>
                            </div>
                        @endif
                        <input type="file" class="form-control-file @error('photo') is-invalid @enderror" 
                               id="photo" name="photo" accept="image/*">
                        @error('photo')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group mt-4">
                        <button type="submit" class="btn btn-warning">
                            <i class="fas fa-edit"></i> Modifier
                        </button>
                        <a href="{{ route('etudiants.index') }}" class="btn btn-secondary">
                            <i class="fas fa-times"></i> Annuler
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection