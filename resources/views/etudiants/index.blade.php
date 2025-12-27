@extends('layouts.app')

@section('content')
<div class="row mb-4">
    <div class="col-md-8">
        <h1><i class="fas fa-users"></i> Gestion des Étudiants ENSAT</h1>
        <p class="text-muted">Liste des étudiants inscrits à l'école</p>
    </div>
    @if(auth()->user()->isAdmin())
    <div class="col-md-4 text-end">
        <a href="{{ route('etudiants.ajouter') }}" class="btn btn-ensat">
            <i class="fas fa-user-plus"></i> Ajouter un étudiant
        </a>
        <a href="{{ route('etudiants.export', 'csv') }}" class="btn btn-success">
            <i class="fas fa-download"></i> Exporter CSV
        </a>
    </div>
    @endif
</div>

<!-- Filtres et recherche -->
<div class="card mb-4">
    <div class="card-body">
        <form method="GET" action="{{ route('etudiants.index') }}">
            <div class="row g-3">
                <div class="col-md-4">
                    <input type="text" class="form-control" name="search" 
                           placeholder="Rechercher par nom, prénom, CIN ou email..."
                           value="{{ request('search') }}">
                </div>
                <div class="col-md-3">
    <select class="form-control" name="filiere">
        <option value="">Toutes les filières</option>
        <option value="prepa" {{ request('filiere') == 'prepa' ? 'selected' : '' }}>Année Préparatoire</option>
        <option value="GINF" {{ request('filiere') == 'GINF' ? 'selected' : '' }}>GINF</option>
        <option value="GINDUS" {{ request('filiere') == 'GINDUS' ? 'selected' : '' }}>GINDUS</option>
        <option value="GCYBER" {{ request('filiere') == 'GCYBER' ? 'selected' : '' }}>GCYBER</option>
        <option value="G2EI" {{ request('filiere') == 'G2EI' ? 'selected' : '' }}>G2EI</option>
        <option value="GSR" {{ request('filiere') == 'GSR' ? 'selected' : '' }}>GSR</option>
    </select>
</div>
                <div class="col-md-3">
                    <select class="form-control" name="niveau">
                        <option value="">Tous les niveaux</option>
                        <option value="AP1" {{ request('niveau') == 'AP1' ? 'selected' : '' }}>AP1</option>
                        <option value="AP2" {{ request('niveau') == 'AP2' ? 'selected' : '' }}>AP2</option>
                        <option value="1AC" {{ request('niveau') == '1AC' ? 'selected' : '' }}>1AC</option>
                        <option value="2AC" {{ request('niveau') == '2AC' ? 'selected' : '' }}>2AC</option>
                        <option value="3AC" {{ request('niveau') == '3AC' ? 'selected' : '' }}>3AC</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-ensat w-100">
                        <i class="fas fa-filter"></i> Filtrer
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Tableau des étudiants -->
<div class="card">
    <div class="card-header card-header-ensat">
        <h5 class="mb-0"><i class="fas fa-list"></i> Liste des Étudiants</h5>
    </div>
    <div class="card-body">
        @if($etudiants->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>CIN</th>
                            <th>Nom Complet</th>
                            <th>Email</th>
                            <th>Filière</th>
                            <th>Niveau</th>
                            <th>Âge</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($etudiants as $etudiant)
                        <tr>
                            <td>{{ $loop->iteration + ($etudiants->currentPage() - 1) * $etudiants->perPage() }}</td>
                            <td><strong>{{ $etudiant->cin }}</strong></td>
                            <td>
                                @if($etudiant->photo)
                                    <img src="{{ asset('storage/' . $etudiant->photo) }}" 
                                         alt="Photo" class="rounded-circle me-2" width="40" height="40">
                                @else
                                    <i class="fas fa-user-circle fa-2x text-secondary me-2"></i>
                                @endif
                                {{ $etudiant->nom_complet }}
                            </td>
                            <td>{{ $etudiant->email }}</td>
                            <td>
                                <td>
    @if(in_array($etudiant->niveau, ['AP1', 'AP2']))
        <span class="badge bg-secondary">Année Préparatoire</span>
    @else
        <span class="badge bg-info">{{ $etudiant->filiere }}</span>
    @endif
</td>
                            </td>
                            <td>
                                <span class="badge bg-secondary">{{ $etudiant->niveau }}</span>
                            </td>
                            <td>{{ $etudiant->age }} ans</td>
                            <td>
                                <a href="{{ route('etudiants.show', $etudiant->id) }}" 
                                   class="btn btn-sm btn-info" title="Voir">
                                    <i class="fas fa-eye"></i>
                                </a>
                                
                                @if(auth()->user()->isAdmin())
                                <a href="{{ route('etudiants.edit', $etudiant->id) }}" 
                                   class="btn btn-sm btn-warning" title="Modifier">
                                    <i class="fas fa-edit"></i>
                                </a>
                                
                                <form action="{{ route('etudiants.destroy', $etudiant->id) }}" 
                                      method="POST" class="d-inline"
                                      onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cet étudiant ?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" title="Supprimer">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            <!-- Pagination -->
            <div class="d-flex justify-content-center">
                {{ $etudiants->appends(request()->query())->links() }}
            </div>
            
            <!-- Statistiques -->
            <div class="mt-3 text-muted">
                <small>
                    <i class="fas fa-info-circle"></i> 
                    Affichage de {{ $etudiants->firstItem() }} à {{ $etudiants->lastItem() }} 
                    sur {{ $etudiants->total() }} étudiants
                </small>
            </div>
            
        @else
            <div class="text-center py-5">
                <i class="fas fa-user-slash fa-4x text-muted mb-3"></i>
                <h4>Aucun étudiant trouvé</h4>
                <p class="text-muted">Aucun étudiant ne correspond à vos critères de recherche.</p>
                @if(auth()->user()->isAdmin())
                    <a href="{{ route('etudiants.create') }}" class="btn btn-ensat">
                        <i class="fas fa-user-plus"></i> Ajouter le premier étudiant
                    </a>
                @endif
            </div>
        @endif
    </div>
</div>
@endsection