<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ClaimGaransi;
use App\Models\Log;
use Exception;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class LogController extends Controller
{
    public function index(Request $request): View
    {
        $log = Log::latest()
            ->when($request->pencarian, function ($query, $pencarian) {
                return $query->whereLike(['description'], $pencarian);
            })
            ->when($request->tgl_awal, function ($query, $tglAwal) {
                return $query->where('created_at', '>=', $tglAwal);
            })
            ->when($request->tgl_akhir, function ($query, $tglAkhir) {
                return $query->where('created_at', '<=', $tglAkhir);
            })
            ->paginate(10);

        return view('admin.log.index', [
            'log' => $log
        ]);
    }
}
