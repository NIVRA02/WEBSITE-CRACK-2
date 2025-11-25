<?php

namespace App\Http\Controllers;

use App\Models\Game;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB; // PENTING: Untuk fitur developer

class GameController extends Controller
{
    // ==========================================
    // BAGIAN 1: FITUR UNTUK USER (PUBLIC)
    // ==========================================

    // 1. Halaman Utama (List Semua Game)
    public function index()
    {
        $games = Game::latest()->get();
        return view('games.index', ['games' => $games, 'title' => 'Katalog Game Gratis']);
    }

    // 2. Halaman Detail Game
    public function show(Game $game)
    {
        // Ubah link youtube jadi embed code biar bisa diputar di web
        $videoId = $this->getYouTubeEmbedId($game->trailer_url);
        
        return view('games.show', [
            'game' => $game, 
            'title' => $game->title, 
            'videoId' => $videoId
        ]);
    }

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

    // 4. Halaman Game per Developer (Saat kartu developer diklik)
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

    // 5. Fitur Game Acak (Surprise Me)
    public function random()
    {
        // Ambil 1 game secara acak dari database
        $game = Game::inRandomOrder()->first();

        // Cek jika database kosong
        if (!$game) {
            return redirect('/')->with('error', 'Belum ada game yang bisa diacak nih, sayang.');
        }

        // Langsung lempar ke halaman detail game tersebut
        return redirect()->route('games.show', $game->title);
    }


    // ==========================================
    // BAGIAN 2: FITUR KHUSUS ADMIN (CRUD)
    // ==========================================

    // 6. Tampilkan Form Upload
    public function create()
    {
        // Cek apakah user adalah Admin
        if (!Auth::user()->is_admin) {
            return redirect('/')->with('error', 'Maaf sayang, halaman ini khusus Admin ya!');
        }
        return view('games.create', ['title' => 'Upload Game Baru']);
    }

    // 7. Proses Simpan Game Baru (Store)
    public function store(Request $request)
    {
        // Validasi Keamanan
        if (!Auth::user()->is_admin) abort(403);

        $validated = $request->validate([
            'title' => 'required|max:255',
            'developer' => 'required|max:255',
            'description' => 'required',
            'requirements' => 'required',
            'poster' => 'required|image|mimes:jpeg,png,jpg|max:4096', // Max 4MB
            'trailer_url' => 'nullable|url',
            'download_link' => 'required|url'
        ]);

        // Upload Poster
        if ($request->hasFile('poster') && $request->file('poster')->isValid()) {
            $validated['poster'] = $request->file('poster')->store('posters', 'public');
        } else {
            return back()->withErrors(['poster' => 'Gagal upload gambar. Pastikan ukurannya di bawah 4MB.']);
        }

        Game::create($validated);

        return redirect('/')->with('success', 'Yeay! Game berhasil diupload!');
    }

    // 8. Tampilkan Form Edit
    public function edit(Game $game)
    {
        if (!Auth::user()->is_admin) abort(403);
        
        return view('games.edit', [
            'game' => $game, 
            'title' => 'Edit Game'
        ]);
    }

    // 9. Proses Update Game
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

        // Poster hanya divalidasi jika user mengupload file baru
        if ($request->hasFile('poster')) {
            $rules['poster'] = 'image|mimes:jpeg,png,jpg|max:4096';
        }

        $validated = $request->validate($rules);

        // Cek jika ada poster baru
        if ($request->hasFile('poster') && $request->file('poster')->isValid()) {
            // Hapus poster lama biar gak menuhin server
            if ($game->poster) {
                Storage::disk('public')->delete($game->poster);
            }
            // Simpan poster baru
            $validated['poster'] = $request->file('poster')->store('posters', 'public');
        }

        $game->update($validated);

        return redirect()->route('games.show', $game->title)->with('success', 'Game berhasil diperbarui!');
    }

    // 10. Proses Hapus Game
    public function destroy(Game $game)
    {
        if (!Auth::user()->is_admin) abort(403);

        // Hapus file poster dari penyimpanan
        if ($game->poster) {
            Storage::disk('public')->delete($game->poster);
        }

        // Hapus data dari database
        $game->delete();

        return redirect('/')->with('success', 'Game berhasil dihapus permanen.');
    }

    // ==========================================
    // FUNGSI BANTUAN (HELPER)
    // ==========================================

    // Mengambil ID Video dari URL YouTube (agar bisa di-embed)
    private function getYouTubeEmbedId($url) {
        if (preg_match('/watch\?v=([a-zA-Z0-9_-]+)/', $url, $matches)) {
            return $matches[1];
        } elseif (preg_match('/youtu\.be\/([a-zA-Z0-9_-]+)/', $url, $matches)) {
            return $matches[1];
        }
        return null;
    }
}