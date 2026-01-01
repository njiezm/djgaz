<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class TrackSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tracks = [
            // Zouk Archives
            ['title' => 'Zouk Retro Masterclass 90-95', 'artist' => 'DJ GAZ', 'category' => 'Zouk', 'file_path' => 'tracks/zouk/zouk-retro-masterclass.mp3', 'duration' => '58:12'],
            ['title' => 'Douceur Antillaise Live @ Top 50', 'artist' => 'DJ GAZ', 'category' => 'Zouk', 'file_path' => 'tracks/zouk/douceur-antillaise.mp3', 'duration' => '45:30'],
            ['title' => 'Chirurgical Mix Vol. 1', 'artist' => 'DJ GAZ', 'category' => 'Zouk', 'file_path' => 'tracks/zouk/chirurgical-v1.mp3', 'duration' => '62:05'],
            
            // Compas Gold
            ['title' => 'Compas Direct Connection', 'artist' => 'DJ GAZ', 'category' => 'Compas', 'file_path' => 'tracks/compas/direct-connection.mp3', 'duration' => '51:44'],
            ['title' => 'Haïti Chérie Special Mix', 'artist' => 'DJ GAZ', 'category' => 'Compas', 'file_path' => 'tracks/compas/haiti-cherie.mp3', 'duration' => '48:20'],
            
            // Latin Vibes
            ['title' => 'Salsa Dura Sessions', 'artist' => 'DJ GAZ', 'category' => 'Salsa', 'file_path' => 'tracks/salsa/salsa-dura.mp3', 'duration' => '55:15'],
            ['title' => 'Celia Cruz Tribute', 'artist' => 'DJ GAZ', 'category' => 'Salsa', 'file_path' => 'tracks/salsa/celia-cruz-tribute.mp3', 'duration' => '49:00'],

            // Clubbing & Various
            ['title' => 'Club Classics 90s', 'artist' => 'DJ GAZ', 'category' => 'Clubbing', 'file_path' => 'tracks/clubbing/club-classics.mp3', 'duration' => '70:22'],
            ['title' => 'Funk & Soul Collection', 'artist' => 'DJ GAZ', 'category' => 'Various', 'file_path' => 'tracks/various/funk-soul.mp3', 'duration' => '65:10'],
        ];

        DB::table('tracks')->insert($tracks);
    }
}