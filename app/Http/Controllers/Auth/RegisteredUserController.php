<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\View\View;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\URL;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\RegisterRequest;
use BcMath\Number;

class RegisteredUserController extends Controller
{

    public function create(): View
    {
        return view('auth.register');
    }

    public function store(RegisterRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        // Create user
        $user = new User();
        $user->name = $validated['name'];
        $user->email = $validated['email'];
        $user->phone = trim($validated['phoneCode'] . ' ' . $validated['phone']);
        $user->country = $validated['country'];
        $user->password = Hash::make($validated['password']);
        $user->email_verification_token = Str::random(40);

        // Generate unique 16-digit api_num
        do {
            $api_num = random_int(1000000000000000, 9999999999999999);
        } while (User::where('api_num', $api_num)->exists());

        $user->api_num = $api_num;

        $user->api_key = Str::random(32); // Generate random API key
        $user->save();

        // Generate verification link
        $verifyUrl = URL::temporarySignedRoute(
            'verify',
            Carbon::now()->addHours(24),
            [
                'token' => $user->email_verification_token,
                'email' => $user->email,
            ]
        );

        // new mail template
        // Email content
        $html =
            '
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

        sendCustomMail($validated['email'], 'Verify Your Email - Lanocard', $html);

        return redirect()->route('check_mail')->with('success', 'Please check your email to verify your account.');
    }
}
