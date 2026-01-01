@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-lg border-0" style="border-radius: 15px; overflow: hidden;">
                <div class="card-header text-white text-center py-4" style="background: linear-gradient(135deg, #003366 0%, #004080 100%);">
                    <h2 class="mb-2"><i class="fas fa-graduation-cap me-2"></i>Connexion ENSAT</h2>
                    <p class="mb-0 opacity-75">Authentification sécurisée</p>
                </div>

                <div class="card-body p-5 text-center">
                    <div class="mb-4">
                        <div class="display-1 text-primary mb-3" style="color: #003366 !important;">
                            <i class="fas fa-lock"></i>
                        </div>
                        <h3 class="h4 mb-3 fw-bold">Connexion avec Google</h3>
                        <p class="text-muted">Utilisez votre compte Google institutionnel ENSAT</p>
                    </div>

                    <!-- Bouton Google stylisé -->
                    <a href="{{ route('auth.google') }}" class="btn btn-lg w-100 mb-4 py-3 fw-bold"
                       style="background: linear-gradient(135deg, #4285F4 0%, #34A853 100%); color: white; border: none; border-radius: 25px; font-size: 1.1rem;">
                        <i class="fab fa-google me-2"></i>Se connecter avec Google
                    </a>

                    <!-- Informations importantes -->
                    <div class="alert alert-info border-0" style="background-color: #e3f2fd; border-radius: 10px;">
                        <i class="fas fa-info-circle me-2 text-primary"></i>
                        <strong>Emails autorisés :</strong> @ensat.ac.ma ou @etu.uae.ac.ma
                    </div>

                    <!-- Message d'erreur -->
                    @if(session('error'))
                        <div class="alert alert-danger mt-4 border-0" style="border-radius: 10px;">
                            <i class="fas fa-exclamation-triangle me-2"></i>{{ session('error') }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection