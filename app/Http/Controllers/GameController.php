<?php

namespace App\Http\Controllers;

use App\Models\Game;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB; // <--- Tambahan Penting

class GameController extends Controller
{
    // 1. Halaman Utama (Semua Game)
    public function index()
    {
        $games = Game::latest()->get();
        return view('games.index', ['games' => $games, 'title' => 'Katalog Game Gratis']);
    }

    // 2. Halaman Detail Game
    public function show(Game $game)
    {
        $videoId = $this->getYouTubeEmbedId($game->trailer_url);
        return view('games.show', ['game' => $game, 'title' => $game->title, 'videoId' => $videoId]);
    }

    // --- BAGIAN BARU: FITUR DEVELOPER ---

    // 3. Halaman List Semua Developer
    public function developers()
    {
        // Mengambil nama developer unik & menghitung jumlah game mereka
        $developers = Game::select('developer', DB::raw('count(*) as total_games'))
                          ->groupBy('developer')
                          ->orderBy('developer', 'asc')
                          ->get();

        return view('Developer', [
            'developers' => $developers, 
            'title' => 'Daftar Developer'
        ]);
    }

    // 4. Halaman Game per Developer
    public function developerGames($developer)
    {
        // Ambil semua game milik developer tersebut
        $games = Game::where('developer', $developer)->latest()->get();
        
        // Kita gunakan tampilan 'games.index' yang sudah ada, tapi datanya kita filter
        return view('games.index', [
            'games' => $games, 
            'title' => 'Game oleh: ' . $developer
        ]);
    }

    // --- AKHIR BAGIAN BARU ---

    // 5. Form Upload (Admin)
    public function create()
    {
        if (!Auth::user()->is_admin) return redirect('/')->with('error', 'Bukan Admin!');
        return view('games.create', ['title' => 'Upload Game Baru']);
    }

    // 6. Proses Upload (Admin)
    public function store(Request $request)
    {
        if (!Auth::user()->is_admin) abort(403);

        $validated = $request->validate([
            'title' => 'required|max:255',
            'developer' => 'required|max:255',
            'description' => 'required',
            'requirements' => 'required',
            'poster' => 'required|image|mimes:jpeg,png,jpg|max:4096',
            'trailer_url' => 'nullable|url',
            'download_link' => 'required|url'
        ]);

        if ($request->hasFile('poster') && $request->file('poster')->isValid()) {
            $validated['poster'] = $request->file('poster')->store('posters', 'public');
        } else {
            return back()->withErrors(['poster' => 'Gagal upload gambar. Cek ukuran file.']);
        }

        Game::create($validated);
        return redirect('/')->with('success', 'Game berhasil diupload!');
    }

    // 7. Form Edit (Admin)
    public function edit(Game $game)
    {
        if (!Auth::user()->is_admin) abort(403);
        return view('games.edit', ['game' => $game, 'title' => 'Edit Game']);
    }

    // 8. Proses Update (Admin)
    public function update(Request $request, Game $game)
    {
        if (!Auth::user()->is_admin) abort(403);

        $rules = [
            'title' => 'required|max:255',
            'developer' => 'required|max:255',
            'description' => 'required',
            'requirements' => 'required',
            'trailer_url' => 'nullable|url',
            'download_link' => 'required|url'
        ];

        if ($request->hasFile('poster')) {
            $rules['poster'] = 'image|mimes:jpeg,png,jpg|max:4096';
        }

        $validated = $request->validate($rules);

        if ($request->hasFile('poster') && $request->file('poster')->isValid()) {
            if ($game->poster) Storage::disk('public')->delete($game->poster);
            $validated['poster'] = $request->file('poster')->store('posters', 'public');
        }

        $game->update($validated);
        return redirect()->route('games.show', $game->title)->with('success', 'Game berhasil diupdate!');
    }

    // 9. Proses Hapus (Admin)
    public function destroy(Game $game)
    {
        if (!Auth::user()->is_admin) abort(403);

        if ($game->poster) Storage::disk('public')->delete($game->poster);
        $game->delete();

        return redirect('/')->with('success', 'Game berhasil dihapus!');
    }

    private function getYouTubeEmbedId($url) {
        if (preg_match('/watch\?v=([a-zA-Z0-9_-]+)/', $url, $matches)) return $matches[1];
        elseif (preg_match('/youtu\.be\/([a-zA-Z0-9_-]+)/', $url, $matches)) return $matches[1];
        return null;
    }
}