@extends('layouts.app')

@section('title', 'Playlist du Maestro | DJ GAZ')

@section('content')
<section id="maestro-playlist" class="content-section active">
    <div class="container">
        <div class="row g-5 align-items-center">
            <div class="col-lg-7">
                <h2 class="display-3 text-gold mb-4">LA PLAYLIST DU MAESTRO</h2>
                <p class="serif fs-4 mb-5">"Ses inspirations, son univers intime."</p>
                
                <!-- Playlist dynamique -->
                <div id="maestro-playlist-container">
                    <!-- Les éléments seront générés par JavaScript -->
                </div>
            </div>
            <div class="col-lg-5">
                <div class="player-card text-center">
                    <!-- MODIFIÉ : Ajout d'une classe spécifique et suppression de img-fluid -->
                    <img id="player-image" src="https://images.unsplash.com/photo-1614613535308-eb5fbd3d2c17?auto=format&fit=crop&q=80&w=300" class="player-cover mb-4 rounded-0 border border-gold" alt="Pochette d'album">
                    <h4 id="track-name" class="text-gold">Sélectionnez un morceau</h4>
                    <div class="progress mb-4 bg-dark" style="height: 5px; border-radius: 0; cursor: pointer;" id="progress-container">
                        <div class="progress-bar bg-gold" id="progress-bar" style="width: 0%;"></div>
                    </div>
                    <div class="d-flex justify-content-center gap-4">
                        <i id="prev-btn" data-lucide="skip-back" style="cursor:pointer"></i>
                        <i id="play-pause-btn" data-lucide="play-circle" class="text-gold" style="cursor:pointer; width:40px; height:40px;"></i>
                        <i id="next-btn" data-lucide="skip-forward" style="cursor:pointer"></i>
                    </div>
                    <!-- Élément audio caché -->
                    <audio id="audio-player"></audio>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@push('scripts')
<script>
    window.APP_URLS = {
        music: "{{ asset('musique') }}",
        covers: "{{ asset('images/pochette') }}",
        defaultCover: "https://images.unsplash.com/photo-1614613535308-eb5fbd3d2c17?auto=format&fit=crop&q=80&w=300"
    };
</script>

