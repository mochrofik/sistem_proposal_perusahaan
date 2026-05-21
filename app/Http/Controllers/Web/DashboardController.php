<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Proposal;
use Illuminate\View\View;

class DashboardController extends Controller
{
    /**
     * GET /dashboard
     *
     * Show the main dashboard page with proposals filtered by visibility rules:
     * - pending  : divisi pengaju & Manager
     * - approved : semua divisi & Finance
     */
    public function index(): View
    {
        /** @var \App\Models\User $user */
        $user = auth()->user()->load('division');

        // Load proposals visible to this user (dengan eager load relasi)
        $proposals = Proposal::with(['user', 'division'])
            ->visibleBy($user)
            ->latest()
            ->get();

        // Summary stats (berdasarkan proposal yang boleh dilihat user ini)
        $stats = [
            'total'    => $proposals->count(),
            'approved' => $proposals->where('status', 'approved')->count(),
            'pending'  => $proposals->where('status', 'pending')->count(),
            'rejected' => $proposals->where('status', 'rejected')->count(),
        ];

        return view('pages.dashboard.index', compact('user', 'proposals', 'stats'));
    }
}

