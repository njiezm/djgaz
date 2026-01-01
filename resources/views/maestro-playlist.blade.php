@extends('layouts.app')

@section('title', 'Playlist du Maestro | DJ GAZ')

@section('content')
<section id="maestro-playlist" class="content-section active">
    <div class="container">
        <div class="row g-5 align-items-center">
            <div class="col-lg-7">
                <h2 class="display-3 text-gold mb-4">LA PLAYLIST DU MAESTRO</h2>
                <p class="serif fs-4 mb-5">"Ses inspirations, son univers intime."</p>
                <div class="mix-list-item"><span>Kassav' - Zouk la sé sèl médikaman nou ni</span> <span class="badge border border-secondary">1984</span></div>
                <div class="mix-list-item"><span>Tabou Combo - Mabouya</span> <span class="badge border border-secondary">1978</span></div>
                <div class="mix-list-item"><span>Bob Marley - Redemption Song</span> <span class="badge border border-secondary">1980</span></div>
                <div class="mix-list-item"><span>Celia Cruz - La Vida Es Un Carnaval</span> <span class="badge border border-secondary">1998</span></div>
                <div class="mix-list-item"><span>Malavoi - Case à Lucie</span> <span class="badge border border-secondary">1987</span></div>
            </div>
            <div class="col-lg-5">
                <div class="player-card text-center">
                    <img src="https://images.unsplash.com/photo-1614613535308-eb5fbd3d2c17?auto=format&fit=crop&q=80&w=300" class="img-fluid mb-4 rounded-0 border border-gold" alt="Vinyle Record">
                    <h4 id="track-name" class="text-gold">Kassav' - Zouk la sé sèl...</h4>
                    <div class="progress mb-4 bg-dark" style="height: 5px; border-radius: 0;">
                        <div class="progress-bar bg-gold" style="width: 45%;"></div>
                    </div>
                    <div class="d-flex justify-content-center gap-4">
                        <i data-lucide="skip-back" style="cursor:pointer"></i>
                        <i data-lucide="pause-circle" class="text-gold" style="cursor:pointer; width:40px; height:40px;"></i>
                        <i data-lucide="skip-forward" style="cursor:pointer"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Réinitialiser les icônes Lucide après le chargement du contenu
        lucide.createIcons();
    });
</script>
@endpush