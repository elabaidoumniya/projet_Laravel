@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-md-8 offset-md-2">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h3 class="mb-0"><i class="fas fa-user"></i> Mon Profil Étudiant</h3>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4 text-center">
                        @if($etudiant->photo)
                            <img src="{{ asset('storage/' . $etudiant->photo) }}" 
                                 alt="Photo de profil"
                                 class="img-fluid rounded-circle mb-3" style="max-width: 200px;">
                        @else
                            <div class="mb-3">
                                <i class="fas fa-user-circle fa-10x text-secondary"></i>
                            </div>
                        @endif
                        <h4>{{ $etudiant->nom_complet }}</h4>
                        <p class="text-muted">{{ $etudiant->filiere }} - {{ $etudiant->niveau }}</p>
                    </div>
                    
                    <div class="col-md-8">
                        <form action="{{ route('etudiants.update-mon-profil') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="nom" class="form-label">Nom *</label>
                                    <input type="text" class="form-control" id="nom" 
                                           value="{{ $etudiant->nom }}" disabled>
                                </div>
                                <div class="col-md-6">
                                    <label for="prenom" class="form-label">Prénom *</label>
                                    <input type="text" class="form-control" id="prenom" 
                                           value="{{ $etudiant->prenom }}" disabled>
                                </div>
                            </div>
                            
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="cin" class="form-label">CIN *</label>
                                    <input type="text" class="form-control" id="cin" 
                                           value="{{ $etudiant->cin }}" disabled>
                                </div>
                                <div class="col-md-6">
                                    <label for="email" class="form-label">Email *</label>
                                    <input type="email" class="form-control" id="email" 
                                           value="{{ $etudiant->email }}" disabled>
                                </div>
                            </div>
                            
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="filiere" class="form-label">Filière *</label>
                                    <input type="text" class="form-control" id="filiere" 
                                           value="{{ $etudiant->filiere }}" disabled>
                                </div>
                                <div class="col-md-6">
                                    <label for="niveau" class="form-label">Niveau *</label>
                                    <input type="text" class="form-control" id="niveau" 
                                           value="{{ $etudiant->niveau }}" disabled>
                                </div>
                            </div>
                            
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="telephone" class="form-label">Téléphone</label>
                                    <input type="text" class="form-control @error('telephone') is-invalid @enderror" 
                                           id="telephone" name="telephone" 
                                           value="{{ old('telephone', $etudiant->telephone) }}">
                                    @error('telephone')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label for="photo" class="form-label">Photo</label>
                                    <input type="file" class="form-control @error('photo') is-invalid @enderror" 
                                           id="photo" name="photo" accept="image/*">
                                    @error('photo')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="mb-3">
                                <label for="adresse" class="form-label">Adresse</label>
                                <textarea class="form-control @error('adresse') is-invalid @enderror" 
                                          id="adresse" name="adresse" rows="3">{{ old('adresse', $etudiant->adresse) }}</textarea>
                                @error('adresse')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                <a href="{{ route('etudiants.index') }}" class="btn btn-secondary me-md-2">
                                    <i class="fas fa-arrow-left"></i> Retour
                                </a>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save"></i> Mettre à jour mon profil
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection