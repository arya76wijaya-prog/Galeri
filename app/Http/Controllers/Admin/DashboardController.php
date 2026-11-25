<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Album;
use App\Models\Comment;
use App\Models\Photo;
use App\Models\Report;
use App\Models\SchoolLocation;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'albums' => Album::count(),
            'photos' => Photo::count(),
            'users' => User::count(),
            'locations' => SchoolLocation::count(),
            'pending_comments' => Comment::pending()->count(),
            'pending_reports' => Report::pending()->count(),
        ];

        $recentAlbums = Album::with('creator')->latest()->take(5)->get();
        $recentComments = Comment::with(['user', 'photo'])->latest()->take(5)->get();
        $pendingReports = Report::with(['user', 'photo'])->pending()->latest()->take(5)->get();

        return view('admin.dashboard', compact('stats', 'recentAlbums', 'recentComments', 'pendingReports'));
    }
}
