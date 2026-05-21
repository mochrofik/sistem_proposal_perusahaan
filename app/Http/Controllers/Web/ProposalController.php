<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Proposal;
use App\Http\Requests\ProposalRequest;

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

        return view('pages.proposal.index', compact('proposals'));
    }

    public function create()
    {
        return view('pages.proposal.create');
    }

    public function store(ProposalRequest $request)
    {
        $data = $request->validated();
        $data['user_id'] = $request->user()->id;
        $data['division_id'] = $request->user()->division_id;
        
        $proposal = Proposal::create($data);

        return redirect()->route('web.proposal')->with('success', 'Proposal berhasil dibuat.');
    }

    public function approve(Request $request, Proposal $proposal)
    {
        if (!auth()->user()->hasRole('Manager')) {
            abort(403, 'Unauthorized');
        }

        $proposal->update(['status' => 'approved']);

        return back()->with('success', 'Proposal berhasil disetujui.');
    }
}
