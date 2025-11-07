<?php

namespace App\Http\Controllers;

use App\Models\Proposal;
use App\Models\Customer;
use Illuminate\Http\Request;

class ProposalController extends Controller
{
    public function index()
    {
        $proposals = Proposal::with('customer')->latest()->paginate(10);
        return view('proposals.index', compact('proposals'));
    }

    public function create()
    {
        $customers = Customer::where('status', 'active')->get();
        return view('proposals.create', compact('customers'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'amount' => 'required|numeric|min:0',
            'status' => 'required|in:draft,sent,accepted,rejected',
            'valid_until' => 'nullable|date',
        ]);

        Proposal::create($validated);

        return redirect()->route('proposals.index')
            ->with('success', 'Proposal created successfully.');
    }

    public function show(Proposal $proposal)
    {
        return view('proposals.show', compact('proposal'));
    }

    public function edit(Proposal $proposal)
    {
        $customers = Customer::where('status', 'active')->get();
        return view('proposals.edit', compact('proposal', 'customers'));
    }

    public function update(Request $request, Proposal $proposal)
    {
        $validated = $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'amount' => 'required|numeric|min:0',
            'status' => 'required|in:draft,sent,accepted,rejected',
            'valid_until' => 'nullable|date',
        ]);

        $proposal->update($validated);

        return redirect()->route('proposals.index')
            ->with('success', 'Proposal updated successfully.');
    }

    public function destroy(Proposal $proposal)
    {
        $proposal->delete();

        return redirect()->route('proposals.index')
            ->with('success', 'Proposal deleted successfully.');
    }

    public function updateStatus(Request $request, Proposal $proposal)
    {
        $proposal->update(['status' => $request->status]);
        
        return redirect()->route('proposals.index')
            ->with('success', 'Proposal status updated successfully.');
    }
}