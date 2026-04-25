<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VerifyEmailController extends Controller
{
    public function verify(Request $request)
    {
        if (! $request->hasValidSignature()) {
            return redirect()->route('login')->withErrors([
                'email' => 'Verification link is invalid or expired. Please request a new verification email.',
            ]);
        }

        $email = $request->query('email');
        $token = $request->query('token');

        // Find the user
        $user = User::where('email', $email)
            ->where('email_verification_token', $token)
            ->first();

        if (!$user) {
            return redirect()->route('login')->withErrors([
                'email' => 'Invalid verification link.',
            ]);
        }

        // If already verified
        if ($user->email_verified_at) {
            return redirect()->route('login')->with('success', 'Your email is already verified.');
        }

        // Mark verified
        $user->email_verified_at = now();
        $user->email_verification_token = null; // Optional: remove token so link can't be reused
        $user->save();

        return redirect()->route('login')->with('success', 'Email verified successfully! You can now login.');
    }

    public function verifyPendingEmail(Request $request)
    {
        if (! $request->hasValidSignature()) {
            return redirect()->route('login')->withErrors([
                'email' => 'Email change link is invalid or expired. Please try changing your email again.',
            ]);
        }

        $pendingEmail = $request->query('email');
        $token = $request->query('token');

        $user = User::where('pending_email', $pendingEmail)
            ->where('pending_email_verification_token', $token)
            ->first();

        if (! $user) {
            return redirect()->route('login')->withErrors([
                'email' => 'Invalid email confirmation link.',
            ]);
        }

        $emailTaken = User::where('email', $pendingEmail)
            ->where('id', '!=', $user->id)
            ->exists();

        if ($emailTaken) {
            return redirect()->route('login')->withErrors([
                'email' => 'This email is already in use by another account. Please choose another one from settings.',
            ]);
        }

        $user->email = $pendingEmail;
        $user->email_verified_at = now();
        $user->pending_email = null;
        $user->pending_email_verification_token = null;
        $user->pending_email_verification_sent_at = null;
        $user->save();

        return redirect()->route('login')->with('status', 'Your new email has been verified and activated successfully.');
    }
}
