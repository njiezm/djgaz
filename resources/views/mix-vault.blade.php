@extends('layouts.app')

@section('title', 'Archives Sonores | DJ GAZ')

@section('content')
<section id="mix-vault" class="content-section active">
    <div class="container">
        <h2 class="display-3 text-gold mb-5">ARCHIVES SONORES</h2>
        
        <!-- Onglets dynamiques -->
        <ul class="nav nav-pills mb-5 justify-content-center" id="mixTabs" role="tablist">
            @foreach($tracks as $category => $categoryTracks)
                <li class="nav-item">
                    <button class="nav-link {{ $loop->first ? 'active' : '' }}" 
                            data-bs-toggle="pill" 
                            data-bs-target="#tab-{{ Str::slug($category) }}" 
                            type="button">
                        {{ strtoupper($category) }}
                    </button>
                </li>
            @endforeach
        </ul>

        <!-- Contenu des onglets -->
        <div class="tab-content" id="mixTabsContent">
            @foreach($tracks as $category => $categoryTracks)
                <div class="tab-pane fade {{ $loop->first ? 'show active' : '' }}" 
                     id="tab-{{ Str::slug($category) }}" 
                     role="tabpanel">
                    <div class="row row-cols-1 row-cols-md-2 g-2">
                        @foreach($categoryTracks as $track)
                            <div class="col">
                                <div class="mix-list-item track-item" 
                                     data-track-id="{{ $track->id }}"
                                     data-file-path="{{ asset('storage/' . $track->file_path) }}"
                                     data-title="{{ $track->title }}"
                                     data-artist="{{ $track->artist }}"
                                     data-image="{{ $track->image_path ? asset('storage/' . $track->image_path) : 'https://images.unsplash.com/photo-1614613535308-eb5fbd3d2c17?auto=format&fit=crop&q=80&w=300' }}">
                                    <span>{{ $track->title }}</span>
                                    <i data-lucide="play-circle" style="cursor:pointer"></i>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Lecteur Audio -->
        <div class="player-card mt-5">
            @if($tracks->isNotEmpty())
                @php
                    // Récupérer le tout premier morceau de la collection
                    $firstTrack = $tracks->first()->first();
                @endphp
                <div class="row align-items-center">
                    <div class="col-auto">
                        <img id="player-image" src="{{ $firstTrack->image_path ? asset('storage/' . $firstTrack->image_path) : 'https://images.unsplash.com/photo-1614613535308-eb5fbd3d2c17?auto=format&fit=crop&q=80&w=80' }}" class="img-fluid rounded" alt="Track Cover" style="width: 80px; height: 80px; object-fit: cover;">
                    </div>
                    <div class="col">
                        <h5 id="player-title" class="mb-1 text-gold">{{ $firstTrack->title }}</h5>
                        <p id="player-artist" class="mb-0 text-muted small">{{ $firstTrack->artist }}</p>
                    </div>
                    <div class="col-auto">
                        <div class="d-flex align-items-center gap-3">
                            <i id="prev-btn" data-lucide="skip-back" style="cursor: pointer; width: 24px; height: 24px;"></i>
                            <i id="play-pause-btn" data-lucide="play-circle" style="cursor: pointer; width: 40px; height: 40px; color: var(--gold);"></i>
                            <i id="next-btn" data-lucide="skip-forward" style="cursor: pointer; width: 24px; height: 24px;"></i>
                        </div>
                    </div>
                </div>
                <div class="progress mt-3 bg-dark" style="height: 4px; border-radius: 0; cursor: pointer;" id="progress-container">
                    <div class="progress-bar bg-gold" id="progress-bar" style="width: 0%;"></div>
                </div>
                <audio id="audio-player" src="{{ asset('storage/' . $firstTrack->file_path) }}"></audio>
            @else
                <!-- Message si aucun morceau n'est trouvé -->
                <div class="row align-items-center">
                    <div class="col-auto">
                        <img id="player-image" src="https://images.unsplash.com/photo-1614613535308-eb5fbd3d2c17?auto=format&fit=crop&q=80&w=80" class="img-fluid rounded" alt="Track Cover" style="width: 80px; height: 80px; object-fit: cover;">
                    </div>
                    <div class="col">
                        <h5 id="player-title" class="mb-1 text-gold">Aucun morceau disponible</h5>
                        <p id="player-artist" class="mb-0 text-muted small">Ajoutez des mixes depuis l'administration</p>
                    </div>
                    <div class="col-auto">
                        <div class="d-flex align-items-center gap-3">
                            <i id="prev-btn" data-lucide="skip-back" style="cursor: pointer; width: 24px; height: 24px;"></i>
                            <i id="play-pause-btn" data-lucide="play-circle" style="cursor: pointer; width: 40px; height: 40px; color: var(--gold);"></i>
                            <i id="next-btn" data-lucide="skip-forward" style="cursor: pointer; width: 24px; height: 24px;"></i>
                        </div>
                    </div>
                </div>
                <div class="progress mt-3 bg-dark" style="height: 4px; border-radius: 0; cursor: pointer;" id="progress-container">
                    <div class="progress-bar bg-gold" id="progress-bar" style="width: 0%;"></div>
                </div>
                <audio id="audio-player"></audio>
            @endif
        </div>
    </div>
