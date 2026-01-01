<?php

namespace App\Http\Controllers;

use App\Models\Track;
use Illuminate\Http\Request;

class TrackController extends Controller
{
    public function index()
    {
        // Récupérer tous les morceaux et les grouper par catégorie
        $tracks = Track::all()->groupBy('category');
        
        // Passer les données à la vue
        return view('mix-vault', compact('tracks'));
    }
}