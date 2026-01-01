@extends('layouts.app')

@section('title', 'Top 50 Club | DJ GAZ')

@section('content')
<section id="top50" class="content-section active">
    <div class="container">
        <div class="row align-items-center g-5">
            <div class="col-lg-6">
                <span class="badge bg-danger mb-3 p-2 rounded-0">RÉSIDENCE HISTORIQUE</span>
                <h2 class="display-1 fw-black">TOP 50 NIGHT CLUB</h2>
                <p class="serif fs-4 text-gold mt-3">Zone du Bac, Trinité</p>
                <p class="text-muted lead">Pendant des années, DJ GAZ a été le métronome du Top 50. Il n'était pas seulement un DJ, il était le créateur d'ambiance qui a défini une génération entière de fêtards en Martinique.</p>
                <div class="row mt-4">
                    <div class="col-6">
                        <img src="{{ asset('images/club-vibes.jpg') }}" class="img-fluid border border-secondary" alt="Club Vibes">
                    </div>
                    <div class="col-6">
                        <img src="{{ asset('images/top.jpg') }}" class="img-fluid border border-secondary" alt="Mixer details">
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <img src="{{ asset('images/hero-dj-1.jpg') }}" class="img-featured" alt="DJ GAZ Profile Placeholder">
            </div>
        </div>
    </div>
</section>
@endsection