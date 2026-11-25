<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function index(Request $request)
    {
        $status = trim((string) $request->query('status', '')) ?: null;
        $search = trim((string) $request->query('q', ''));

        $comments = Comment::query()
            ->when($status, fn ($query) => $query->where('status', $status))
            ->when($search, fn ($query) => $query->where('content', 'like', "%{$search}%"))
            ->with(['user', 'photo.album'])
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return view('admin.comments.index', compact('comments', 'status', 'search'));
    }

    public function approve(Comment $comment)
    {
        $comment->update(['status' => 'approved']);

        return back()->with('status', 'Komentar disetujui.');
    }

    public function reject(Comment $comment)
    {
        $comment->update(['status' => 'rejected']);

        return back()->with('status', 'Komentar ditolak.');
    }

    public function destroy(Comment $comment)
    {
        $comment->delete();

        return back()->with('status', 'Komentar berhasil dihapus.');
    }
}
