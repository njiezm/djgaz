<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin | DJ GAZ')</title>
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

        h1, h2, h3, h4, h5, h6 {
            font-family: 'Big Shoulders Display', sans-serif;
            text-transform: uppercase;
            letter-spacing: 0.1em;
        }

        .serif {
            font-family: 'Cormorant Garamond', serif;
            font-style: italic;
        }

        .admin-container {
            display: flex;
            min-height: 100vh;
        }

        .sidebar {
            width: 250px;
            background: rgba(8, 8, 8, 0.98);
            border-right: 1px solid rgba(197, 160, 89, 0.2);
            padding: 2rem 0;
            position: fixed;
            height: 100vh;
            overflow-y: auto;
            z-index: 100;
        }

        .sidebar .nav-link {
            color: var(--pure-white);
            font-weight: 300;
            padding: 12px 25px;
            transition: 0.3s;
            display: flex;
            align-items: center;
        }

        .sidebar .nav-link:hover, .sidebar .nav-link.active {
            background: rgba(197, 160, 89, 0.1);
            color: var(--gold);
        }

        .sidebar .nav-link i {
            margin-right: 10px;
        }

        .main-content {
            margin-left: 250px;
            flex: 1;
            padding: 2rem;
        }

        .admin-header {
            border-bottom: 1px solid rgba(197, 160, 89, 0.2);
            padding-bottom: 1rem;
            margin-bottom: 2rem;
        }

        .admin-header h1 {
            color: var(--gold);
            font-size: 2.5rem;
        }

        .card {
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(197, 160, 89, 0.2);
        }

        .table {
            color: var(--pure-white);
        }

        .table th {
            border-color: rgba(197, 160, 89, 0.3);
            color: var(--gold);
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.85rem;
        }

        .table td {
            border-color: rgba(255, 255, 255, 0.1);
        }

        .btn-primary {
            background: var(--gold);
            color: var(--deep-black);
            border: none;
            font-family: 'Big Shoulders Display';
            font-weight: 800;
            padding: 10px 25px;
            border-radius: 0;
            transition: 0.3s;
        }

        .btn-primary:hover {
            background: var(--gold-bright);
            color: var(--deep-black);
        }

        .btn-outline-secondary {
            border-color: rgba(197, 160, 89, 0.5);
            color: var(--pure-white);
        }

        .btn-outline-secondary:hover {
            background: rgba(197, 160, 89, 0.1);
            border-color: var(--gold);
            color: var(--gold);
        }

        .form-control {
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(197, 160, 89, 0.3);
            border-radius: 0;
            color: white;
            padding: 12px 15px;
        }

        .form-control:focus {
            background: rgba(255, 255, 255, 0.15);
            border-color: var(--gold);
            color: white;
            box-shadow: 0 0 0 0.25rem rgba(197, 160, 89, 0.25);
        }

        .alert-success {
            background: rgba(197, 160, 89, 0.2);
            border-color: var(--gold);
            color: var(--pure-white);
        }

        .pagination {
            --bs-pagination-color: var(--pure-white);
            --bs-pagination-bg: transparent;
            --bs-pagination-border-color: rgba(197, 160, 89, 0.3);
            --bs-pagination-hover-color: var(--deep-black);
            --bs-pagination-hover-bg: var(--gold);
            --bs-pagination-hover-border-color: var(--gold);
            --bs-pagination-active-color: var(--deep-black);
            --bs-pagination-active-bg: var(--gold);
            --bs-pagination-active-border-color: var(--gold);
        }

        /* Drag and Drop Styles */
        .dropzone {
            border: 2px dashed rgba(197, 160, 89, 0.5);
            border-radius: 5px;
            padding: 40px;
            text-align: center;
            background: rgba(255, 255, 255, 0.05);
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .dropzone:hover, .dropzone.dragover {
            background: rgba(197, 160, 89, 0.1);
            border-color: var(--gold);
        }

        .dropzone i {
            font-size: 3rem;
            color: var(--gold);
            margin-bottom: 15px;
        }

        .file-list {
            margin-top: 20px;
        }

        .file-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 15px;
            background: rgba(255, 255, 255, 0.05);
            border-bottom: 1px solid rgba(197, 160, 89, 0.2);
        }

        .file-item:last-child {
            border-bottom: none;
        }

        .mobile-toggle {
            display: none;
            position: fixed;
            top: 20px;
            left: 20px;
            z-index: 101;
            background: var(--gold);
            color: var(--deep-black);
            border: none;
            padding: 10px;
            border-radius: 5px;
        }

        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
                transition: transform 0.3s ease;
            }

            .sidebar.show {
                transform: translateX(0);
            }

            .main-content {
                margin-left: 0;
            }

            .mobile-toggle {
                display: block;
            }
        }
    </style>
</head>
<body>
    <button class="mobile-toggle" id="sidebar-toggle">
        <i data-lucide="menu"></i>
    </button>

    <div class="admin-container">
        <!-- Sidebar -->
        <nav class="sidebar" id="admin-sidebar">
            <div class="text-center mb-4">
                <h2 class="text-gold">DJ GAZ</h2>
                <p class="serif opacity-50">Administration</p>
            </div>
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}">
                        <i data-lucide="home" style="width: 18px; height: 18px;"></i>
                        Tableau de bord
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('admin.tracks.*') ? 'active' : '' }}" href="{{ route('admin.tracks.index') }}">
                        <i data-lucide="music" style="width: 18px; height: 18px;"></i>
                        Gérer les Morceaux
                    </a>
                </li>
            </ul>
        </nav>

        <!-- Main Content -->
        <main class="main-content">
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            
            @yield('content')
        </main>
    </div>

    <!-- Bootstrap JS + Lucide -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            lucide.createIcons();

            // Toggle sidebar for mobile
            document.getElementById('sidebar-toggle').addEventListener('click', function() {
                document.getElementById('admin-sidebar').classList.toggle('show');
            });
        });
    </script>
    
    @stack('scripts')
</body>
</html>