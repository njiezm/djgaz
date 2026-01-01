@extends('layouts.app')

@section('title', 'Contact | DJ GAZ')

@section('content')
<section id="contact" class="content-section active">
    <div class="container">
        <div class="row">
            <div class="col-lg-6">
                <h2 class="display-3 text-gold mb-5">LAISSER UN MESSAGE</h2>
                <form action="{{ route('contact.submit') }}" method="POST">
                    @csrf
                    <div class="mb-4">
                        <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" placeholder="Votre Nom complet" value="{{ old('name') }}">
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-4">
                        <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" placeholder="Email" value="{{ old('email') }}">
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-4">
                        <textarea class="form-control @error('message') is-invalid @enderror" name="message" rows="6" placeholder="Partagez un souvenir, un mot pour la famille...">{{ old('message') }}</textarea>
                        @error('message')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-gold">ENVOYER LE TÉMOIGNAGE</button>
                    
                    @if(session('success'))
                        <div class="alert alert-success mt-3">
                            {{ session('success') }}
                        </div>
                    @endif
                </form>
            </div>
            <div class="col-lg-5 offset-lg-1">
                <img src="https://images.unsplash.com/photo-1496293455970-f8581aae0e3c?auto=format&fit=crop&q=80&w=600" class="img-fluid mb-5 border border-secondary" alt="Musical vibes">
                <h4 class="text-gold mb-4">Archives Familiales</h4>
                <p class="text-muted">Ce site est un mémorial vivant géré par la famille de DJ GAZ. Pour toute demande concernant les archives ou les photos historiques.</p>
                <div class="mt-4">
                    <p><i data-lucide="map-pin" class="me-2 text-gold"></i> Trinité, Martinique</p>
                    <p><i data-lucide="mail" class="me-2 text-gold"></i> famille@djgaz-legacy.fr</p>
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