</section>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    lucide.createIcons();

    const audioPlayer = document.getElementById('audio-player');
    const playPauseBtn = document.getElementById('play-pause-btn');
    const playerTitle = document.getElementById('player-title');
    const playerArtist = document.getElementById('player-artist');
    const playerImage = document.getElementById('player-image');
    const progressBar = document.getElementById('progress-bar');
    const progressContainer = document.getElementById('progress-container');
    const nextBtn = document.getElementById('next-btn');
    const prevBtn = document.getElementById('prev-btn');

    const allTracks = Array.from(document.querySelectorAll('.track-item'));

    let currentTrackIndex = -1;
    let currentTrackElement = null;
    let isPlaying = false;

    /* ==============================
        INITIALISATION AUTOMATIQUE
    ============================== */
    // Si des morceaux existent, on considère que le premier est sélectionné
    if (allTracks.length > 0) {
        currentTrackIndex = 0;
        currentTrackElement = allTracks[0];
        // Mettre en surbrillance le premier morceau dans la liste
        currentTrackElement.style.background = 'rgba(197, 160, 89, 0.2)';
    }

    /* ==============================
        TRACK CLICK
    ============================== */
    allTracks.forEach((track, index) => {
        track.addEventListener('click', () => {
            if (currentTrackElement === track) {
                togglePlayPause();
            } else {
                loadTrack(track, index);
            }
        });
    });

    /* ==============================
        LOAD TRACK
    ============================== */
    function loadTrack(trackElement, index) {
        currentTrackIndex = index;

        if (currentTrackElement) {
            currentTrackElement.style.background = '';
        }

        currentTrackElement = trackElement;
        currentTrackElement.style.background = 'rgba(197, 160, 89, 0.2)';

        const filePath = trackElement.dataset.filePath;
        const title = trackElement.dataset.title;
        const artist = trackElement.dataset.artist;
        const image = trackElement.dataset.image;

        // Réinitialiser le lecteur
        audioPlayer.pause();
        isPlaying = false;
        
        // Charger les nouvelles informations
        audioPlayer.src = filePath;
        playerTitle.textContent = title;
        playerArtist.textContent = artist;
        playerImage.src = image;

        // Démarrer la lecture
        audioPlayer.play().then(() => {
            isPlaying = true;
            updatePlayPauseButton(true);
        }).catch(error => {
            console.error('Erreur lors de la lecture:', error);
            isPlaying = false;
            updatePlayPauseButton(false);
        });
    }

    /* ==============================
        PLAY / PAUSE
    ============================== */
    function togglePlayPause() {
        if (!audioPlayer.src) return;

        if (isPlaying) {
            audioPlayer.pause();
            isPlaying = false;
            updatePlayPauseButton(false);
        } else {
            audioPlayer.play().then(() => {
                isPlaying = true;
                updatePlayPauseButton(true);
            }).catch(error => {
                console.error('Erreur lors de la lecture:', error);
                isPlaying = false;
                updatePlayPauseButton(false);
            });
        }
    }

    playPauseBtn.addEventListener('click', togglePlayPause);

    function updatePlayPauseButton(playing) {
        playPauseBtn.setAttribute(
            'data-lucide',
            playing ? 'pause-circle' : 'play-circle'
        );
        lucide.createIcons({ icons: [playPauseBtn] });
    }

    /* ==============================
        NEXT / PREVIOUS
    ============================== */
    nextBtn.addEventListener('click', () => {
        if (allTracks.length === 0) return;
        
        if (currentTrackIndex < allTracks.length - 1) {
            loadTrack(allTracks[currentTrackIndex + 1], currentTrackIndex + 1);
        } else {
            // Revenir au début de la playlist
            loadTrack(allTracks[0], 0);
        }
    });

    prevBtn.addEventListener('click', () => {
        if (allTracks.length === 0) return;
        
        if (currentTrackIndex > 0) {
            loadTrack(allTracks[currentTrackIndex - 1], currentTrackIndex - 1);
        } else {
            // Aller à la fin de la playlist
            loadTrack(allTracks[allTracks.length - 1], allTracks.length - 1);
        }
    });

    /* ==============================
        PROGRESS BAR
    ============================== */
    audioPlayer.addEventListener('timeupdate', () => {
        if (!audioPlayer.duration) return;

        const percent = (audioPlayer.currentTime / audioPlayer.duration) * 100;
        progressBar.style.width = percent + '%';
    });

    progressContainer.addEventListener('click', (e) => {
        if (!audioPlayer.duration) return;

        const rect = progressContainer.getBoundingClientRect();
        const clickX = e.clientX - rect.left;
        audioPlayer.currentTime = (clickX / rect.width) * audioPlayer.duration;
    });

    /* ==============================
        END TRACK → NEXT
    ============================== */
    audioPlayer.addEventListener('ended', () => {
        isPlaying = false;
        updatePlayPauseButton(false);

        if (currentTrackIndex < allTracks.length - 1) {
            loadTrack(allTracks[currentTrackIndex + 1], currentTrackIndex + 1);
        } else {
            // Revenir au début de la playlist
            progressBar.style.width = '0%';
            if (allTracks.length > 0) {
                loadTrack(allTracks[0], 0);
            }
        }
    });

    /* ==============================
        AUDIO ERRORS
    ============================== */
    audioPlayer.addEventListener('error', (e) => {
        console.error('Erreur de lecture audio:', e);
        isPlaying = false;
        updatePlayPauseButton(false);
    });
});
</script>
@endpush