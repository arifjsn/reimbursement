<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Reimbursement;
use App\Models\Log;
use Exception;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ReimbursementController extends Controller
{
    /**
     * Display a listing of reimbursements.
     *
     * @return View
     */
    public function index(Request $request): View
    {
        $query = Reimbursement::with(['user', 'details']);
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        $reimbursements = $query->get();

        return view('admin.reimbursement.index', compact('reimbursements'));
    }

    /**
     * Show the detail of a reimbursement.
     *
     * @param int $id
     * @return \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
     */
    public function detail($id)
    {
        $reimbursement = Reimbursement::with(['user', 'details'])->findOrFail($id);

        // Jika request dari modal (AJAX), kembalikan partial view
        if (request()->has('modal')) {
            return view('admin.reimbursement.detail-modal', compact('reimbursement'));
        }

        // Jika bukan dari modal, bisa diarahkan ke halaman detail biasa (opsional)
        return view('admin.reimbursement.detail', compact('reimbursement'));
    }

    /**
     * Accept a reimbursement (set status to claimed).
     *
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function accept($id)
    {
        $reimbursement = Reimbursement::with('user')->findOrFail($id);
        $reimbursement->status = 'claimed';
        $reimbursement->save();

        // Log dengan username user
        Log::create([
            'user_id' => Auth::id(),
            'description' => "Accepted reimbursement for user: " . ($reimbursement->user->name ?? '-')
        ]);

        return redirect()
            ->route('admin.reimbursement.detail', $id)
            ->with('success', 'Reimbursement accepted successfully.');
    }

    /**
     * Reject a reimbursement (set status to rejected).
     *
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function reject($id)
    {
        $reimbursement = Reimbursement::with('user')->findOrFail($id);
        $reimbursement->status = 'rejected';
        $reimbursement->save();

        // Log dengan username user
        Log::create([
            'user_id' => Auth::id(),
            'description' => "Rejected reimbursement for user: " . ($reimbursement->user->name ?? '-')
        ]);

        return redirect()
            ->route('admin.reimbursement.detail', $id)
            ->with('success', 'Reimbursement rejected successfully.');
    }
}
