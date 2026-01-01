@extends('layouts.app')

@section('title', 'Projets & Contributions | DJ GAZ')

@section('content')
<section id="contributions" class="content-section active">
    <div class="container">
        <h2 class="display-3 text-gold mb-5">PROJETS & CONTRIBUTIONS</h2>
        <div class="row g-4">
            <div class="col-md-6 mb-4">
                <div class="p-5 border border-secondary d-flex align-items-center">
                    <div class="me-4"><i data-lucide="award" class="w-100 h-100 text-gold" style="width:50px; height:50px;"></i></div>
                    <div>
                        <h4 class="text-gold">Festival de la Trinité</h4>
                        <p class="text-muted mb-0">Coordination sonore et programmation musicale pour les éditions phares.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-6 mb-4">
                <div class="p-5 border border-secondary d-flex align-items-center">
                    <div class="me-4"><i data-lucide="radio" class="w-100 h-100 text-gold" style="width:50px; height:50px;"></i></div>
                    <div>
                        <h4 class="text-gold">Archives Radiophoniques</h4>
                        <p class="text-muted mb-0">Émissions spéciales et mix exclusifs pour les radios locales Martiniquaises.</p>
                    </div>
                </div>
            </div>
        </div>
        <img src="https://images.unsplash.com/photo-1498038432885-c6f3f1b912ee?auto=format&fit=crop&q=80&w=1200" class="img-fluid mt-5 grayscale opacity-50" style="height:200px; width:100%; object-fit:cover;" alt="Soundwave">
    </div>
</section>
@endsection