<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;

class AccountController extends Controller
{
    public function index(Request $request)
    {
        return view('dashboard.settings', [
            'user' => $request->user(),
        ]);
    }

    public function updateProfile(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $request->user()->id],
        ]);

        $user = $request->user();
        $emailChanged = $user->email !== $validated['email'];

        $user->name = $validated['name'];

        if ($emailChanged) {
            $user->pending_email = $validated['email'];
            $user->pending_email_verification_token = Str::random(64);
            $user->pending_email_verification_sent_at = now();
        }

        $user->save();

        if ($emailChanged) {
            $this->sendPendingEmailVerification($user);

            return back()->with('status', 'A confirmation link was sent to your new email. Your current email stays active until you verify the new one.');
        }

        return back()->with('status', 'Account profile updated successfully.');
    }

    public function updatePassword(Request $request)
    {
        $validated = $request->validate([
            'current_password' => ['required', 'current_password'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $request->user()->update([
            'password' => $validated['password'],
        ]);

        return back()->with('status', 'Password changed successfully.');
    }

    public function regenerateApiKey(Request $request)
    {
        $request->user()->update([
            'api_key' => Str::random(32),
        ]);

        return back()->with('status', 'API key regenerated successfully.');
    }

    private function sendPendingEmailVerification(User $user): void
    {
        $verifyUrl = URL::temporarySignedRoute(
            'verify.pending-email',
            Carbon::now()->addHours(24),
            [
                'token' => $user->pending_email_verification_token,
                'email' => $user->pending_email,
            ]
        );

        $html = '
        <table role="presentation" width="100%" style="background:#f3f4f6;padding:24px 0;">
        <tr>
        <td align="center">
        <table role="presentation" width="600" style="max-width:600px;background:#ffffff;border:1px solid #e5e7eb;border-radius:12px;overflow:hidden;font-family:Arial,sans-serif;">
            <tr>
                <td style="padding:28px 24px;border-bottom:1px solid #e5e7eb;background:#f8fafc;">
                    <h2 style="margin:0;color:#111827;font-size:22px;">Confirm Your New Email</h2>
                    <p style="margin:8px 0 0;color:#4b5563;font-size:14px;line-height:1.6;">
                        Hi ' . e($user->name) . ', we received a request to update your account email. Please confirm this new address.
                    </p>
                </td>
            </tr>
            <tr>
                <td style="padding:24px;">
                    <div style="background:#f9fafb;border:1px solid #e5e7eb;border-radius:10px;padding:16px;">
                        <p style="margin:0;color:#6b7280;font-size:13px;">New email</p>
                        <p style="margin:6px 0 0;color:#111827;font-size:14px;"><strong>' . e($user->pending_email) . '</strong></p>
                    </div>

                    <div style="text-align:center;margin:24px 0 18px;">
                        <a href="' . e($verifyUrl) . '" style="display:inline-block;background:#2563eb;color:#ffffff;text-decoration:none;padding:12px 22px;border-radius:8px;font-size:14px;font-weight:700;">
                            Verify Email Address
                        </a>
                    </div>

                    <p style="margin:0;color:#6b7280;font-size:12px;line-height:1.6;word-break:break-all;">
                        If the button does not work, copy and paste this link:<br>' . e($verifyUrl) . '
                    </p>

                    <p style="margin:16px 0 0;color:#6b7280;font-size:12px;line-height:1.6;">
                        This link expires in 24 hours. If you did not request this change, contact support immediately.
                    </p>
                </td>
            </tr>
        </table>
        </td>
        </tr>
        </table>';

        sendCustomMail($user->pending_email, 'Verify Your New Email - Lanocard', $html);
    }
}
