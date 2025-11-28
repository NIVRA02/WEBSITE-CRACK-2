<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Game;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function store(Request $request, Game $game)
    {
        $request->validate(['body' => 'required|min:3|max:500']);
        $game->comments()->create([
            'user_id' => Auth::id(),
            'body' => $request->body
        ]);
        return back()->with('success', 'Komentar dikirim!');
    }

    // Form Edit Komentar -- BARU
    public function edit(Comment $comment)
    {

        if (Auth::id() !== $comment->user_id && !Auth::user()->is_admin) {
            abort(403, 'Tidak diizinkan.');
        }
        return view('comments.edit', ['comment' => $comment, 'title' => 'Edit Komentar']);
    }

    // Proses Update Komentar -- BARU
    public function update(Request $request, Comment $comment)
    {
        if (Auth::id() !== $comment->user_id && !Auth::user()->is_admin) abort(403);
        
        $request->validate(['body' => 'required|min:3|max:500']);
        $comment->update(['body' => $request->body]);
        
        return redirect()->route('games.show', $comment->game->title)->with('success', 'Komentar diupdate.');
    }

    // Hapus Komentar -- BARU
    public function destroy(Comment $comment)
    {
        if (Auth::id() !== $comment->user_id && !Auth::user()->is_admin) abort(403);
        
        $comment->delete();
        return back()->with('success', 'Komentar dihapus.');
    }
}