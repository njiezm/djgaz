@extends('layouts.admin')

@section('title', 'Modifier un Morceau')

@section('content')
<div class="admin-header">
    <h1>Modifier le morceau : {{ $track->title }}</h1>
</div>

<div class="card">
    <div class="card-body">
        <form action="{{ route('admin.tracks.update', $track) }}" method="POST" enctype="multipart/form-data" id="track-form">
            @csrf
            @method('PUT')
            
            <div class="row mb-3">
                <label for="title" class="col-md-4 col-form-label">Titre</label>
                <div class="col-md-8">
                    <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title" value="{{ old('title', $track->title) }}" required>
                    @error('title')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="row mb-3">
                <label for="artist" class="col-md-4 col-form-label">Artiste</label>
                <div class="col-md-8">
                    <input type="text" class="form-control @error('artist') is-invalid @enderror" id="artist" name="artist" value="{{ old('artist', $track->artist) }}" required>
                    @error('artist')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="row mb-3">
                <label for="category" class="col-md-4 col-form-label">Catégorie</label>
                <div class="col-md-8">
                    <select class="form-control @error('category') is-invalid @enderror" id="category" name="category" required>
                        <option value="">Sélectionner une catégorie</option>
                        <option value="Zouk" {{ old('category', $track->category) == 'Zouk' ? 'selected' : '' }}>Zouk</option>
                        <option value="Compas" {{ old('category', $track->category) == 'Compas' ? 'selected' : '' }}>Compas</option>
                        <option value="Salsa" {{ old('category', $track->category) == 'Salsa' ? 'selected' : '' }}>Salsa</option>
                        <option value="Clubbing" {{ old('category', $track->category) == 'Clubbing' ? 'selected' : '' }}>Clubbing</option>
                        <option value="Various" {{ old('category', $track->category) == 'Various' ? 'selected' : '' }}>Various</option>
                    </select>
                    @error('category')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="row mb-3">
                <label for="duration" class="col-md-4 col-form-label">Durée</label>
                <div class="col-md-8">
                    <input type="text" class="form-control @error('duration') is-invalid @enderror" id="duration" name="duration" value="{{ old('duration', $track->duration) }}" placeholder="Ex: 3:45">
                    @error('duration')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <!-- Fichier audio actuel -->
            <div class="row mb-3">
                <label class="col-md-4 col-form-label">Fichier Audio actuel</label>
                <div class="col-md-8">
                    @if($track->file_path)
                        <div class="file-item">
                            <span>{{ basename($track->file_path) }}</span>
                            <div class="mt-2">
                                <small class="text-muted d-block mb-2">Chemin: {{ $track->file_path }}</small>
                                <audio controls class="w-100">
                                    <source src="{{ asset('storage/' . $track->file_path) }}" type="audio/mpeg">
                                    Votre navigateur ne supporte pas l'élément audio.
                                </audio>
                                <div class="mt-2">
                                    <a href="{{ asset('storage/' . $track->file_path) }}" target="_blank" class="btn btn-sm btn-outline-primary">Ouvrir dans un nouvel onglet</a>
                                </div>
                            </div>
                        </div>
                    @else
                        <p class="text-muted">Aucun fichier audio</p>
                    @endif
                </div>
            </div>

            <!-- Zone de drag & drop pour remplacer le fichier audio -->
            <div class="row mb-3">
                <label class="col-md-4 col-form-label">Remplacer le fichier audio</label>
                <div class="col-md-8">
                    <div class="dropzone" id="audio-dropzone">
                        <i data-lucide="upload-cloud"></i>
                        <p>Glissez-déposez votre nouveau fichier audio ici ou cliquez pour parcourir</p>
                        <p class="small text-muted">Formats acceptés: MP3, WAV, OGG (max. 500MB)</p>
                        <p class="small text-warning">Laissez vide pour conserver le fichier actuel</p>
                        <input type="file" id="audio_file" name="audio_file" class="d-none" accept="audio/*">
                    </div>
                    <div id="audio-file-list" class="file-list"></div>
                    @error('audio_file')
                        <div class="text-danger mt-2">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <!-- Image actuelle -->
            <div class="row mb-3">
                <label class="col-md-4 col-form-label">Image actuelle</label>
                <div class="col-md-8">
                    @if($track->image_path)
                        <div>
                            <img src="{{ asset('storage/' . $track->image_path) }}" alt="Pochette" class="img-thumbnail" style="max-height: 150px;">
                            <div class="mt-2">
                                <small class="text-muted d-block">Chemin: {{ $track->image_path }}</small>
                                <a href="{{ asset('storage/' . $track->image_path) }}" target="_blank" class="btn btn-sm btn-outline-primary">Ouvrir dans un nouvel onglet</a>
                            </div>
                        </div>
                    @else
                        <p class="text-muted">Aucune image</p>
                    @endif
                </div>
            </div>

            <!-- Zone de drag & drop pour remplacer l'image -->
            <div class="row mb-3">
                <label class="col-md-4 col-form-label">Remplacer l'image</label>
                <div class="col-md-8">
                    <div class="dropzone" id="image-dropzone">
                        <i data-lucide="image"></i>
                        <p>Glissez-déposez votre nouvelle image ici ou cliquez pour parcourir</p>
                        <p class="small text-muted">Formats acceptés: JPG, PNG, GIF (max. 10MB)</p>
                        <p class="small text-warning">Laissez vide pour conserver l'image actuelle</p>
                        <input type="file" id="image_file" name="image_file" class="d-none" accept="image/*">
                    </div>
                    <div id="image-file-list" class="file-list"></div>
                    @error('image_file')
                        <div class="text-danger mt-2">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="row">
                <div class="col-md-8 offset-md-4">
                    <button type="submit" class="btn btn-primary">Mettre à jour</button>
                    <a href="{{ route('admin.tracks.index') }}" class="btn btn-outline-secondary">Annuler</a>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    lucide.createIcons();

    // Fonction pour gérer le drag & drop
    function setupDropzone(dropzoneId, inputId, fileListId) {
        const dropzone = document.getElementById(dropzoneId);
        const fileInput = document.getElementById(inputId);
        const fileList = document.getElementById(fileListId);

        // Événements pour le drag & drop
        ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
            dropzone.addEventListener(eventName, preventDefaults, false);
        });

        function preventDefaults(e) {
            e.preventDefault();
            e.stopPropagation();
        }

        ['dragenter', 'dragover'].forEach(eventName => {
            dropzone.addEventListener(eventName, highlight, false);
        });

        ['dragleave', 'drop'].forEach(eventName => {
            dropzone.addEventListener(eventName, unhighlight, false);
        });

        function highlight() {
            dropzone.classList.add('dragover');
        }

        function unhighlight() {
            dropzone.classList.remove('dragover');
        }

        dropzone.addEventListener('drop', handleDrop, false);

        function handleDrop(e) {
            const dt = e.dataTransfer;
            const files = dt.files;
            handleFiles(files);
        }

        // Clic sur la zone pour ouvrir le sélecteur de fichiers
        dropzone.addEventListener('click', function() {
            fileInput.click();
        });

        // Gérer le changement de fichier via le sélecteur
        fileInput.addEventListener('change', function() {
            handleFiles(this.files);
        });

        function handleFiles(files) {
            if (files.length > 0) {
                const file = files[0];
                
                // Afficher le nom du fichier et sa taille
                fileList.innerHTML = `
                    <div class="file-item">
                        <span>${file.name}</span>
                        <span>${formatFileSize(file.size)}</span>
                    </div>
                `;
                
                // Mettre à jour l'input de fichier
                const dataTransfer = new DataTransfer();
                dataTransfer.items.add(file);
                fileInput.files = dataTransfer.files;
            }
        }

        function formatFileSize(bytes) {
            if (bytes === 0) return '0 Bytes';
            const k = 1024;
            const sizes = ['Bytes', 'KB', 'MB', 'GB'];
            const i = Math.floor(Math.log(bytes) / Math.log(k));
            return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
        }
    }

    // Initialiser les zones de drag & drop
    setupDropzone('audio-dropzone', 'audio_file', 'audio-file-list');
    setupDropzone('image-dropzone', 'image_file', 'image-file-list');
});
</script>
@endpush