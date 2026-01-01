@extends('layouts.admin')

@section('title', 'Tableau de bord')

@section('content')
<div class="admin-header">
    <h1>Tableau de bord</h1>
    <p class="serif">Bienvenue dans l'interface d'administration du site de DJ GAZ.</p>
</div>

<div class="row">
    <div class="col-md-4 mb-4">
        <div class="card">
            <div class="card-body text-center">
                <i data-lucide="music" style="width: 48px; height: 48px; color: var(--gold);"></i>
                <h3 class="mt-3">{{ App\Models\Track::count() }}</h3>
                <p>Morceaux au total</p>
            </div>
        </div>
    </div>
    <div class="col-md-4 mb-4">
        <div class="card">
            <div class="card-body text-center">
                <i data-lucide="folder" style="width: 48px; height: 48px; color: var(--gold);"></i>
                <h3 class="mt-3">{{ App\Models\Track::distinct('category')->count('category') }}</h3>
                <p>Catégories</p>
            </div>
        </div>
    </div>
    <div class="col-md-4 mb-4">
        <div class="card">
            <div class="card-body text-center">
                <i data-lucide="clock" style="width: 48px; height: 48px; color: var(--gold);"></i>
                <h3 class="mt-3">
                    @php
                        $latestTrack = App\Models\Track::latest()->first();
                    @endphp
                    @if($latestTrack && $latestTrack->created_at)
                        {{ $latestTrack->created_at->format('d/m/Y') }}
                    @else
                        N/A
                    @endif
                </h3>
                <p>Dernier ajout</p>
            </div>
        </div>
    </div>
</div>

<div class="card mt-4">
    <div class="card-header">
        <h4>Actions rapides</h4>
    </div>
    <div class="card-body">
        <a href="{{ route('admin.tracks.create') }}" class="btn btn-primary me-2">
            <i data-lucide="plus-circle" style="width: 18px; height: 18px; margin-right: 8px;"></i>
            Ajouter un morceau
        </a>
        <a href="{{ route('admin.tracks.index') }}" class="btn btn-outline-secondary">
            <i data-lucide="list" style="width: 18px; height: 18px; margin-right: 8px;"></i>
            Voir tous les morceaux
        </a>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        lucide.createIcons();
    });
</script>
@endpush