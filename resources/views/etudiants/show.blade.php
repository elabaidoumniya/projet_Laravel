@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-md-8 offset-md-2">
        <div class="card">
            <div class="card-header card-header-ensat">
                <div class="d-flex justify-content-between align-items-center">
                    <h4 class="mb-0"><i class="fas fa-user-graduate"></i> Détails de l'Étudiant</h4>
                    <div>
                        <a href="{{ route('etudiants.index') }}" class="btn btn-light btn-sm">
                            <i class="fas fa-arrow-left"></i> Retour
                        </a>
                        @if(auth()->user()->isAdmin())
                            <a href="{{ route('etudiants.edit', $etudiant->id) }}" class="btn btn-warning btn-sm">
                                <i class="fas fa-edit"></i> Modifier
                            </a>
                        @endif
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <!-- Photo -->
                    <div class="col-md-4 text-center">
                        @if($etudiant->photo)
                            <img src="{{ asset('storage/' . $etudiant->photo) }}" 
                                 alt="Photo de {{ $etudiant->nom_complet }}"
                                 class="img-fluid rounded-circle mb-3" style="max-width: 200px;">
                        @else
                            <div class="mb-3">
                                <i class="fas fa-user-circle fa-10x text-secondary"></i>
                            </div>
                        @endif
                        <h3>{{ $etudiant->nom_complet }}</h3>
                        <p class="text-muted">{{ $etudiant->age }} ans</p>
                    </div>
                    
                    <!-- Informations -->
                    <div class="col-md-8">
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <h6><i class="fas fa-id-card text-primary"></i> CIN</h6>
                                <p class="fs-5">{{ $etudiant->cin }}</p>
                            </div>
                            <div class="col-md-6">
                                <h6><i class="fas fa-envelope text-primary"></i> Email</h6>
                                <p class="fs-5">{{ $etudiant->email }}</p>
                            </div>
                        </div>
                        
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <h6><i class="fas fa-graduation-cap text-primary"></i> Filière</h6>
                                <span class="badge bg-info fs-6">{{ $etudiant->filiere }}</span>
                            </div>
                            <div class="col-md-6">
                                <h6><i class="fas fa-layer-group text-primary"></i> Niveau</h6>
                                <span class="badge bg-secondary fs-6">{{ $etudiant->niveau }}</span>
                            </div>
                        </div>
                        
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <h6><i class="fas fa-birthday-cake text-primary"></i> Date de Naissance</h6>
                                <p>{{ \Carbon\Carbon::parse($etudiant->date_naissance)->format('d/m/Y') }}</p>
                            </div>
                            <div class="col-md-6">
                                <h6><i class="fas fa-phone text-primary"></i> Téléphone</h6>
                                <p>{{ $etudiant->telephone ?: 'Non renseigné' }}</p>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-12">
                                <h6><i class="fas fa-map-marker-alt text-primary"></i> Adresse</h6>
                                <p>{{ $etudiant->adresse ?: 'Non renseignée' }}</p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Statistiques supplémentaires -->
                <div class="mt-4 pt-4 border-top">
                    <div class="row text-center">
                        <div class="col-md-3">
                            <div class="p-3 bg-light rounded">
                                <i class="fas fa-calendar fa-2x text-primary mb-2"></i>
                                <h5>Inscription</h5>
                                <p>{{ $etudiant->created_at->format('d/m/Y') }}</p>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="p-3 bg-light rounded">
                                <i class="fas fa-sync-alt fa-2x text-success mb-2"></i>
                                <h5>Dernière mise à jour</h5>
                                <p>{{ $etudiant->updated_at->format('d/m/Y') }}</p>
                            </div>
                        </div>
                        @if($etudiant->user)
                        <div class="col-md-3">
                            <div class="p-3 bg-light rounded">
                                <i class="fas fa-user-circle fa-2x text-warning mb-2"></i>
                                <h5>Compte utilisateur</h5>
                                <p>Actif</p>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection