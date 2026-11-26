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
            'session_id' => $request->session()->getId(),
            'content' => $data['content'],
            'status' => 'approved',
        ]);

        return back()->with('status', 'Komentar berhasil dikirim dan langsung ditampilkan.');
    }

    public function destroy(Comment $comment, Request $request)
    {
        $userId = auth()->id();
        $sessionId = $request->session()->getId();

        $canDelete = false;

        if ($userId) {
            $canDelete = $comment->user_id === $userId || auth()->user()->isAdmin();
        } elseif ($sessionId) {
            $canDelete = $comment->session_id === $sessionId || auth()->user()->isAdmin();
        }

        abort_unless($canDelete, 403);

        $comment->delete();

        return back()->with('status', 'Komentar berhasil dihapus.');
    }
}
