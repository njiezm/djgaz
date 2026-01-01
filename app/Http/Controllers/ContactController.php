<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function submit(Request $request)
    {
        // Validation des données
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'message' => 'required|string|max:1000',
        ]);
        
        // Ici, vous pourriez envoyer un email ou sauvegarder en base de données
        // Pour l'instant, nous allons simplement rediriger avec un message de succès
        
        return redirect()->route('contact')->with('success', 'Merci pour votre message. Il a été reçu avec appréciation.');
    }
}