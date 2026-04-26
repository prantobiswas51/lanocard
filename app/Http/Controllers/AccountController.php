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

        // new mail template
        $html = '
        <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%" style="background-color: #f3f4f6;">
    <tr>
        <td align="center" style="padding: 40px 20px;">
            <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="600"
                style="background-color: #ffffff; border-radius: 16px; box-shadow: 0 4px 12px rgba(0,0,0,0.08); overflow: hidden;">

                <!-- Header Image -->
                <tr>
                    <td>
                        <img src="https://i.postimg.cc/1Xv8rYj6/welcome.png" width="600"
                            style="display: block; width: 100%; height: 250px; object-fit: cover;" alt="Welcome to Lanocard">
                    </td>
                </tr>

                <!-- Body -->
                <tr>
                    <td style="padding: 36px 32px;">
                        <h2 style="margin: 0 0 12px; font-size: 20px; font-weight: 600; color: #1f2937;">
                            Welcome to Lanocard 🎉
                        </h2>
                        <p style="margin: 0 0 8px; font-size: 14px; color: #6b7280; line-height: 1.6;">
                            Hello <strong style="color: #111827;">' . e($user->name) . '</strong>,
                        </p>
                        <p style="margin: 0; font-size: 14px; color: #6b7280; line-height: 1.6;">
                            Thank you for creating an account with <strong style="color: #111827;">Lanocard</strong>.
                            Before you can start creating and using virtual cards, please confirm your email address.
                        </p>

                        <!-- Account Details Box -->
                        <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%"
                            style="margin-top: 24px; border: 1px solid #e5e7eb; border-radius: 12px; background-color: #f9fafb;">
                            <tr>
                                <td style="padding: 20px;">
                                    <p style="margin: 0 0 12px; font-size: 14px; font-weight: 600; color: #374151;">
                                        Account Details
                                    </p>
                                    <p style="margin: 0 0 8px; font-size: 14px; color: #6b7280;">
                                        Email Address:
                                        <span style="color: #111827; font-weight: 500;">' . e($user->email) . '</span>
                                    </p>
                                    <p style="margin: 0; font-size: 14px; color: #6b7280;">
                                        Account Status:
                                        <span style="color: #d97706; font-weight: 600;">Pending Activation</span>
                                    </p>
                                </td>
                            </tr>
                        </table>

                        <!-- Activation Button -->
                        <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%"
                            style="margin-top: 32px;">
                            <tr>
                                <td align="center">
                                    <a href="' . e($verifyUrl) . '"
                                        style="display: inline-block; background-color: #2563eb; color: #ffffff;
                                               font-size: 14px; font-weight: 600; padding: 12px 32px;
                                               border-radius: 8px; text-decoration: none;
                                               box-shadow: 0 4px 6px rgba(37,99,235,0.3);">
                                        Activate Your Account
                                    </a>
                                </td>
                            </tr>
                        </table>

                        <!-- Fallback Link -->
                        <p style="margin: 24px 0 0; font-size: 12px; color: #9ca3af; line-height: 1.6; word-break: break-all;">
                            If the button above does not work, copy and paste this link into your browser:<br>
                            <a href="' . e($verifyUrl) . '" style="color: #2563eb; text-decoration: none;">
                                ' . e($verifyUrl) . '
                            </a>
                        </p>

                        <!-- Security Notice -->
                        <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%"
                            style="margin-top: 24px;">
                            <tr>
                                <td style="background-color: #eff6ff; border: 1px solid #bfdbfe;
                                           border-radius: 8px; padding: 14px 16px;">
                                    <p style="margin: 0; font-size: 12px; color: #1d4ed8; line-height: 1.6;">
                                        For security reasons, this activation link may expire. If you did not create this account,
                                        please ignore this email or contact our support team.
                                    </p>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>

                <!-- Footer -->
                <tr>
                    <td style="background-color: #f9fafb; border-top: 1px solid #e5e7eb; padding: 28px 24px; text-align: center;">
                        <h3 style="margin: 0; font-size: 16px; font-weight: 600; color: #1f2937;">LanoCard</h3>
                        <p style="margin: 4px 0 0; font-size: 13px; color: #9ca3af;">Safer Virtual Cards Worldwide</p>
                        <div style="margin-top: 14px; font-size: 13px; color: #6b7280; line-height: 1.8;">
                            <p style="margin: 0;">275 New North Road, Islington<br>N1 7AA, London, United Kingdom</p>
                            <p style="margin: 4px 0 0;">
                                ✉️ <a href="mailto:hi@lanocard.com" style="color: #2563eb; text-decoration: none;">hi@lanocard.com</a>
                            </p>
                            <p style="margin: 4px 0 0;">
                                🌐 <a href="https://lanocard.com" style="color: #2563eb; text-decoration: none;">lanocard.com</a>
                            </p>
                        </div>
                        <div style="margin-top: 14px; font-size: 12px; color: #9ca3af;">
                            <a href="https://lanocard.com/privacy" style="color: #9ca3af; text-decoration: none; margin-right: 8px;">Privacy Policy</a>
                            <span>|</span>
                            <a href="https://lanocard.com/terms" style="color: #9ca3af; text-decoration: none; margin-left: 8px;">Terms</a>
                        </div>
                        <p style="margin: 16px 0 0; font-size: 11px; color: #d1d5db;">
                            © ' . date("Y") . ' Lanocard. All rights reserved.
                        </p>
                    </td>
                </tr>

            </table>
        </td>
    </tr>
</table>
        ';

        sendCustomMail($user->pending_email, 'Verify Your New Email - Lanocard', $html);
    }
}
