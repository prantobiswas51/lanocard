<?php

namespace App\Jobs;

use App\Models\Deposit;
use App\Models\Notification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class DepositConfirmedJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public Deposit $deposit;
    public string $user_email;
    public float $usdAmount;

    public function __construct(Deposit $deposit, string $user_email, float $usdAmount)
    {
        $this->deposit = $deposit;
        $this->user_email = $user_email;
        $this->usdAmount = $usdAmount;
    }

    public function handle(): void
    {
        $user = $this->deposit->user;

        if (!$user) {
            return;
        }

        $html = '
<table role="presentation" width="100%" style="background:#f3f4f6;">
<tr>
<td align="center" style="padding:30px 15px;">

<table width="600" style="background:#ffffff;border-radius:12px;overflow:hidden;box-shadow:0 4px 10px rgba(0,0,0,0.05);font-family:Arial,sans-serif;">

    <!-- Header -->
    <tr>
        <td style="background:#16a34a;text-align:center;padding:25px;">
            <h1 style="color:#ffffff;margin:0;font-size:22px;">Lanocard</h1>
            <p style="color:#dcfce7;font-size:13px;margin-top:5px;">Secure Virtual Card Service</p>
        </td>
    </tr>

    <!-- Content -->
    <tr>
        <td style="padding:30px;">

            <h2 style="color:#1f2937;margin-bottom:10px;">
                Deposit Successful 💰
            </h2>

            <p style="color:#4b5563;font-size:14px;line-height:1.6;">
                Hello <strong>' . e($user->name) . '</strong>,<br>
                your deposit has been successfully processed and added to your account balance.
            </p>

            <!-- Deposit Details -->
            <table width="100%" style="margin-top:20px;background:#f9fafb;border:1px solid #e5e7eb;border-radius:10px;padding:15px;">
                <tr>
                    <td style="padding:10px;">

                        <strong style="color:#374151;">Transaction Details</strong>

                        <p style="font-size:14px;color:#6b7280;margin-top:10px;">
                            Amount Added:
                            <strong style="color:#16a34a;">$' . number_format($this->usdAmount, 2) . '</strong>
                        </p>

                        <p style="font-size:14px;color:#6b7280;">
                            Current Balance:
                            <strong style="color:#2563eb;">$' . number_format($user->balance, 2) . '</strong>
                        </p>

                        <p style="font-size:14px;color:#6b7280;">
                            Transaction ID:
                            <strong style="color:#111827;">' . $this->deposit->tx_id . '</strong>
                        </p>

                        <p style="font-size:14px;color:#6b7280;">
                            Date:
                            <strong style="color:#111827;">' . now()->format("F j, Y, g:i A") . '</strong>
                        </p>

                        <p style="font-size:14px;color:#6b7280;">
                            Status:
                            <strong style="color:#16a34a;">Completed</strong>
                        </p>

                    </td>
                </tr>
            </table>

            <!-- Info -->
            <div style="margin-top:20px;background:#ecfdf5;border:1px solid #bbf7d0;border-radius:8px;padding:15px;">
                <p style="font-size:13px;color:#166534;margin:0;">
                    You can now use your balance to create or top-up your virtual cards instantly.
                </p>
            </div>

            <!-- Button -->
            <div style="text-align:center;margin-top:30px;">
                <a href="https://tanocard.com/dashboard"
                   style="background:#16a34a;color:#ffffff;text-decoration:none;
                          padding:14px 28px;border-radius:8px;font-size:14px;font-weight:bold;display:inline-block;">
                    View Dashboard
                </a>
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
                © ' . date("Y") . ' Lanocard. All rights reserved.
            </p>

        </td>
    </tr>

</table>

</td>
</tr>
</table>
';

        sendCustomMail($user->email, 'Lanocard - Deposit Successful', $html);

        Notification::create([
            'user_id' => $user->id,
            'title' => 'Deposit Successful',
            'message' => 'Your deposit of $' . number_format($this->usdAmount, 2) . ' has been processed successfully and added to your wallet.',
        ]);
    }
}
