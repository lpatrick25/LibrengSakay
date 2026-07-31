<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthController extends Controller
{
    /**
     * Show the login form (guest only).
     */
    public function showLoginForm(): View|RedirectResponse
    {
        if (Auth::check()) {
            return redirect()->intended(route('admin.applicants.index'));
        }

        return view('auth.login');
    }

    /**
     * Handle AJAX login attempt.
     */
    public function login(LoginRequest $request): JsonResponse
    {
        $credentials = $request->only('email', 'password');
        $remember    = $request->boolean('remember');

        if (! Auth::attempt($credentials, $remember)) {
            // Generic message – do not reveal whether email exists
            return response()->json([
                'success' => false,
                'message' => 'Invalid email or password.',
            ], 401);
        }

        // Prevent session fixation
        $request->session()->regenerate();

        return response()->json([
            'success'  => true,
            'message'  => 'Login successful.',
            'redirect' => redirect()->intended(route('admin.applicants.index'))->getTargetUrl(),
        ]);
    }

    /**
     * Log the user out and invalidate the session.
     */
    public function logout(Request $request): RedirectResponse|JsonResponse
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        if ($request->expectsJson() || $request->ajax()) {
            return response()->json([
                'success'  => true,
                'message'  => 'You have been logged out successfully.',
                'redirect' => route('login'),
            ]);
        }

        return redirect()->route('login')
            ->with('status', 'You have been logged out successfully.');
    }
}
