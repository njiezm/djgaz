<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Track;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;

class TrackController extends Controller
{
    // Affiche la liste de tous les morceaux
    public function index()
    {
        $tracks = Track::latest()->paginate(10);
        return view('admin.tracks.index', compact('tracks'));
    }

    // Affiche le formulaire de création
    public function create()
    {
        return view('admin.tracks.create');
    }

    // Enregistre le nouveau morceau
     public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'artist' => 'required|string|max:255',
            'category' => 'required|string|max:100',
            'audio_file' => 'required|mimes:mp3,wav,ogg|max:512000', // 50MB max
            'image_file' => 'nullable|mimes:jpg,jpeg,png,gif|max:10240', // 10MB max
            'duration' => 'nullable|string|max:10',
        ]);

        // Gérer le fichier audio
        $audioFilePath = null;
        if ($request->hasFile('audio_file')) {
            $audioFile = $request->file('audio_file');
            $audioFileName = time() . '_' . Str::slug($request->title) . '.' . $audioFile->getClientOriginalExtension();
            
            // Créer le répertoire s'il n'existe pas
            $audioPath = 'tracks/' . Str::slug($request->category);
            Storage::disk('public')->makeDirectory($audioPath);
            
            // Stocker le fichier
            $audioFilePath = $audioFile->storeAs($audioPath, $audioFileName, 'public');
            
            // Log pour le débogage
            Log::info('Fichier audio uploadé: ' . $audioFilePath);
            Log::info('Chemin complet: ' . storage_path('app/' . $audioFilePath));
            
            // Vérifier que le fichier existe
            if (Storage::disk('public')->exists($audioFilePath)) {
                Log::info('Le fichier audio existe bien dans le stockage');
            } else {
                Log::error('Le fichier audio n\'existe pas dans le stockage');
            }
        }

        // Gérer l'image de la pochette
        $imageFilePath = null;
        if ($request->hasFile('image_file')) {
            $imageFile = $request->file('image_file');
            $imageFileName = time() . '_' . Str::slug($request->title) . '.' . $imageFile->getClientOriginalExtension();
            
            // Créer le répertoire s'il n'existe pas
            $imagePath = 'images/tracks/' . Str::slug($request->category);
            Storage::disk('public')->makeDirectory($imagePath);
            
            // Stocker le fichier
            $imageFilePath = $imageFile->storeAs($imagePath, $imageFileName, 'public');
            
            // Log pour le débogage
            Log::info('Fichier image uploadé: ' . $imageFilePath);
            Log::info('Chemin complet: ' . storage_path('app/' . $imageFilePath));
            
            // Vérifier que le fichier existe
            if (Storage::disk('public')->exists($imageFilePath)) {
                Log::info('Le fichier image existe bien dans le stockage');
            } else {
                Log::error('Le fichier image n\'existe pas dans le stockage');
            }
        }

        // Créer le morceau
        $track = Track::create([
            'title' => $request->title,
            'artist' => $request->artist,
            'category' => $request->category,
            'file_path' => $audioFilePath,
            'image_path' => $imageFilePath,
            'duration' => $request->duration,
        ]);
        
        Log::info('Morceau créé avec ID: ' . $track->id);
        
        return redirect()->route('admin.tracks.index')
                         ->with('success', 'Morceau ajouté avec succès.');
    }

    // Affiche les détails d'un morceau (non utilisé pour l'instant)
    public function show(Track $track)
    {
        //
    }

    // Affiche le formulaire d'édition
    public function edit(Track $track)
    {
        return view('admin.tracks.edit', compact('track'));
    }

    // Met à jour le morceau
    public function update(Request $request, Track $track)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'artist' => 'required|string|max:255',
            'category' => 'required|string|max:100',
            'audio_file' => 'nullable|mimes:mp3,wav,ogg|max:512000', // 50MB max
            'image_file' => 'nullable|mimes:jpg,jpeg,png,gif|max:10240', // 10MB max
            'duration' => 'nullable|string|max:10',
        ]);

        // Préparer les données à mettre à jour
        $updateData = [
            'title' => $request->title,
            'artist' => $request->artist,
            'category' => $request->category,
            'duration' => $request->duration,
        ];

        // Gérer le nouveau fichier audio si fourni
        if ($request->hasFile('audio_file')) {
            // Supprimer l'ancien fichier
            if ($track->file_path) {
                Storage::delete('public/' . $track->file_path);
            }

            $audioFile = $request->file('audio_file');
            $audioFileName = time() . '_' . Str::slug($request->title) . '.' . $audioFile->getClientOriginalExtension();
            
            // Créer le répertoire s'il n'existe pas
            $audioPath = 'public/tracks/' . Str::slug($request->category);
            Storage::makeDirectory($audioPath);
            
            // Stocker le fichier
            $audioFilePath = $audioFile->storeAs($audioPath, $audioFileName);
            $updateData['file_path'] = str_replace('public/', '', $audioFilePath);
        }

        // Gérer la nouvelle image si fournie
        if ($request->hasFile('image_file')) {
            // Supprimer l'ancienne image
            if ($track->image_path) {
                Storage::delete('public/' . $track->image_path);
            }

            $imageFile = $request->file('image_file');
            $imageFileName = time() . '_' . Str::slug($request->title) . '.' . $imageFile->getClientOriginalExtension();
            
            // Créer le répertoire s'il n'existe pas
            $imagePath = 'public/images/tracks/' . Str::slug($request->category);
            Storage::makeDirectory($imagePath);
            
            // Stocker le fichier
            $imageFilePath = $imageFile->storeAs($imagePath, $imageFileName);
            $updateData['image_path'] = str_replace('public/', '', $imageFilePath);
        }

        $track->update($updateData);

        return redirect()->route('admin.tracks.index')
                         ->with('success', 'Morceau mis à jour avec succès.');
    }

    // Supprime le morceau
    public function destroy(Track $track)
    {
        // Supprimer les fichiers associés
        if ($track->file_path) {
            Storage::delete('public/' . $track->file_path);
        }
        if ($track->image_path) {
            Storage::delete('public/' . $track->image_path);
        }

        $track->delete();

        return redirect()->route('admin.tracks.index')
                         ->with('success', 'Morceau supprimé avec succès.');
    }
}