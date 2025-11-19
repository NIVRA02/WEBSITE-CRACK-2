<?php

namespace App\Http\Controllers;

use App\Models\Game;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GameController extends Controller
{
    // 1. Halaman Utama (List Game)
    public function index()
    {
        $games = Game::latest()->get();
        return view('games.index', ['games' => $games, 'title' => 'Katalog Game Gratis']);
    }

    // 2. Halaman Detail Game
    public function show(Game $game)
    {
        // Untuk mengubah link trailer YouTube dari format tontonan ke embed
        $videoId = $this->getYouTubeEmbedId($game->trailer_url);

        return view('games.show', [
            'game' => $game, 
            'title' => $game->title,
            'videoId' => $videoId
        ]);
    }

    // 3. Halaman Form Upload (Hanya Admin)
    public function create()
    {
        // Cek apakah user admin? Middleware Auth sudah memproteksi route ini.
        if (!Auth::user()->is_admin) {
             return redirect('/')->with('error', 'Akses ditolak! Anda bukan Admin.');
        }
        return view('games.create', ['title' => 'Upload Game Baru']);
    }

    // 4. Proses Simpan Game ke Database
    public function store(Request $request)
    {
        // Validasi: Hanya Admin yang bisa mengakses dan mengupload
        if (!Auth::user()->is_admin) {
            abort(403, 'Akses Ditolak');
        }

        $validated = $request->validate([
            'title' => 'required|max:255',
            'developer' => 'required|max:255',
            'description' => 'required',
            'requirements' => 'required',
            'poster' => 'required|image|mimes:jpeg,png,jpg|max:2048', // Max 2MB
            'trailer_url' => 'nullable|url',
            'download_link' => 'required|url'
        ]);

        // Upload Gambar Poster ke folder storage/app/public/posters
        if ($request->hasFile('poster')) {
            $validated['poster'] = $request->file('poster')->store('posters', 'public');
        }

        Game::create($validated);

        return redirect('/')->with('success', 'Game berhasil diupload dan dipublikasikan!');
    }

    // Fungsi Pembantu untuk YouTube
    private function getYouTubeEmbedId($url) {
        if (preg_match('/watch\?v=([a-zA-Z0-9_-]+)/', $url, $matches)) {
            return $matches[1];
        } elseif (preg_match('/youtu\.be\/([a-zA-Z0-9_-]+)/', $url, $matches)) {
            return $matches[1];
        }
        return null;
    }
}