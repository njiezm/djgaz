@extends('layouts.admin')

@section('title', 'Gérer les Morceaux')

@section('content')
<div class="admin-header">
    <h1>Gérer les Morceaux</h1>
    <a href="{{ route('admin.tracks.create') }}" class="btn btn-primary">
        <i data-lucide="plus-circle" style="width: 18px; height: 18px; margin-right: 8px;"></i>
        Ajouter un morceau
    </a>
</div>

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Titre</th>
                        <th>Artiste</th>
                        <th>Catégorie</th>
                        <th>Durée</th>
                        <th>Fichier Audio</th>
                        <th>Image</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($tracks as $track)
                        <tr>
                            <td>{{ $track->title }}</td>
                            <td>{{ $track->artist }}</td>
                            <td>{{ $track->category }}</td>
                            <td>{{ $track->duration ?? 'N/A' }}</td>
                            <td>
                                @if($track->file_path)
                                    <small>{{ $track->file_path }}</small>
                                    <br>
                                    <a href="{{ asset('storage/' . $track->file_path) }}" target="_blank" class="btn btn-sm btn-outline-primary mt-1">Vérifier</a>
                                @else
                                    <span class="text-muted">N/A</span>
                                @endif
                            </td>
                            <td>
                                @if($track->image_path)
                                    <small>{{ $track->image_path }}</small>
                                    <br>
                                    <img src="{{ asset('storage/' . $track->image_path) }}" alt="Pochette" class="img-thumbnail mt-1" style="max-height: 50px;">
                                @else
                                    <span class="text-muted">N/A</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('admin.tracks.edit', $track) }}" class="btn btn-sm btn-outline-secondary me-1">
                                    <i data-lucide="edit" style="width: 16px; height: 16px;"></i>
                                </a>
                                <form action="{{ route('admin.tracks.destroy', $track) }}" method="POST" style="display: inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce morceau ?');">
                                        <i data-lucide="trash-2" style="width: 16px; height: 16px;"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center">Aucun morceau trouvé.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

{{ $tracks->links() }}
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        lucide.createIcons();
    });
</script>
@endpush