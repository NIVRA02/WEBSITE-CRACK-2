<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Http\Controllers\GameController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\ChatBotController;

// --- Halaman Statis ---
Route::get('/Chatbot', [ChatBotController::class, 'index']);
Route::post('/chatbot/send', [ChatBotController::class, 'sendMessage']);
Route::get('/contact', function () { return view('contact', ['title' => 'Contact Us']); });

// --- FITUR GAME ACAK (BARU) ---
Route::get('/random-game', [GameController::class, 'random'])->name('games.random');

// --- FITUR DEVELOPER ---
Route::get('/developer', [GameController::class, 'developers']);
Route::get('/developer/{developer}', [GameController::class, 'developerGames'])->name('developers.show');


// --- AUTHENTIKASI ---
Route::get('/register', function () { return view('register', ['title' => 'Daftar Akun Baru']); })->name('register')->middleware('guest');
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

Route::get('/login', function () { return view('login', ['title' => 'Login Akun']); })->name('login')->middleware('guest');
Route::post('/login', function (Request $request) {
    $credentials = $request->validate(['email' => ['required', 'email'], 'password' => ['required']]);
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


// --- RUTE GAME ---
Route::get('/', [GameController::class, 'index'])->name('home');

Route::middleware(['auth'])->group(function () {
    Route::get('/admin/upload', [GameController::class, 'create'])->name('games.create');
    Route::post('/admin/upload', [GameController::class, 'store'])->name('games.store');
    Route::get('/games/{game}/edit', [GameController::class, 'edit'])->name('games.edit');
    Route::put('/games/{game}', [GameController::class, 'update'])->name('games.update');
    Route::delete('/games/{game}', [GameController::class, 'destroy'])->name('games.destroy');
});

Route::middleware('auth')->group(function () {
    Route::post('/games/{game}/comments', [CommentController::class, 'store']);
    Route::get('/comments/{comment}/edit', [CommentController::class, 'edit'])->name('comments.edit');
    Route::put('/comments/{comment}', [CommentController::class, 'update'])->name('comments.update');
    Route::delete('/comments/{comment}', [CommentController::class, 'destroy'])->name('comments.destroy');
});

Route::get('/games/{game:title}', [GameController::class, 'show'])->name('games.show');