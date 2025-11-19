<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Http\Controllers\GameController; // <--- WAJIB
use App\Http\Controllers\CommentController; // <--- WAJIB

// --- Rute Halaman Statis ---
// Route yang ini bisa tetap menggunakan fungsi (closure)
Route::get('/', function () {
    // Arahkan / ke controller index Game, bukan home view statis lagi
    return app(GameController::class)->index(); 
});

Route::get('/developer', function () {
    return view('developer', ['title' => 'Developer']);
});
Route::get('/Chatbot', function () {
    return view('Chatbot', ['title' => 'Chat Bot']);
});
Route::get('/contact', function () {
    return view('contact', ['title' => 'Contact Us']);
});


// --- Rute AUTHENTIKASI (Login, Register, Logout) ---
// Gunakan route yang lebih rapi dengan nama
Route::get('/register', function () {
    return view('register', ['title' => 'Daftar Akun Baru']);
})->name('register')->middleware('guest');

Route::post('/register', function (Request $request) {
    $attributes = $request->validate([
        'name' => ['required', 'min:3', 'max:255'],
        'email' => ['required', 'email', 'max:255', 'unique:users,email'],
        'password' => ['required', 'min:5', 'max:255', 'confirmed'],
    ]);
    $user = User::create($attributes);
    Auth::login($user);
    return redirect('/')->with('success', 'Pendaftaran berhasil! Selamat datang.');
})->middleware('guest');


Route::get('/login', function () {
    return view('login', ['title' => 'Login Akun']);
})->name('login')->middleware('guest');

Route::post('/login', function (Request $request) {
    $credentials = $request->validate([
        'email' => ['required', 'email'],
        'password' => ['required'],
    ]);

    if (Auth::attempt($credentials)) {
        $request->session()->regenerate();
        return redirect()->intended('/')->with('success', 'Anda berhasil masuk.');
    }

    return back()->withErrors(['email' => 'Email atau password salah.'])->onlyInput('email');
})->middleware('guest');

Route::post('/logout', function (Request $request) {
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    return redirect('/')->with('success', 'Anda berhasil keluar.');
})->middleware('auth');


// --- Rute GAME (Utama) ---

// Halaman Depan (List Game) - Sudah di handle di route '/' di atas.

// Halaman Detail Game
Route::get('/games/{game:title}', [GameController::class, 'show'])->name('games.show');

// Rute Komentar (Hanya user login)
Route::post('/games/{game}/comments', [CommentController::class, 'store'])->middleware('auth');


// --- Rute ADMIN (Upload Game) ---
// Route ini hanya bisa diakses oleh user yang sudah login ('auth')
Route::middleware(['auth'])->group(function () {
    // Tampilkan Form Upload
    Route::get('/admin/upload', [GameController::class, 'create'])->name('games.create');
    // Proses Simpan Game
    Route::post('/admin/upload', [GameController::class, 'store'])->name('games.store');
});