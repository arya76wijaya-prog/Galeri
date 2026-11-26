<?php

namespace App\Http\Controllers;

use App\Models\Photo;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function store(Request $request, Photo $photo)
    {
        $userId = auth()->id();
        $sessionId = $request->session()->getId();

        $exists = $photo->reports()
            ->where(function ($q) use ($userId, $sessionId) {
                if ($userId) {
                    $q->where('user_id', $userId);
                } else {
                    $q->where('session_id', $sessionId);
                }
            })
            ->exists();

        if ($exists) {
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
            'user_id' => $userId,
            'session_id' => $sessionId,
            'reason' => $data['reason'],
            'description' => $data['description'] ?? null,
            'status' => 'pending',
        ]);

        return back()->with('status', 'Laporan berhasil dikirim. Terima kasih atas perhatian Anda.');
    }
}
