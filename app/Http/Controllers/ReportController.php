<?php

namespace App\Http\Controllers;

use App\Models\Photo;
use App\Support\VisitorIdentity;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function store(Request $request, Photo $photo)
    {
        $identityColumn = auth()->check() ? 'user_id' : 'visitor_id';
        $identity = auth()->check() ? auth()->id() : VisitorIdentity::get($request);

        if ($photo->reports()->where($identityColumn, $identity)->exists()) {
            return back()->with('error', 'Anda sudah melaporkan foto ini.');
        }

        $data = $request->validate([
            'reason' => ['required', 'in:inappropriate,blurry,wrong_album,copyright,other'],
            'description' => ['nullable', 'string', 'max:1000'],
        ], [
            'reason.required' => 'Alasan laporan wajib dipilih.',
            'description.max' => 'Deskripsi maksimal 1000 karakter.',
        ]);

        $photo->reports()->create([
            'user_id' => auth()->id(),
            'visitor_id' => auth()->guest() ? VisitorIdentity::get($request) : null,
            'reason' => $data['reason'],
            'description' => $data['description'] ?? null,
            'status' => 'pending',
        ]);

        return back()->with('status', 'Laporan berhasil dikirim. Terima kasih atas perhatian Anda.');
    }
}
