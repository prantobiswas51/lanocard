<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\View\View;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\URL;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\Auth\LoginRequest;

class AuthenticatedSessionController extends Controller
{

    public function create(): View
    {
        return view('auth.login');
    }

    public function store(LoginRequest $request): RedirectResponse
    {

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return back()->withErrors([
                'email' => 'User not found, please create an account!',
            ]);
        }

        if (!$user || is_null($user->email_verified_at)) {

            // Generate token if not exists
            if (!$user->email_verification_token) {
                $user->update([
                    'email_verification_token' => Str::random(64),
                ]);
            }

            // Secure signed verification URL (Laravel default way)
            $verifyUrl = URL::temporarySignedRoute(
                'verify',
                Carbon::now()->addHours(24),
                [
                    'token' => $user->email_verification_token,
                    'email' => $user->email,
                ]
            );


            // new mail template

            $html = '
<table role="presentation" width="100%" style="background:#f3f4f6;">
<tr>
<td align="center" style="padding:30px 15px;">

<table width="600" style="background:#ffffff;border-radius:16px;overflow:hidden;box-shadow:0 4px 10px rgba(0,0,0,0.05);font-family:Arial,sans-serif;">

    <!-- Header Image -->
    <tr>
        <td>
            <img src="https://i.postimg.cc/1Xv8rYj6/welcome.png" 
                 style="width:100%;height:250px;object-fit:cover;display:block;">
        </td>
    </tr>

    <!-- Content -->
    <tr>
        <td style="padding:30px;">

            <h2 style="color:#1f2937;margin:0 0 10px 0;">
                Welcome to Lanocard 🎉
            </h2>

            <p style="color:#4b5563;font-size:14px;">
                Hello <strong>' . e($user->name) . '</strong>,
            </p>

            <p style="color:#4b5563;font-size:14px;line-height:1.6;">
                Thank you for creating an account with <strong>Lanocard</strong>.<br>
                Before you can start creating and using virtual cards, please confirm your email address.
            </p>

            <!-- Account Info -->
            <table width="100%" style="margin-top:20px;background:#f9fafb;border:1px solid #e5e7eb;border-radius:10px;padding:15px;">
                <tr>
                    <td style="padding:10px;">
                        <strong style="color:#374151;">Account Details</strong>

                        <p style="font-size:14px;color:#6b7280;margin-top:10px;">
                            Email Address:
                            <strong style="color:#111827;">' . e($user->email) . '</strong>
                        </p>

                        <p style="font-size:14px;color:#6b7280;">
                            Account Status:
                            <strong style="color:#d97706;">Pending Activation</strong>
                        </p>
                    </td>
                </tr>
            </table>

            <!-- Button -->
            <div style="text-align:center;margin:30px 0;">
                <a href="' . e($verifyUrl) . '" 
                   style="background:#2563eb;color:#ffffff;text-decoration:none;
                          padding:14px 30px;border-radius:8px;font-size:14px;font-weight:bold;display:inline-block;">
                    Activate Your Account
                </a>
            </div>

            <!-- Backup Link -->
            <p style="font-size:12px;color:#6b7280;word-break:break-all;">
                If the button above does not work, copy and paste this link:<br>
                <span style="color:#2563eb;">' . e($verifyUrl) . '</span>
            </p>

            <!-- Security Notice -->
            <div style="margin-top:20px;background:#eff6ff;border:1px solid #bfdbfe;border-radius:8px;padding:15px;">
                <p style="font-size:12px;color:#1d4ed8;margin:0;">
                    For security reasons, this activation link may expire. If you did not create this account,
                    please ignore this email or contact our support team.
                </p>
            </div>

        </td>
    </tr>

    <!-- Footer -->
    <tr>
        <td style="background:#f9fafb;border-top:1px solid #e5e7eb;text-align:center;padding:25px;">

            <h3 style="margin:0;color:#111827;">LanoCard</h3>

            <p style="font-size:13px;color:#6b7280;margin-top:5px;">
                Safer Virtual Cards Worldwide
            </p>

            <p style="font-size:13px;color:#4b5563;margin-top:15px;">
                275 New North Road, Islington<br>
                N1 7AA, London, United Kingdom
            </p>

            <p style="font-size:13px;color:#4b5563;">
                ✉️ hi@lanocard.com<br>
                🌐 lanocard.com
            </p>

            <p style="font-size:11px;color:#9ca3af;margin-top:15px;">
                © ' . date('Y') . ' Lanocard. All rights reserved.
            </p>

        </td>
    </tr>

</table>

</td>
</tr>
</table>
';

            // Send mail 
            sendCustomMail(to: $user->email, subject: 'Verify Your Email - Lanocard', htmlContent: $html);

            return back()->withErrors([
                'email' => 'Please verify your email before login. Check your Inbox or Spam for the verification link.',
            ]);
        }

        $request->authenticate();
        $request->session()->regenerate();
        return redirect()->intended(route('dashboard', absolute: false));
    }

    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
