@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header bg-success text-white">
                    <h4 class="mb-0">📝 Création de Compte</h4>
                </div>

                <div class="card-body">
                    <form method="POST" action="{{ route('register') }}" id="registerForm">
                        @csrf

                        <!-- Informations personnelles -->
                        <h6 class="mb-3 text-primary">👤 Informations Personnelles</h6>
                        
                        <div class="row mb-3">
                            <label for="nom" class="col-md-4 col-form-label text-md-end">Nom *</label>
                            <div class="col-md-6">
                                <input id="nom" type="text" class="form-control @error('nom') is-invalid @enderror" 
                                       name="nom" value="{{ old('nom') }}" required autocomplete="family-name" autofocus>
                                @error('nom')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="prenom" class="col-md-4 col-form-label text-md-end">Prénom *</label>
                            <div class="col-md-6">
                                <input id="prenom" type="text" class="form-control @error('prenom') is-invalid @enderror" 
                                       name="prenom" value="{{ old('prenom') }}" required autocomplete="given-name">
                                @error('prenom')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="email" class="col-md-4 col-form-label text-md-end">Email ENSAT *</label>
                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" 
                                       name="email" value="{{ old('email') }}" required autocomplete="email"
                                       placeholder="prenom.nom@ensat.ac.ma">
                                <small class="form-text text-muted">Doit se terminer par @ensat.ac.ma</small>
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <!-- Authentification -->
                        <h6 class="mb-3 mt-4 text-primary">🔐 Authentification</h6>
                        
                        <div class="row mb-3">
                            <label for="password" class="col-md-4 col-form-label text-md-end">Mot de passe *</label>
                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" 
                                       name="password" required autocomplete="new-password">
                                <small class="form-text text-muted">Minimum 8 caractères</small>
                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-end">Confirmation *</label>
                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" 
                                       name="password_confirmation" required autocomplete="new-password">
                            </div>
                        </div>

                        <!-- Type de compte -->
                        <h6 class="mb-3 mt-4 text-primary">👥 Type de Compte</h6>
                        
                        <div class="row mb-4">
                            <label for="role" class="col-md-4 col-form-label text-md-end">Rôle *</label>
                            <div class="col-md-6">
                                <select id="role" class="form-control @error('role') is-invalid @enderror" 
                                        name="role" required onchange="toggleStudentFields()">
                                    <option value="">Sélectionnez un rôle</option>
                                    <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Administrateur</option>
                                    <option value="etudiant" {{ old('role') == 'etudiant' ? 'selected' : '' }}>Étudiant</option>
                                </select>
                                @error('role')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <!-- SECTION ÉTUDIANT -->
                        <div id="studentFields" style="display: none;">
                            <div class="alert alert-info mb-3">
                                <i class="fas fa-info-circle"></i>
                                <strong>Important :</strong> Votre email doit correspondre à celui utilisé 
                                par l'administrateur lors de votre inscription à l'école.
                                Si vous avez un problème, contactez l'administration.
                            </div>
                        </div>

                        <!-- Boutons -->
                        <div class="row mb-0 mt-4">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-success px-4">
                                    <i class="fas fa-user-plus"></i> Créer le compte
                                </button>
                                
                                <a href="{{ route('login') }}" class="btn btn-link ms-2">
                                    <i class="fas fa-sign-in-alt"></i> Déjà un compte ?
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function toggleStudentFields() {
    const role = document.getElementById('role').value;
    const studentFields = document.getElementById('studentFields');
    
    if (role === 'etudiant') {
        studentFields.style.display = 'block';
    } else {
        studentFields.style.display = 'none';
    }
}

// Initialisation
document.addEventListener('DOMContentLoaded', function() {
    if (document.getElementById('role').value === 'etudiant') {
        toggleStudentFields();
    }
});
</script>

<style>
#studentFields {
    transition: all 0.3s ease;
    border-top: 1px solid #dee2e6;
    padding-top: 20px;
    margin-top: 10px;
}

.form-text {
    font-size: 0.85rem;
}
</style>
@endsection