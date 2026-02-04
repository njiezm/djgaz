@extends('layouts.admin')

@section('title', 'Ajouter un Morceau')

@section('content')
<div class="admin-header">
    <h1>Ajouter un nouveau morceau</h1>
</div>

<div class="card">
    <div class="card-body">
        <form action="{{ route('admin.tracks.store') }}" method="POST" enctype="multipart/form-data" id="track-form">
            @csrf
            
            <div class="row mb-3">
                <label for="title" class="col-md-4 col-form-label">Titre</label>
                <div class="col-md-8">
                    <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title" value="{{ old('title') }}" required>
                    @error('title')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="row mb-3">
                <label for="artist" class="col-md-4 col-form-label">Artiste</label>
                <div class="col-md-8">
                    <input type="text" class="form-control @error('artist') is-invalid @enderror" id="artist" name="artist" value="{{ old('artist') }}" required>
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
                        <option value="Zouk" {{ old('category') == 'Zouk' ? 'selected' : '' }}>Zouk</option>
                        <option value="Compas" {{ old('category') == 'Compas' ? 'selected' : '' }}>Compas</option>
                        <option value="Salsa" {{ old('category') == 'Salsa' ? 'selected' : '' }}>Salsa</option>
                        <option value="Merengue" {{ old('category') == 'Merengue' ? 'selected' : '' }}>Merengue</option>
                        <option value="Mazouka" {{ old('category') == 'Mazouka' ? 'selected' : '' }}>Mazouka</option>
                        <option value="Bouyon" {{ old('category') == 'Bouyon' ? 'selected' : '' }}>Bouyon</option>
                        <option value="Kizomba" {{ old('category') == 'Kizomba' ? 'selected' : '' }}>Kizomba</option>
                        <option value="Clubbing" {{ old('category') == 'Clubbing' ? 'selected' : '' }}>Clubbing</option>
                        <option value="Various" {{ old('category') == 'Various' ? 'selected' : '' }}>Various</option>
                        <option value="Hip-Hop" {{ old('category') == 'Hip-Hop' ? 'selected' : '' }}>Hip-Hop</option>
                        <option value="R&B" {{ old('category') == 'R&B' ? 'selected' : '' }}>R&B</option>
                        <option value="Soka" {{ old('category') == 'Soka' ? 'selected' : '' }}>Soka</option>
                        <option value="Dancehall" {{ old('category') == 'Dancehall' ? 'selected' : '' }}>Dancehall</option>
                        <option value="Reggae" {{ old('category') == 'Reggae' ? 'selected' : '' }}>Reggae</option>
                        <option value="Other" {{ old('category') == 'Other' ? 'selected' : '' }}>Other</option>
                    </select>
                    @error('category')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="row mb-3">
                <label for="duration" class="col-md-4 col-form-label">Durée</label>
                <div class="col-md-8">
                    <input type="text" class="form-control @error('duration') is-invalid @enderror" id="duration" name="duration" value="{{ old('duration') }}" placeholder="Ex: 3:45">
                    @error('duration')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <!-- Zone de drag & drop pour le fichier audio -->
            <div class="row mb-3">
                <label class="col-md-4 col-form-label">Fichier Audio</label>
                <div class="col-md-8">
                    <div class="dropzone" id="audio-dropzone">
                        <i data-lucide="upload-cloud"></i>
                        <p>Glissez-déposez votre fichier audio ici ou cliquez pour parcourir</p>
                        <p class="small text-muted">Formats acceptés: MP3, WAV, OGG (max. 500MB)</p>
                        <input type="file" id="audio_file" name="audio_file" class="d-none" accept="audio/*" required>
                    </div>
                    <div id="audio-file-list" class="file-list"></div>
                    @error('audio_file')
                        <div class="text-danger mt-2">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <!-- Zone de drag & drop pour l'image de la pochette -->
            <div class="row mb-3">
                <label class="col-md-4 col-form-label">Image de la pochette (optionnel)</label>
                <div class="col-md-8">
                    <div class="dropzone" id="image-dropzone">
                        <i data-lucide="image"></i>
                        <p>Glissez-déposez votre image ici ou cliquez pour parcourir</p>
                        <p class="small text-muted">Formats acceptés: JPG, PNG, GIF (max. 10MB)</p>
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
                    <button type="submit" class="btn btn-primary">Enregistrer</button>
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
                
                // Afficher le nom du fichier
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