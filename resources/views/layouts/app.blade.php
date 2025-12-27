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
            background-color: #003366;
        }
        .footer {
            background-color: #003366;
            color: white;
            padding: 20px 0;
            margin-top: 40px;
        }
        .card-header-ensat {
            background-color: #003366;
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
    </style>
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark navbar-ensat">
        <div class="container">
            <a class="navbar-brand" href="{{ url('/') }}">
                <i class="fas fa-graduation-cap"></i> ENSAT - Gestion Étudiants
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    @auth
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('etudiants.index') }}">
                                <i class="fas fa-list"></i> Liste Étudiants
                            </a>
                        </li>
                      @if(auth()->user()->isAdmin())
    <li class="nav-item">
        <a href="{{ route('etudiants.ajouter') }}" class="nav-link">
            <i class="fas fa-user-plus"></i> Ajouter Étudiant
        </a>
    </li>
@endif
                        @if(auth()->user()->isEtudiant())
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('etudiants.mon-profil') }}">
                                    <i class="fas fa-user"></i> Mon Profil
                                </a>
                            </li>
                        @endif
                        <li class="nav-item">
                            <span class="nav-link">
                                <i class="fas fa-user-circle"></i> {{ auth()->user()->name }}
                                ({{ auth()->user()->role }})
                            </span>
                        </li>
                        <li class="nav-item">
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="nav-link btn btn-link">
                                    <i class="fas fa-sign-out-alt"></i> Déconnexion
                                </button>
                            </form>
                        </li>
                    @else
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">
                                <i class="fas fa-sign-in-alt"></i> Connexion
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
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show">
                    <i class="fas fa-check-circle"></i> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif
            
            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show">
                    <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif
            
            @if($errors->any())
                <div class="alert alert-danger alert-dismissible fade show">
                    <i class="fas fa-exclamation-triangle"></i> Veuillez corriger les erreurs suivantes :
                    <ul class="mb-0">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif
            
            @yield('content')
        </div>
    </main>

    <!-- Footer -->
    <footer class="footer">
        <div class="container text-center">
            <p>&copy; {{ date('Y') }} École Nationale des Sciences Appliquées de Tanger (ENSAT)</p>
            <p>Système de Gestion des Étudiants - Projet Laravel</p>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Scripts supplémentaires -->
    @yield('scripts')
</body>
</html>