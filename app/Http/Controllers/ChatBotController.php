<?php

namespace App\Http\Controllers;

// --- BAGIAN INI YANG TADI KURANG SAYANG ---
use App\Http\Controllers\Controller; 
// ------------------------------------------

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ChatBotController extends Controller
{
    // 1. Tampilkan Halaman Chat
    public function index()
    {
        return view('ChatBot', ['title' => 'AI Customer Service']);
    }

    // 2. Proses Chat (Kirim ke Gemini)
    public function sendMessage(Request $request)
    {
        // Validasi input user
        $request->validate([
            'message' => 'required|string'
        ]);

        $userMessage = $request->input('message');
        $apiKey = env('GEMINI_API_KEY');

        // Konteks Sistem (Info Toko/Website kamu)
        $systemContext = "Kamu adalah asisten customer service untuk website 'NIVRA02' (platform download game gratis). 
                          Jawablah dengan sopan, ramah, dan singkat. 
                          Jika user bertanya tentang game, arahkan mereka ke menu Developer atau kolom pencarian.";

        // Kirim Request ke Google Gemini API
        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
        ])->post("https://generativelanguage.googleapis.com/v1beta/models/gemini-1.5-flash:generateContent?key={$apiKey}", [
            'contents' => [
                [
                    'role' => 'user',
                    'parts' => [
                        ['text' => $systemContext . "\n\nUser: " . $userMessage]
                    ]
                ]
            ]
        ]);

        // Ambil Jawaban AI
        if ($response->successful()) {
            $data = $response->json();
            $aiReply = $data['candidates'][0]['content']['parts'][0]['text'] ?? 'Maaf, saya tidak mengerti.';
            return response()->json(['reply' => $aiReply]);
        } else {
            return response()->json(['reply' => 'Maaf, terjadi kesalahan pada server AI.'], 500);
        }
    }
}