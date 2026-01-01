@extends('layouts.app')

@section('content')
<section id="home" class="content-section active">
    <div class="hero">
        <div class="container text-start">
            <h1 class="hero-title">MAESTRO<br><span class="hero-gold">IMMORTEL</span></h1>
            <p class="serif fs-3 mt-4">Un héritage musical gravé dans la nuit trinitéenne.</p>
            <div class="mt-5">
                <a href="{{ url('mix-vault') }}" class="btn btn-gold">Écouter la légende</a>
            </div>
        </div>
    </div>
</section>
@endsection