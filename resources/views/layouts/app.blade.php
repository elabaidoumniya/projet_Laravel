<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des Étudiants - ENSAT</title>
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .navbar-ensat {
            background: linear-gradient(90deg, #003366 0%, #004080 100%);
        }
        .footer {
            background-color: #003366;
            color: white;
            padding: 20px 0;
            margin-top: 40px;
        }
        .card-header-ensat {
            background: linear-gradient(90deg, #003366 0%, #004080 100%);
            color: white;
        }
        .btn-ensat {
            background-color: #003366;
            color: white;
        }
        .btn-ensat:hover {
            background-color: #002244;
            color: white;
        }
        .btn-google {
            background-color: #DB4437;
            color: white;
            border: none;
        }
        .btn-google:hover {
            background-color: #C33D2E;
            color: white;
        }
        .user-avatar {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            border: 2px solid white;
        }
        .role-badge {
            font-size: 0.7em;
            padding: 3px 8px;
            border-radius: 10px;
        }
        .role-admin {
            background-color: #dc3545;
            color: white;
        }
        .role-etudiant {
            background-color: #28a745;
            color: white;
        }
        .dropdown-menu {
            min-width: 250px;
        }
    </style>
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark navbar-ensat shadow">
        <div class="container">
            <a class="navbar-brand" href="{{ url('/') }}">
                <i class="fas fa-graduation-cap"></i> <strong>ENSAT</strong> - Gestion Étudiants
                <small class="badge bg-light text-dark ms-2">Google OAuth 2</small>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    @auth
                        <!-- Menu déroulant utilisateur -->
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" 
                               id="navbarDropdown" role="button" data-bs-toggle="dropdown" 
                               aria-expanded="false">
                                <!-- Avatar Google -->
                                @if(auth()->user()->avatar)
                                    <img src="{{ auth()->user()->avatar }}" alt="Avatar Google" 
                                         class="user-avatar me-2"
                                         onerror="this.onerror=null; this.src='https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name) }}&background=004080&color=fff'">
                                @else
                                    <i class="fas fa-user-circle me-2" style="font-size: 1.5rem;"></i>
                                @endif
                                
                                <!-- Nom et rôle -->
                                <div class="d-flex flex-column align-items-start">
                                    <span class="fw-bold">{{ auth()->user()->name }}</span>
                                    <span class="role-badge 
                                        @if(auth()->user()->role === 'admin') role-admin 
                                        @else role-etudiant @endif">
                                        <i class="fas 
                                            @if(auth()->user()->role === 'admin') fa-user-shield 
                                            @else fa-user-graduate @endif me-1"></i>
                                        {{ auth()->user()->role }}
                                    </span>
                                </div>
                            </a>
                            
                            <!-- Dropdown menu -->
                            <ul class="dropdown-menu dropdown-menu-end shadow" aria-labelledby="navbarDropdown">
                                <!-- Info utilisateur -->
                                <li>
                                    <div class="dropdown-item-text">
                                        <small>
                                            <i class="fas fa-envelope me-2 text-muted"></i>
                                            {{ auth()->user()->email }}
                                        </small>
                                        <br>
                                        <small>
                                            <i class="fab fa-google me-2 text-muted"></i>
                                            Connecté avec Google
                                        </small>
                                    </div>
                                </li>
                                <li><hr class="dropdown-divider"></li>
                                
                                <!-- Liens selon rôle -->
                                @if(auth()->user()->role === 'admin')
                                    <li>
                                        <h6 class="dropdown-header">
                                            <i class="fas fa-tools me-2"></i> Administration
                                        </h6>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="{{ route('etudiants.index') }}">
                                            <i class="fas fa-users me-2"></i> Liste des étudiants
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="{{ route('etudiants.ajouter') }}">
                                            <i class="fas fa-user-plus me-2"></i> Ajouter un étudiant
                                        </a>
                                    </li>
                                @endif
                                
                                @if(auth()->user()->role === 'etudiant')
                                    <li>
                                        <h6 class="dropdown-header">
                                            <i class="fas fa-user-graduate me-2"></i> Étudiant
                                        </h6>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="{{ route('etudiants.mon-profil') }}">
                                            <i class="fas fa-id-card me-2"></i> Mon profil
                                        </a>
                                    </li>
                                @endif
                                
                                <li><hr class="dropdown-divider"></li>
                                
                                <!-- Accueil et déconnexion -->
                                @if(auth()->user()->role === 'admin')
                                <li>
                                    <a class="dropdown-item" href="{{ route('home') }}">
                                        <i class="fas fa-home me-2"></i> Tableau de bord
                                    </a>
                                </li>
                                @endif
                                
                                <li>
                                    <form method="POST" action="{{ route('logout') }}" id="logoutForm">
                                        @csrf
                                        <button type="submit" class="dropdown-item text-danger">
                                            <i class="fas fa-sign-out-alt me-2"></i> Déconnexion
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </li>
                    @else
                        <!-- Bouton Connexion Google (visiteur) -->
                        <li class="nav-item">
                            <a class="nav-link btn btn-google px-4" href="{{ route('login') }}">
                                <i class="fab fa-google me-2"></i> Connexion Google
                            </a>
                        </li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="py-4">
        <div class="container">
            <!-- Messages de session -->
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show shadow">
                    <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif
            
            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show shadow">
                    <i class="fas fa-exclamation-circle me-2"></i> {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif
            
            @if($errors->any())
                <div class="alert alert-danger alert-dismissible fade show shadow">
                    <i class="fas fa-exclamation-triangle me-2"></i> Veuillez corriger les erreurs suivantes :
                    <ul class="mb-0 mt-2">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif
            
            <!-- Contenu principal -->
            @yield('content')
        </div>
    </main>

    <!-- Footer -->
    <footer class="footer mt-auto">
        <div class="container text-center">
            <p class="mb-2">
                <i class="fas fa-graduation-cap me-2"></i>
                École Nationale des Sciences Appliquées de Tanger (ENSAT)
            </p>
            <p class="mb-0">
                <small>
                    Système de Gestion des Étudiants | 
                    <i class="fab fa-google me-1"></i> Authentification Google OAuth 2 |
                    Laravel {{ app()->version() }}
                </small>
            </p>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Scripts personnalisés -->
    <script>
        // Confirmation avant déconnexion
        document.addEventListener('DOMContentLoaded', function() {
            const logoutForm = document.getElementById('logoutForm');
            if (logoutForm) {
                logoutForm.addEventListener('submit', function(e) {
                    if (!confirm('Êtes-vous sûr de vouloir vous déconnecter ?')) {
                        e.preventDefault();
                    }
                });
            }
            
            // Gestion des erreurs d'avatar Google
            document.querySelectorAll('.user-avatar').forEach(img => {
                img.onerror = function() {
                    this.src = `https://ui-avatars.com/api/?name=${encodeURIComponent(this.alt || 'User')}&background=004080&color=fff`;
                };
            });
            
            // Animation pour les alertes
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(alert => {
                setTimeout(() => {
                    alert.classList.add('fade');
                }, 5000);
            });
        });
    </script>
    
    <!-- Scripts supplémentaires des pages -->
    @yield('scripts')
</body>
</html>