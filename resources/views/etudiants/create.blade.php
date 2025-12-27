{{-- resources/views/etudiants/create.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card shadow-lg border-0">
                <div class="card-header bg-gradient-primary text-white py-3">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-user-plus fa-2x me-3"></i>
                        <div>
                            <h2 class="h4 mb-0">Ajouter un Nouvel Étudiant</h2>
                            <small class="opacity-75">Remplissez tous les champs obligatoires (*)</small>
                        </div>
                    </div>
                </div>
                
                <div class="card-body p-4">
                    <form action="{{ route('etudiants.store') }}" method="POST" enctype="multipart/form-data" id="etudiantForm">
                        @csrf
                        
                        <div class="row g-4">
                            <!-- Informations d'identité -->
                            <div class="col-md-6">
                                <h5 class="mb-3 text-primary border-bottom pb-2">
                                    <i class="fas fa-id-card me-2"></i>Informations d'Identité
                                </h5>
                                
                                <div class="mb-3">
                                    <label for="cin" class="form-label fw-bold">
                                        <i class="fas fa-id-badge me-1"></i>CIN *
                                    </label>
                                    <input type="text" class="form-control form-control-lg @error('cin') is-invalid @enderror"
                                           id="cin" name="cin" value="{{ old('cin') }}" required
                                           maxlength="8" placeholder="Ex: AB123456">
                                    <div class="form-text">Format: 2 lettres + 6 chiffres</div>
                                    @error('cin')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="nom" class="form-label fw-bold">
                                        <i class="fas fa-user me-1"></i>Nom *
                                    </label>
                                    <input type="text" class="form-control @error('nom') is-invalid @enderror"
                                           id="nom" name="nom" value="{{ old('nom') }}" required>
                                    @error('nom')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="prenom" class="form-label fw-bold">
                                        <i class="fas fa-user me-1"></i>Prénom *
                                    </label>
                                    <input type="text" class="form-control @error('prenom') is-invalid @enderror"
                                           id="prenom" name="prenom" value="{{ old('prenom') }}" required>
                                    @error('prenom')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="date_naissance" class="form-label fw-bold">
                                        <i class="fas fa-birthday-cake me-1"></i>Date de naissance *
                                    </label>
                                    <input type="date" class="form-control @error('date_naissance') is-invalid @enderror"
                                           id="date_naissance" name="date_naissance" 
                                           value="{{ old('date_naissance') }}" required>
                                    @error('date_naissance')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Informations académiques -->
                            <div class="col-md-6">
                                <h5 class="mb-3 text-primary border-bottom pb-2">
                                    <i class="fas fa-graduation-cap me-2"></i>Informations Académiques
                                </h5>
                                
                                <div class="mb-3">
                                    <label for="email" class="form-label fw-bold">
                                        <i class="fas fa-envelope me-1"></i>Email ENSAT *
                                    </label>
                                    <input type="email" class="form-control @error('email') is-invalid @enderror"
                                           id="email" name="email" value="{{ old('email') }}" required 
                                           placeholder="exemple@ensat.ac.ma">
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="niveau" class="form-label fw-bold">
                                        <i class="fas fa-layer-group me-1"></i>Niveau *
                                    </label>
                                    <select id="niveau" class="form-control @error('niveau') is-invalid @enderror" 
                                            name="niveau" required onchange="toggleFiliere()">
                                        <option value="">Sélectionner un niveau</option>
                                        <option value="AP1" {{ old('niveau') == 'AP1' ? 'selected' : '' }}>Année Préparatoire 1 (AP1)</option>
                                        <option value="AP2" {{ old('niveau') == 'AP2' ? 'selected' : '' }}>Année Préparatoire 2 (AP2)</option>
                                        <option value="1AC" {{ old('niveau') == '1AC' ? 'selected' : '' }}>1ère Année Cycle (1AC)</option>
                                        <option value="2AC" {{ old('niveau') == '2AC' ? 'selected' : '' }}>2ème Année Cycle (2AC)</option>
                                        <option value="3AC" {{ old('niveau') == '3AC' ? 'selected' : '' }}>3ème Année Cycle (3AC)</option>
                                    </select>
                                    @error('niveau')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3" id="filiereField">
                                    <label for="filiere" class="form-label fw-bold">
                                        <i class="fas fa-university me-1"></i>Filière
                                        <span id="filiereRequired">*</span>
                                    </label>
                                    <select id="filiere" class="form-control @error('filiere') is-invalid @enderror" 
                                            name="filiere">
                                        <option value="">Sélectionner une filière</option>
                                        <option value="GINF" {{ old('filiere') == 'GINF' ? 'selected' : '' }}>Génie Informatique (GINF)</option>
                                        <option value="GINDUS" {{ old('filiere') == 'GINDUS' ? 'selected' : '' }}>Génie Industriel (GINDUS)</option>
                                        <option value="GCYBER" {{ old('filiere') == 'GCYBER' ? 'selected' : '' }}>Génie Cybersécurité (GCYBER)</option>
                                        <option value="G2EI" {{ old('filiere') == 'G2EI' ? 'selected' : '' }}>Génie Énergétique (G2EI)</option>
                                        <option value="GSR" {{ old('filiere') == 'GSR' ? 'selected' : '' }}>Génie Systèmes Réseaux (GSR)</option>
                                    </select>
                                    <div class="form-text" id="filiereHelp"></div>
                                    @error('filiere')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="photo" class="form-label fw-bold">
                                        <i class="fas fa-camera me-1"></i>Photo
                                    </label>
                                    <div class="input-group">
                                        <input type="file" class="form-control @error('photo') is-invalid @enderror" 
                                               id="photo" name="photo" accept="image/*">
                                        <label class="input-group-text" for="photo">
                                            <i class="fas fa-upload"></i>
                                        </label>
                                    </div>
                                    <div class="form-text">Format: JPG, PNG (max 2MB)</div>
                                    @error('photo')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Informations de contact -->
                            <div class="col-12">
                                <h5 class="mb-3 text-primary border-bottom pb-2">
                                    <i class="fas fa-address-book me-2"></i>Informations de Contact
                                </h5>
                                
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label for="telephone" class="form-label fw-bold">
                                            <i class="fas fa-phone me-1"></i>Téléphone
                                        </label>
                                        <input type="text" class="form-control @error('telephone') is-invalid @enderror"
                                               id="telephone" name="telephone" value="{{ old('telephone') }}"
                                               placeholder="06XXXXXXXX">
                                        <div class="form-text">Format: 10 chiffres</div>
                                        @error('telephone')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    
                                    <div class="col-md-6">
                                        <label for="adresse" class="form-label fw-bold">
                                            <i class="fas fa-map-marker-alt me-1"></i>Adresse
                                        </label>
                                        <textarea id="adresse" class="form-control @error('adresse') is-invalid @enderror" 
                                                  name="adresse" rows="2" placeholder="Adresse complète">{{ old('adresse') }}</textarea>
                                        @error('adresse')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Boutons d'action -->
                        <div class="d-flex justify-content-between align-items-center mt-4 pt-3 border-top">
                            <a href="{{ route('etudiants.index') }}" class="btn btn-outline-secondary">
                                <i class="fas fa-arrow-left me-1"></i> Retour à la liste
                            </a>
                            
                            <div class="d-flex gap-2">
                                <button type="reset" class="btn btn-outline-danger">
                                    <i class="fas fa-redo me-1"></i> Réinitialiser
                                </button>
                                <button type="submit" class="btn btn-primary btn-lg px-4">
                                    <i class="fas fa-save me-1"></i> Enregistrer l'étudiant
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function toggleFiliere() {
    const niveau = document.getElementById('niveau').value;
    const filiereField = document.getElementById('filiere');
    const filiereRequired = document.getElementById('filiereRequired');
    const filiereHelp = document.getElementById('filiereHelp');
    
    if (niveau === 'AP1' || niveau === 'AP2') {
        // Année préparatoire - filière non obligatoire
        filiereField.required = false;
        filiereField.disabled = true;
        filiereField.value = '';
        filiereRequired.style.display = 'none';
        filiereHelp.innerHTML = '<i class="fas fa-info-circle text-info me-1"></i>Non applicable pour les années préparatoires';
        filiereHelp.className = 'form-text text-info';
    } else if (niveau === '1AC' || niveau === '2AC' || niveau === '3AC') {
        // Cycle ingénieur - filière obligatoire
        filiereField.required = true;
        filiereField.disabled = false;
        filiereRequired.style.display = 'inline';
        filiereHelp.innerHTML = '<i class="fas fa-info-circle text-primary me-1"></i>Sélectionnez la spécialité';
        filiereHelp.className = 'form-text text-primary';
    } else {
        // Aucun niveau sélectionné
        filiereField.required = false;
        filiereField.disabled = true;
        filiereField.value = '';
        filiereRequired.style.display = 'inline';
        filiereHelp.innerHTML = '';
    }
}

// Initialiser au chargement
document.addEventListener('DOMContentLoaded', function() {
    toggleFiliere();
    
    // Format automatique du CIN
    document.getElementById('cin').addEventListener('input', function(e) {
        this.value = this.value.toUpperCase().replace(/[^A-Z0-9]/g, '');
    });
    
    // Format automatique du téléphone
    document.getElementById('telephone').addEventListener('input', function(e) {
        this.value = this.value.replace(/[^0-9]/g, '');
    });
});
</script>

<style>
.card {
    border-radius: 15px;
    overflow: hidden;
}

.card-header {
    border-radius: 15px 15px 0 0 !important;
}

.form-control, .form-select {
    border-radius: 8px;
    padding: 0.75rem 1rem;
    border: 2px solid #e0e0e0;
    transition: all 0.3s;
}

.form-control:focus, .form-select:focus {
    border-color: #4e73df;
    box-shadow: 0 0 0 0.25rem rgba(78, 115, 223, 0.25);
}

.form-control-lg {
    font-size: 1.1rem;
}

.btn-primary {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border: none;
    border-radius: 10px;
    padding: 0.75rem 2rem;
    font-weight: 600;
    transition: all 0.3s;
}

.btn-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
}

.btn-outline-secondary, .btn-outline-danger {
    border-radius: 10px;
    padding: 0.75rem 1.5rem;
    font-weight: 500;
}

h5 {
    font-weight: 600;
}

.form-label {
    font-weight: 500;
    margin-bottom: 0.5rem;
}

.border-bottom {
    border-bottom: 2px solid #e0e0e0 !important;
}

.form-text {
    font-size: 0.85rem;
    margin-top: 0.25rem;
}
</style>
@endsection