<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Models\Game; 

class ChatBotController extends Controller
{
    public function index()
    {
        return view('ChatBot', ['title' => 'AI Customer Service']);
    }

    public function sendMessage(Request $request)
    {
        $request->validate([
            'message' => 'required|string'
        ]);

        $userMessage = $request->input('message');
        $apiKey = env('GEMINI_API_KEY');


        // 1. AMBIL DATA GAME DARI DATABASE (Biar AI-nya Gak Halusinasi)
        $games = Game::all(['title', 'developer', 'description', 'requirements']);
        
        $gameList = "";
        if ($games->count() > 0) {
            foreach ($games as $game) {
                $gameList .= "- Judul: {$game->title} (Dev: {$game->developer}). Info: {$game->description}. Syarat: {$game->requirements}\n";
            }
        } else {
            $gameList = "Stok game lagi kosong nih sayang.";
        }

   
        $systemContext = "
            PERAN:
            Kamu adalah 'Mami Nivra', asisten cantik penjaga website game 'NIVRA02'.
            Karaktermu: Dewasa, keibuan, perhatian, sedikit menggoda (tipe Ara-ara/Onee-san), dan sangat sayang pada user.

            ATURAN PENTING:
            1. JANGAN PERNAH merekomendasikan game yang TIDAK ADA di daftar data di bawah ini. Kalau user tanya game luar (misal: GTA V, Resident Evil), bilang maaf game itu belum ada, lalu tawarkan game yang ADA di data kita.
            2. Panggil user dengan: 'Sayang', 'Manis', atau 'Nak'. Panggil dirimu 'Mami'.
            3. Gunakan emoji (😘, 😉, ❤️) biar luwes.

            DATA GAME YANG TERSEDIA DI WEBSITE KITA (Hafalkan ini):
            {$gameList}

            TUGAS:
            Jawablah pertanyaan user ini berdasarkan data di atas:
        ";


        $model = 'gemini-2.5-flash'; 

        try {
            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
            ])->post("https://generativelanguage.googleapis.com/v1beta/models/{$model}:generateContent?key={$apiKey}", [
                'contents' => [
                    [
                        'role' => 'user',
                        'parts' => [
                            ['text' => $systemContext . "\n\nPertanyaan User: " . $userMessage]
                        ]
                    ]
                ]
            ]);

            if ($response->failed()) {
                return response()->json(['reply' => "Aduh, sinyal Mami lagi jelek nih sayang. Coba lagi ya.."]);
            }

            $data = $response->json();
            $aiReply = $data['candidates'][0]['content']['parts'][0]['text'] ?? 'Mami kurang paham, coba ulang lagi dong manis?';
            return response()->json(['reply' => $aiReply]);

        } catch (\Exception $e) {
            return response()->json(['reply' => "Ada masalah sistem nih nak. Sabar ya."]);
        }
    }
}