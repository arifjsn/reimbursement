<?php

namespace App\Http\Controllers;

use App\Models\Reimbursement;
use App\Models\ReimbursementDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ReimbursementController extends Controller
{
    /**
     * Display a listing of reimbursements.
     */
    public function index()
    {
        $reimbursements = Reimbursement::where('user_id', Auth::id())
            ->orderByDesc('created_at')
            ->paginate(10); // paging 10 data

        return view('reimbursement.index', compact('reimbursements'));
    }

    /**
     * Show the form for creating a new reimbursement.
     */
    public function create()
    {
        return view('reimbursement.form');
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

        $proofPath = null;
        if ($request->hasFile('proof') && $request->file('proof')->isValid()) {
            // Ensure the 'proof' directory exists
            if (!\Storage::disk('public')->exists('proof')) {
                \Storage::disk('public')->makeDirectory('proof');
            }
            $file = $request->file('proof');
            $filename = time() . '_' . Str::random(16) . '.' . $file->getClientOriginalExtension();
            $file->move(storage_path('app/public/proof'), $filename);
            $proofPath = "storage/proof/$filename";
        }

        $reimbursement = Reimbursement::create([
            'user_id' => Auth::id(),
            'proof' => $proofPath,
            'status' => 'requested',
        ]);

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

    /**
     * Show the form for editing the specified reimbursement.
     */
    public function edit($id)
    {
        $reimbursement = Reimbursement::where('user_id', Auth::id())->findOrFail($id);
        $details = $reimbursement->details()->get();
        return view('reimbursement.edit', compact('reimbursement', 'details'));
    }

    /**
     * Update the specified reimbursement in storage.
     */
    public function update(Request $request, $id)
    {
        $reimbursement = Reimbursement::where('user_id', Auth::id())->findOrFail($id);

        $request->validate([
            'proof' => 'nullable|file|mimes:jpeg,png,jpg|max:2048',
            'expense_date' => 'required|array',
            'expense_date.*' => 'required|date',
            'expense_description' => 'required|array',
            'expense_description.*' => 'required|string',
            'expense_amount' => 'required|array',
            'expense_amount.*' => 'required|integer|min:0',
        ]);

        $proofPath = $reimbursement->proof;
        if ($request->hasFile('proof') && $request->file('proof')->isValid()) {
            // Ensure the 'proof' directory exists
            if (!\Storage::disk('public')->exists('proof')) {
                \Storage::disk('public')->makeDirectory('proof');
            }
            $file = $request->file('proof');
            $filename = time() . '_' . Str::random(16) . '.' . $file->getClientOriginalExtension();
            $file->move(storage_path('app/public/proof'), $filename);
            $proofPath = "storage/proof/$filename";
        }

        $reimbursement->update([
            'proof' => $proofPath,
        ]);

        // Hapus detail lama
        $reimbursement->details()->delete();

        // Simpan detail baru
        foreach ($request->expense_date as $i => $date) {
            ReimbursementDetail::create([
                'reimbursement_id' => $reimbursement->id,
                'date' => $date,
                'description' => $request->expense_description[$i],
                'money' => $request->expense_amount[$i],
            ]);
        }

        return redirect()->route('reimbursement.index')->with('success', 'Reimbursement updated successfully.');
    }

    /**
     * Remove the specified reimbursement from storage.
     */
    public function destroy($id)
    {
        $reimbursement = Reimbursement::where('user_id', Auth::id())->findOrFail($id);

        // Cegah hapus jika status sudah accepted/claimed atau rejected
        if (in_array($reimbursement->status, ['claimed', 'rejected'])) {
            return redirect()
                ->route('reimbursement.index')
                ->with('error', 'Reimbursement that has been ' . $reimbursement->status . ' cannot be deleted.');
        }

        // Hapus file proof jika ada
        if ($reimbursement->proof && file_exists(public_path($reimbursement->proof))) {
            @unlink(public_path($reimbursement->proof));
        }

        $reimbursement->details()->delete();
        $reimbursement->delete();

        return redirect()->route('reimbursement.index')->with('success', 'Reimbursement deleted successfully.');
    }

    /**
     * Display the specified reimbursement detail.
     */
    public function detail($id)
    {
        $reimbursement = Reimbursement::with(['details', 'user'])
            ->where('user_id', Auth::id())
            ->findOrFail($id);

        return view('reimbursement.detail', compact('reimbursement'));
    }
}
