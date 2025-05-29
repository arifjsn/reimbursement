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
    public function index(): View
    {
        $reimbursements = Reimbursement::all();
        return view('admin.reimbursement.index', compact('reimbursements'));
    }
}
