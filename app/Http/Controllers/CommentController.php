<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Photo;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function store(Request $request, Photo $photo)
    {
        $data = $request->validate([
            'content' => ['required', 'string', 'max:1000'],
        ], [
            'content.required' => 'Komentar wajib diisi.',
            'content.max' => 'Komentar maksimal 1000 karakter.',
        ]);

        $photo->comments()->create([
            'user_id' => auth()->id(),
            'content' => $data['content'],
            'status' => 'pending',
        ]);

        return back()->with('status', 'Komentar terkirim dan menunggu moderasi admin.');
    }

    public function destroy(Comment $comment)
    {
        abort_unless($comment->user_id === auth()->id() || auth()->user()->isAdmin(), 403);

        $comment->delete();

        return back()->with('status', 'Komentar berhasil dihapus.');
    }
}
