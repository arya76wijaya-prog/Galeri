<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Report;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $status = trim((string) $request->query('status', '')) ?: null;

        $reports = Report::query()
            ->when($status, fn ($query) => $query->where('status', $status))
            ->with(['user', 'photo.album', 'reviewer'])
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return view('admin.reports.index', compact('reports', 'status'));
    }

    public function show(Report $report)
    {
        $report->load(['user', 'photo.album', 'reviewer']);

        return view('admin.reports.show', compact('report'));
    }

    public function update(Request $request, Report $report)
    {
        $data = $request->validate([
            'status' => ['required', Rule::in(['pending', 'reviewed', 'resolved', 'rejected'])],
            'review_note' => ['nullable', 'string', 'max:1000'],
        ], [
            'status.required' => 'Status laporan wajib dipilih.',
            'status.in' => 'Status laporan tidak valid.',
        ]);

        $report->status = $data['status'];

        if ($data['status'] === 'pending') {
            $report->reviewed_by = null;
            $report->reviewed_at = null;
        } else {
            $report->reviewed_by = auth()->id();
            $report->reviewed_at = now();
        }

        $report->save();

        return redirect()->route('admin.reports.index')->with('status', 'Status laporan berhasil diperbarui.');
    }

    public function destroy(Report $report)
    {
        $report->delete();

        return back()->with('status', 'Laporan berhasil dihapus.');
    }
}
