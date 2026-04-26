<?php

namespace App\Http\Controllers\Auth;

use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Password;

class PasswordResetLinkController extends Controller
{
    /**
     * Display the password reset link request view.
     */
    public function create(): View
    {
        return view('auth.forgot-password');
    }

    /**
     * Handle an incoming password reset link request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'email' => ['required', 'email'],
        ]);

        $user = \App\Models\User::where('email', $request->email)->first();

        if (!$user) {
            return back()->withErrors([
                'email' => __('passwords.user'),
            ]);
        }

        // Generate Laravel password reset token
        $token = Password::createToken($user);

        // Secure reset URL (Laravel default)
        $resetUrl = URL::route('password.reset', [
            'token' => $token,
            'email' => $user->email,
        ]);

        // Email HTML new template
        $html = '
        <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%" style="background-color: #f3f4f6;">
    <tr>
        <td align="center" style="padding: 40px 20px;">
            <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="600"
                style="background-color: #ffffff; border-radius: 16px; box-shadow: 0 4px 12px rgba(0,0,0,0.08); overflow: hidden;">

                <!-- Header -->
                <tr>
                    <td style="background: linear-gradient(to right, #2563eb, #4f46e5); text-align: center; padding: 28px 20px;">
                        <h1 style="margin: 0; font-size: 24px; font-weight: 700; color: #ffffff;">Lanocard</h1>
                        <p style="margin: 6px 0 0; font-size: 13px; color: #bfdbfe;">Secure Virtual Card Service</p>
                    </td>
                </tr>

                <!-- Body -->
                <tr>
                    <td style="padding: 36px 32px;">
                        <h2 style="margin: 0 0 12px; font-size: 20px; font-weight: 600; color: #1f2937;">
                            Password Reset Request 🔐
                        </h2>
                        <p style="margin: 0 0 8px; font-size: 14px; color: #6b7280; line-height: 1.6;">
                            Hello <strong style="color: #111827;">' . e($user->name) . '</strong>,
                        </p>
                        <p style="margin: 0; font-size: 14px; color: #6b7280; line-height: 1.6;">
                            We received a request to reset the password for your Lanocard account.
                            Click the button below to proceed. If you did not make this request, you can safely ignore this email.
                        </p>

                        <!-- CTA Button -->
                        <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%"
                            style="margin-top: 32px;">
                            <tr>
                                <td align="center">
                                    <a href="' . e($resetUrl) . '"
                                        style="display: inline-block; background-color: #2563eb; color: #ffffff;
                                               font-size: 14px; font-weight: 600; padding: 12px 32px;
                                               border-radius: 8px; text-decoration: none;
                                               box-shadow: 0 4px 6px rgba(37,99,235,0.3);">
                                        Reset Password
                                    </a>
                                </td>
                            </tr>
                        </table>

                        <!-- Fallback Link -->
                        <p style="margin: 24px 0 0; font-size: 12px; color: #9ca3af; line-height: 1.6; word-break: break-all;">
                            If the button above does not work, copy and paste this link into your browser:<br>
                            <a href="' . e($resetUrl) . '" style="color: #2563eb; text-decoration: none;">
                                ' . e($resetUrl) . '
                            </a>
                        </p>

                        <!-- Security Notice -->
                        <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%"
                            style="margin-top: 24px;">
                            <tr>
                                <td style="background-color: #fef2f2; border: 1px solid #fecaca;
                                           border-radius: 8px; padding: 14px 16px;">
                                    <p style="margin: 0; font-size: 12px; color: #991b1b; line-height: 1.6;">
                                        ⚠️ This link will expire in <strong>60 minutes</strong>. If you did not request a password reset,
                                        please ignore this email or contact our support team immediately if you suspect unauthorized access.
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
</table>';

        // Send custom mail
        sendCustomMail(
            to: $user->email,
            subject: 'Reset Your Password',
            htmlContent: $html
        );

        return back()->with('status', __('passwords.sent'));
    }
}
