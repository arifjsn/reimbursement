<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class ProfileController extends Controller
{
    public function index()
    {
        return view('profile.index', [
            'user' => Auth::user()
        ]);
    }

    public function update(ProfileRequest $request): RedirectResponse
    {
        DB::beginTransaction();
        try {
            $user = Auth::user();

            $updateData = [
                'name' => $request->name,
                'username' => $request->username,
            ];

            if ($request->filled('password')) {
                $updateData['password'] = Hash::make($request->password);
            }

            $user->fill($updateData);
            $user->save();

            DB::commit();
            return redirect()->back()->with('success', 'Your profile has been updated.');
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Profile update failed: ' . $e->getMessage());
            return redirect()->back()->with('error', 'An error occurred while updating your profile.');
        }
    }
}
