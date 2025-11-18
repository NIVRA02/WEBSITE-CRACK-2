<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;


// --- Halaman Utama ---
Route::get('/', function () {
    return view('home', ['title' => 'Home Page']);
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




// --- Authentikasi (Login & Logout) ---

// 1. Tampilkan Halaman Login
Route::get('/login', function () {
    return view('login', ['title' => 'Login']);
})->name('login');

// 2. Proses Login (POST)
Route::post('/login', function (Request $request) {
    $credentials = $request->validate([
        'email' => ['required', 'email'],
        'password' => ['required'],
    ]);

    if (Auth::attempt($credentials)) {
        $request->session()->regenerate();
        return redirect()->intended('/');
    }

    return back()->withErrors([
        'email' => 'Email atau password salah.',
    ])->onlyInput('email');
});

// 3. Proses Logout (POST)
Route::post('/logout', function (Request $request) {
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    return redirect('/');
});

Route::get('/register', function () {
    return view('register', ['title' => 'Register']);
});

Route::post('/register', function (Request $request) {
    // Validasi Input
    $attributes = $request->validate([
        'name' => ['required', 'min:3', 'max:255'],
        'email' => ['required', 'email', 'max:255', 'unique:users,email'], // Pastikan email belum terpakai
        'password' => ['required', 'min:5', 'max:255', 'confirmed'], // 'confirmed' cek kecocokan dengan password_confirmation
    ]);

    // Buat User Baru
    // Password otomatis di-hash karena settingan di User Model
    $user = User::create($attributes);

    // Langsung Login otomatis setelah daftar
    Auth::login($user);

    // Redirect ke halaman utama
    return redirect('/');
});