<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Http\Controllers\GameController;
use App\Http\Controllers\CommentController;

// --- Rute Halaman Statis ---
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

// 1. Tampilkan Halaman Register
Route::get('/register', function () {
    return view('register', ['title' => 'Daftar Akun Baru']);
})->name('register')->middleware('guest');

// 2. Proses Data Register
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


// 3. Tampilkan Halaman Login
Route::get('/login', function () {
    return view('login', ['title' => 'Login Akun']);
})->name('login')->middleware('guest');

// 4. Proses Login
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


// 5. Proses Logout
Route::post('/logout', function (Request $request) {
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    return redirect('/')->with('success', 'Anda berhasil keluar.');
})->middleware('auth');


// --- Rute GAME (Utama) ---

// Halaman Depan (List Game)
Route::get('/', [GameController::class, 'index'])->name('home');

// Halaman Detail Game
Route::get('/games/{game:title}', [GameController::class, 'show'])->name('games.show');

// Rute Komentar (Hanya user login)
Route::post('/games/{game}/comments', [CommentController::class, 'store'])->middleware('auth');


// --- Rute ADMIN (Upload Game) ---

Route::middleware(['auth', 'is_admin'])->group(function () {
    // Tampilkan Form Upload
    Route::get('/admin/upload', [GameController::class, 'create'])->name('games.create');
    // Proses Simpan Game
    Route::post('/admin/upload', [GameController::class, 'store'])->name('games.store');
});

// Catatan: Anda perlu membuat Middleware 'is_admin' di Laravel jika ingin proteksi lebih kuat.
// Untuk saat ini, cek Admin sudah dilakukan di dalam controller.