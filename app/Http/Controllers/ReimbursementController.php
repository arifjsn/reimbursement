<?php

namespace App\Http\Controllers;

use App\Models\Reimbursement;
use App\Models\ReimbursementDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReimbursementController extends Controller
{
    /**
     * Display a listing of reimbursements.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $reimbursements = Reimbursement::all();
        return view('reimbursement.form', compact('reimbursements'));
    }

    /**
     * Store a newly created reimbursement in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'proof' => 'nullable|file|mimes:jpeg,png,jpg|max:2048',
            'expense_date' => 'required|array',
            'expense_date.*' => 'required|date',
            'expense_description' => 'required|array',
            'expense_description.*' => 'required|string',
            'expense_amount' => 'required|array',
            'expense_amount.*' => 'required|integer|min:0',
        ]);

        // Upload proof file if exists (image only)
        $proofPath = null;
        if ($request->hasFile('proof')) {
            $proofPath = $request->file('proof')->store('proofs', 'public');
        }

        // Create reimbursement
        $reimbursement = Reimbursement::create([
            'user_id' => Auth::id(),
            'proof' => $proofPath,
            'status' => 'requested',
        ]);

        // Simpan detail pengeluaran
        foreach ($request->expense_date as $i => $date) {
            ReimbursementDetail::create([
                'reimbursement_id' => $reimbursement->id,
                'date' => $date,
                'description' => $request->expense_description[$i],
                'money' => $request->expense_amount[$i],
            ]);
        }

        return redirect()->route('reimbursement.index')->with('success', 'Reimbursement submitted successfully.');
    }
}
