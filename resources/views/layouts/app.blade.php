<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'DJ GAZ | L\'Héritage d\'une Légende')</title>
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Big+Shoulders+Display:wght@100..900&family=Cormorant+Garamond:ital,wght@0,300;0,600;1,400&family=Inter:wght@300;400&display=swap" rel="stylesheet">
    <!-- Lucide Icons -->
    <script src="https://unpkg.com/lucide@latest"></script>
    <style>
        :root {
            --gold: #c5a059;
            --gold-bright: #e5c17d;
            --deep-black: #080808;
            --pure-white: #ffffff;
            --accent-red: #bc0000;
        }

        body {
            background-color: var(--deep-black);
            color: var(--pure-white);
            font-family: 'Inter', sans-serif;
            overflow-x: hidden;
        }

        h1, h2, h3, h4, .nav-link, .night-title {
            font-family: 'Big Shoulders Display', sans-serif;
            text-transform: uppercase;
            letter-spacing: 0.1em;
        }

        .serif {
            font-family: 'Cormorant Garamond', serif;
            font-style: italic;
        }

        /* Navbar */
        .navbar {
            background: rgba(8, 8, 8, 0.98);
            border-bottom: 1px solid rgba(197, 160, 89, 0.2);
            padding: 1rem 0;
            z-index: 1050;
        }

        .navbar-brand {
            font-weight: 900;
            font-size: 2rem;
            color: var(--gold) !important;
        }

        .nav-link {
            color: var(--pure-white) !important;
            font-weight: 300;
            margin-left: 1.2rem;
            transition: 0.3s;
            font-size: 0.85rem;
        }

        .nav-link:hover, .nav-link.active {
            color: var(--gold) !important;
        }

        /* Hero */
        .hero {
            height: 100vh;
            display: flex;
            align-items: center;
            background: linear-gradient(to right, #080808 50%, transparent), url('https://images.unsplash.com/photo-1516280440614-37939bbacd81?auto=format&fit=crop&q=80&w=1920');
            background-size: cover;
            background-position: center;
        }

        .hero-title {
            font-size: clamp(5rem, 15vw, 10rem);
            line-height: 0.8;
            font-weight: 900;
        }

        .hero-gold {
            color: var(--gold);
            -webkit-text-stroke: 1px var(--gold);
            -webkit-text-fill-color: transparent;
        }

        /* Sections Animation */
        .content-section {
            display: none;
            padding: 100px 0;
            animation: fadeIn 0.6s ease-out;
        }

        .content-section.active {
            display: block;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* Tabs Styles for Mixes */
        .nav-pills .nav-link {
            background: transparent;
            border: 1px solid rgba(197, 160, 89, 0.3);
            color: var(--pure-white);
            margin: 5px;
            border-radius: 0;
        }

        .nav-pills .nav-link.active {
            background: var(--gold);
            color: white !important;
            text-decoration-color: white !important;
            border-color: var(--gold);
        }

        .mix-list-item {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 12px 15px;
            border-bottom: 1px solid rgba(255,255,255,0.05);
            transition: 0.2s;
        }

        .mix-list-item:hover {
            background: rgba(197, 160, 89, 0.1);
            border-left: 4px solid var(--gold);
        }

        /* Player Styles */
        .player-card {
            background: #111;
            border: 1px solid var(--gold);
            padding: 30px;
            position: sticky;
            top: 120px;
        }

        /* Images placeholders */
        .img-featured {
            width: 100%;
            height: 400px;
            object-fit: cover;
            border: 1px solid rgba(197, 160, 89, 0.3);
            filter: sepia(30%) contrast(110%);
        }

        /* Form */
        .form-control {
            background: transparent;
            border: 1px solid rgba(197, 160, 89, 0.3);
            border-radius: 0;
            color: white;
            padding: 15px;
        }

        .btn-gold {
            background: var(--gold);
            color: #000;
            border: none;
            font-family: 'Big Shoulders Display';
            font-weight: 800;
            padding: 12px 35px;
            border-radius: 0;
            transition: 0.3s;
        }

        /* Spiritual Section */
        .spiritual-section { background: var(--pure-white); color: var(--deep-black); padding: 100px 0; }
        .family-card { border-bottom: 1px solid #ddd; padding: 25px 0; }

        .bande-joyeuse-box {
            background: linear-gradient(rgba(0,0,0,0.8), rgba(0,0,0,0.8)), url('https://images.unsplash.com/photo-1514525253361-b83f859b73c0?auto=format&fit=crop&q=80&w=800');
            background-size: cover;
            padding: 60px;
            border: 1px solid var(--gold);
        }
    </style>
</head>
<body>

    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg fixed-top">
        <div class="container">
            <a class="navbar-brand" href="{{ url('/') }}">DJ GAZ</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <i data-lucide="menu" style="color: var(--gold);"></i>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto text-center">
                    <li class="nav-item"><a class="nav-link {{ request()->is('/') || request()->is('home') ? 'active' : '' }}" href="{{ url('/') }}">Accueil</a></li>
                    <li class="nav-item"><a class="nav-link {{ request()->is('top50') ? 'active' : '' }}" href="{{ url('top50') }}">Top 50 Club</a></li>
                    <li class="nav-item"><a class="nav-link {{ request()->is('bande-joyeuse') ? 'active' : '' }}" href="{{ url('bande-joyeuse') }}">Bande Joyeuse</a></li>
                    <li class="nav-item"><a class="nav-link {{ request()->is('mix-vault') ? 'active' : '' }}" href="{{ url('mix-vault') }}">Mixes Archives</a></li>
                    <li class="nav-item"><a class="nav-link {{ request()->is('contributions') ? 'active' : '' }}" href="{{ url('contributions') }}">Participations</a></li>
                    <li class="nav-item"><a class="nav-link {{ request()->is('maestro-playlist') ? 'active' : '' }}" href="{{ url('maestro-playlist') }}">Maestro Playlist</a></li>
                    <li class="nav-item"><a class="nav-link {{ request()->is('lavise') ? 'active' : '' }}" href="{{ url('lavise') }}">La vi sé...</a></li>
                    <li class="nav-item"><a class="nav-link {{ request()->is('contact') ? 'active' : '' }}" href="{{ url('contact') }}">Contact</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Contenu principal -->
    <main>
        @yield('content')
    </main>

    <footer class="py-5 border-top border-secondary">
        <div class="container text-center">
            <h2 class="text-gold">DJ GAZ</h2>
            <p class="serif opacity-50">L'héritage d'un homme, le son d'une île.</p>
            <p class="small text-white-50 mt-4">&copy; 2024 - Hommage Familial | Fait avec amour en Martinique</p>
        </div>
    </footer>

    <!-- Bootstrap JS + Lucide -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        lucide.createIcons();

        // Simuler le changement de track dans le player
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.mix-list-item').forEach(item => {
                item.addEventListener('click', function() {
                    const name = this.querySelector('span').innerText;
                    const trackNameElement = document.getElementById('track-name');
                    if (trackNameElement) {
                        trackNameElement.innerText = name;
                    }
                });
            });
        });
    </script>
    
    @stack('scripts')
</body>
</html>