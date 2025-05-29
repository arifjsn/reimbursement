<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Log;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /**
     * Show the login form.
     *
     * @return \Illuminate\View\View
     */
    public function login()
    {
        return view('auth.login');
    }

    /**
     * Handle user login action.
     *
     * Validates the request, checks if the user exists, attempts authentication,
     * and redirects based on user status.
     *
     * Allows login using either email or username.
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function loginAction(Request $request)
    {
        $request->validate([
            'email' => 'required', // can be email or username
            'password' => 'required',
        ]);
        try {
            $login = $request->email;
            $password = $request->password;

            // Determine if input is email or username
            $fieldType = filter_var($login, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

            // Check if user exists
            $userExist = User::where($fieldType, $login)->exists();
            if (!$userExist) {
                return redirect()->back()->with('error', ucfirst($fieldType) . ' has not been registered.');
            }

            $credentials = [
                $fieldType => $login,
                'password' => $password,
            ];

            if (Auth::attempt($credentials)) {
                $user = Auth::user();

                // Log the login action with username
                Log::create([
                    'user_id' => $user->id,
                    'description' => $user->username . ' logged in',
                ]);

                return redirect()->route('dashboard');
            } else {
                return redirect()->back()->with('error', 'Login Failed. Please check your Email/Username & Password.');
            }
        } catch (\Throwable $th) {
            session()->flash('error', $th->getMessage());
            return redirect()->back();
        }
    }

    /**
     * Log out the current user and redirect to login page.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logout()
    {
        try {
            Auth::guard('web')->logout();

            return redirect()->route('login');
        } catch (\Throwable $th) {
        }
    }

    /**
     * Show the dashboard view.
     *
     * @return \Illuminate\View\View
     */
    public function dashboard()
    {
        return view('dashboard');
    }
}
