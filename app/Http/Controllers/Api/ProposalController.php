<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Proposal;

class ProposalController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $query = Proposal::with(['user', 'division']);

        if ($user->hasRole('Finance')) {
            $query->where('user_id', $user->id)
                  ->where('division_id', $user->division_id);
        } else if ($user->hasRole('Manager')) {
            $query->where('division_id', $user->division_id);
        }

        $proposals = $query->latest()->get();

        return response()->json([
            'success' => true,
            'data' => $proposals
        ], 200);
    }


    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
        ]);

        $data['user_id'] = $request->user()->id;
        $data['division_id'] = $request->user()->division_id;

        $proposal = Proposal::create($data);

        return response()->json([
            'success' => true,
            'message' => 'Proposal berhasil dibuat.',
            'data' => $proposal
        ], 201);

    }


    public function approve(Request $request)
    {
        if (!auth()->user()->hasRole('Manager')) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized',
            ], 403);
        }

        $request->validate([
            'proposal_id' => 'required|exists:proposals,id',
        ]);

        $proposal = Proposal::findOrFail($request->input('proposal_id'));

        $proposal->update(['status' => 'approved']);

        return response()->json([
            'success' => true,
            'message' => 'Proposal berhasil disetujui.',
            'data' => $proposal
        ], 200);

    }
}