@push('styles')
<style>
/* Style pour l'image du lecteur avec des dimensions fixes */
.player-cover {
    width: 300px;
    height: 300px;
    object-fit: cover; /* Assure que l'image couvre l'espace sans être déformée */
}
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    lucide.createIcons();

    // ==================== DONNÉES DE LA PLAYLIST ====================
    // Ajoutez ici vos morceaux.
    // 'filename' -> nom du fichier dans public/musique/
    // 'cover' -> nom du fichier image dans public/images/pochette/
    const playlist = [
        { title: 'Lona Alex Catherine', artist: 'Lona', year: '2000', filename: 'lona-alex-catherine.mp3', cover: 'lona-alex-catherine.jpg' },
        { title: 'Bel Kreati', artist: 'Kassav', year: '1995', filename: 'kassav-bel-kreati.mp3', cover: 'kassav-bel-kreati.jpg' },
        { title: 'Zouk la sé sèl médikaman nou ni', artist: 'Kassav\'', year: '1984', filename: 'kassav-zouk-la-se-sel.mp3', cover: 'kassav-zouk-la-se-sel.jpg' },
        { title: 'Mabouya', artist: 'Tabou Combo', year: '1978', filename: 'tabou-combo-mabouya.mp3', cover: 'tabou-combo-mabouya.jpg' },
        { title: 'Redemption Song', artist: 'Bob Marley', year: '1980', filename: 'bob-marley-redemption-song.mp3', cover: 'bob-marley-redemption-song.jpg' },
        { title: 'La Vida Es Un Carnaval', artist: 'Celia Cruz', year: '1998', filename: 'celia-cruz-vida-es-un-carnaval.mp3', cover: 'celia-cruz-vida-es-un-carnaval.jpg' },
        { title: 'Case à Lucie', artist: 'Malavoi', year: '1987', filename: 'malavoi-case-a-lucie.mp3', cover: 'malavoi-case-a-lucie.jpg' },
        // Ajoutez d'autres morceaux ici si nécessaire
    ];

    // ==================== ÉLÉMENTS DU DOM ====================
    const audioPlayer = document.getElementById('audio-player');
    const playPauseBtn = document.getElementById('play-pause-btn');
    const prevBtn = document.getElementById('prev-btn');
    const nextBtn = document.getElementById('next-btn');
    const trackNameEl = document.getElementById('track-name');
    const playerImageEl = document.getElementById('player-image');
    const progressBar = document.getElementById('progress-bar');
    const progressContainer = document.getElementById('progress-container');
    const playlistContainer = document.getElementById('maestro-playlist-container');

    // ==================== ÉTAT DU LECTEUR ====================
    let currentTrackIndex = 0;
    let isPlaying = false;

    // ==================== FONCTIONS ====================

    // Générer la playlist HTML
    function renderPlaylist() {
        playlistContainer.innerHTML = '';
        playlist.forEach((track, index) => {
            const item = document.createElement('div');
            item.className = 'mix-list-item';
            item.dataset.index = index;
            item.innerHTML = `
                <span>${track.title}</span>
                <span class="badge border border-secondary">${track.year}</span>
            `;
            item.addEventListener('click', () => loadTrack(index));
            playlistContainer.appendChild(item);
        });
    }

    // Charger un morceau
    function loadTrack(index) {
        if (index < 0 || index >= playlist.length) return;

        currentTrackIndex = index;
        const track = playlist[index];

        // Mettre à jour l'interface
        trackNameEl.textContent = `${track.artist} - ${track.title}`;
        audioPlayer.src = `${APP_URLS.music}/${track.filename}`;

        
        // Mettre à jour l'image de la pochette
        if (track.cover) {
            playerImageEl.src = `${APP_URLS.covers}/${track.cover}`;
        } else {
            // Image par défaut si aucune pochette n'est spécifiée
            playerImageEl.src = APP_URLS.defaultCover;
        }

        // Mettre à jour la surbrillance dans la playlist
        document.querySelectorAll('#maestro-playlist-container .mix-list-item').forEach((el, i) => {
            el.style.background = i === index ? 'rgba(197, 160, 89, 0.2)' : '';
        });

        // Jouer le morceau
        play();
    }

    // Jouer / Mettre en pause
    function togglePlayPause() {
        if (isPlaying) {
            pause();
        } else {
            play();
        }
    }

    function play() {
        if (!audioPlayer.src && playlist.length > 0) {
            loadTrack(0);
            return;
        }
        audioPlayer.play().then(() => {
            isPlaying = true;
            updatePlayPauseButton(true);
        }).catch(error => {
            console.error('Erreur de lecture:', error);
        });
    }

    function pause() {
        audioPlayer.pause();
        isPlaying = false;
        updatePlayPauseButton(false);
    }

    // Mettre à jour le bouton play/pause
    function updatePlayPauseButton(playing) {
        playPauseBtn.setAttribute('data-lucide', playing ? 'pause-circle' : 'play-circle');
        lucide.createIcons({ icons: [playPauseBtn] });
    }

    // ==================== ÉCOUTEURS D'ÉVÉNEMENTS ====================

    // Contrôles du lecteur
    playPauseBtn.addEventListener('click', togglePlayPause);
    prevBtn.addEventListener('click', () => loadTrack(currentTrackIndex - 1));
    nextBtn.addEventListener('click', () => loadTrack(currentTrackIndex + 1));

    // Barre de progression
    audioPlayer.addEventListener('timeupdate', () => {
        if (audioPlayer.duration) {
            const percent = (audioPlayer.currentTime / audioPlayer.duration) * 100;
            progressBar.style.width = percent + '%';
        }
    });

    progressContainer.addEventListener('click', (e) => {
        if (audioPlayer.duration) {
            const rect = progressContainer.getBoundingClientRect();
            const clickX = e.clientX - rect.left;
            audioPlayer.currentTime = (clickX / rect.width) * audioPlayer.duration;
        }
    });

    // Passer au morceau suivant à la fin
    audioPlayer.addEventListener('ended', () => {
        if (currentTrackIndex < playlist.length - 1) {
            loadTrack(currentTrackIndex + 1);
        } else {
            pause(); // Arrêter la lecture à la fin de la playlist
        }
    });

    // Gérer les erreurs de chargement
    audioPlayer.addEventListener('error', (e) => {
        console.error('Erreur de chargement audio pour:', audioPlayer.src);
        trackNameEl.textContent = 'Erreur de chargement';
        pause();
    });
    
    // Gérer l'erreur de chargement de l'image
    playerImageEl.addEventListener('error', (e) => {
        console.error('Erreur de chargement de l\'image pour:', playerImageEl.src);
        // Revenir à l'image par défaut en cas d'erreur
        playerImageEl.src = APP_URLS.defaultCover;
    });

    // ==================== INITIALISATION ====================
    
    // 1. Afficher la playlist
    renderPlaylist();
    
    // 2. Charger le premier morceau et sa pochette sans le jouer automatiquement
    if (playlist.length > 0) {
        const firstTrack = playlist[0];
        trackNameEl.textContent = `${firstTrack.artist} - ${firstTrack.title}`;
        audioPlayer.src = `${APP_URLS.music}/${firstTrack.filename}`;
        
        // Charger la pochette du premier morceau
        if (firstTrack.cover) {
            playerImageEl.src = `${APP_URLS.covers}/${firstTrack.cover}`;
        } else {
            playerImageEl.src = APP_URLS.defaultCover;
        }
        
        document.querySelector('#maestro-playlist-container .mix-list-item').style.background = 'rgba(197, 160, 89, 0.2)';
    }
});
</script>
@endpush