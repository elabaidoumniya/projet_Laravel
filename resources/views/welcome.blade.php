<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des Étudiants - ENSAT</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .hero-section {
            background: linear-gradient(135deg, #003366 0%, #004080 100%);
            color: white;
            padding: 80px 0;
            text-align: center;
        }
        .hero-title {
            font-size: 3rem;
            font-weight: 700;
            margin-bottom: 1rem;
        }
        .hero-subtitle {
            font-size: 1.2rem;
            margin-bottom: 2rem;
            opacity: 0.9;
        }
        .btn-ensat {
            background-color: #003366;
            color: white;
            border: none;
            padding: 12px 30px;
            border-radius: 25px;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        .btn-ensat:hover {
            background-color: #002244;
            transform: translateY(-2px);
        }
        .features-section {
            padding: 60px 0;
            background: white;
        }
        .feature-card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            transition: transform 0.3s ease;
            margin-bottom: 30px;
        }
        .feature-card:hover {
            transform: translateY(-5px);
        }
        .feature-icon {
            font-size: 3rem;
            color: #003366;
            margin-bottom: 1rem;
        }
        .footer {
            background-color: #003366;
            color: white;
            padding: 30px 0;
            text-align: center;
        }
    </style>
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark" style="background-color: #003366;">
        <div class="container">
            <a class="navbar-brand fw-bold" href="#">
                <i class="fas fa-graduation-cap me-2"></i>ENSAT - Gestion Étudiants
            </a>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero-section">
        <div class="container">
            <h1 class="hero-title">Bienvenue sur la plateforme ENSAT</h1>
            <p class="hero-subtitle">Système de gestion des étudiants avec authentification Google OAuth</p>
            <a href="{{ route('login') }}" class="btn btn-ensat btn-lg">
                <i class="fab fa-google me-2"></i>Se connecter
            </a>
        </div>
    </section>

    <!-- Features Section -->
    <section class="features-section">
        <div class="container">
            <div class="row text-center mb-5">
                <div class="col-12">
                    <h2 class="h1 mb-4" style="color: #003366;">Fonctionnalités</h2>
                    <p class="lead">Découvrez les capacités de notre plateforme de gestion étudiante</p>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <div class="card feature-card h-100">
                        <div class="card-body text-center p-4">
                            <div class="feature-icon">
                                <i class="fas fa-users"></i>
                            </div>
                            <h5 class="card-title">Gestion des Étudiants</h5>
                            <p class="card-text">CRUD complet pour gérer les informations des étudiants avec interface intuitive.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card feature-card h-100">
                        <div class="card-body text-center p-4">
                            <div class="feature-icon">
                                <i class="fab fa-google"></i>
                            </div>
                            <h5 class="card-title">Authentification Google</h5>
                            <p class="card-text">Connexion sécurisée via OAuth 2.0 avec les comptes Google institutionnels.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card feature-card h-100">
                        <div class="card-body text-center p-4">
                            <div class="feature-icon">
                                <i class="fas fa-shield-alt"></i>
                            </div>
                            <h5 class="card-title">Sécurité Avancée</h5>
                            <p class="card-text">Rôles utilisateurs (Admin/Étudiant) avec permissions granulaires.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <p>&copy; 2026 ENSAT - École Nationale des Sciences Appliquées de Tanger</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
            font-weight: 500;
            transition: all 0.3s;
        }
        .btn-google:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.2);
        }
    </style>
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark" style="background: rgba(0,0,0,0.2);">
        <div class="container">
            <a class="navbar-brand fw-bold" href="/">
                <i class="fas fa-graduation-cap me-2"></i>ENSAT
            </a>
            <div class="navbar-nav ms-auto">
                @auth
                    <a href="{{ route('home') }}" class="nav-link btn btn-light btn-sm">
                        <i class="fas fa-tachometer-alt me-1"></i> Tableau de bord
                    </a>
                @else
                    <a href="{{ route('login') }}" class="nav-link btn btn-light btn-sm">
                        <i class="fab fa-google me-1"></i> Connexion
                    </a>
                @endauth
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <div class="hero-section">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <h1 class="hero-title">Gestion des Étudiants</h1>
                    <p class="hero-subtitle">
                        Système moderne de gestion académique avec authentification Google OAuth 2
                    </p>
                    
                    @auth
                        <div class="alert alert-success" style="max-width: 500px;">
                            <h5><i class="fas fa-check-circle me-2"></i> Connecté avec succès !</h5>
                            <p class="mb-0">Bienvenue {{ auth()->user()->name }}</p>
                            <div class="mt-2">
                                <a href="{{ route('home') }}" class="btn btn-success">
                                    <i class="fas fa-arrow-right me-1"></i> Aller au tableau de bord
                                </a>
                            </div>
                        </div>
                    @else
                        <div class="d-flex gap-3 flex-wrap">
                            <a href="{{ route('login') }}" class="btn-google">
                                <i class="fab fa-google me-2"></i> Se connecter avec Google
                            </a>
                            <a href="#features" class="btn btn-outline-light">
                                <i class="fas fa-info-circle me-2"></i> En savoir plus
                            </a>
                        </div>
                    @endauth
                </div>
                <div class="col-lg-6">
                    <img src="https://cdn.pixabay.com/photo/2017/09/08/00/38/friend-2727305_1280.jpg" 
                         class="img-fluid rounded-3 shadow-lg" 
                         alt="Étudiants ENSAT">
                </div>
            </div>
        </div>
    </div>

    <!-- Features Section -->
    <div class="container py-5" id="features">
        <div class="features">
            <div class="row text-center">
                <div class="col-md-4 mb-4">
                    <div class="p-4">
                        <div class="feature-icon">
                            <i class="fas fa-shield-alt"></i>
                        </div>
                        <h4 class="text-white">Sécurité OAuth 2</h4>
                        <p class="text-light">Authentification sécurisée via Google OAuth 2.0 avec vérification de domaine ENSAT.</p>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="p-4">
                        <div class="feature-icon">
                            <i class="fas fa-user-tie"></i>
                        </div>
                        <h4 class="text-white">Double Interface</h4>
                        <p class="text-light">Interface distincte pour administrateurs et étudiants selon leurs permissions.</p>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="p-4">
                        <div class="feature-icon">
                            <i class="fas fa-chart-line"></i>
                        </div>
                        <h4 class="text-white">Gestion Complète</h4>
                        <p class="text-light">CRUD complet, export de données, et gestion des profils étudiants.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-dark text-white py-4 mt-auto">
        <div class="container text-center">
            <p class="mb-2">
                <i class="fas fa-graduation-cap me-2"></i>
                École Nationale des Sciences Appliquées de Tanger
            </p>
            <p class="mb-0 text-muted">
                <small>
                    Projet Laravel | Authentification Google OAuth 2 | 
                    <i class="fab fa-github me-1"></i> Gestion des Étudiants
                </small>
            </p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>