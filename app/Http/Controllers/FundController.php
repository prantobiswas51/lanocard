<?php

namespace App\Http\Controllers;

use App\Models\Deposit;
use App\Models\Notification;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Symfony\Component\Process\Process;

class FundController extends Controller
{
    public function index()
    {
        $trx_address = Setting::value('main_deposit_address');
        $bkash_rate = Setting::value('bkash_rate');
        $bkash_number = Setting::value('bkash_number');

        $deposits = Deposit::where('user_id', Auth::id())->get();

        return view('dashboard/funding', compact('trx_address', 'bkash_rate', 'bkash_number', 'deposits'));
    }

    public function check_deposit(Request $request)
    {

        $request->validate([
            'tx_id' => 'required|string',
            'user_id' => 'required|integer',
        ]);

        $user = User::find($request->user_id);

        if (!$user) {
            return redirect()->route('fundings')->with('status', 'Invalid user.');
        }

        if (Deposit::where('tx_id', $request->tx_id)->exists()) {
            return redirect()->route('fundings')->with('status', 'This transaction already exists.');
        }

        // dd(123);

        Deposit::create([
            'user_id'   => Auth::id(),
            'tx_id'     => $request->tx_id,
            'currency'  => 'Pending',
            'amount'    => 0,
            'status'    => 'PENDING',
        ]);

        return back()->with('status', 'Transaction submitted. Should take a minute to update. Waiting for confirmation.');
    }




    public function manual_payment(Request $request)
    {

        // dd($request->all());

        $request->validate([
            'payment_method' => 'required|string',
            'amount' => 'required|numeric|min:1',
            'currency' => 'nullable|string',
            'tx_id' => 'required|string',
            'notes' => 'nullable|string',
            'screenshot' => 'required|file|mimes:jpg,jpeg,png,pdf|max:5120', // Max 5MB
        ]);

        Log::channel('dev_error')->error('Manual Payment Request:', $request->all());

        // dd($request->all());

        if ($request->file('screenshot')->getSize() > 3 * 1024 * 1024) {
            return redirect()->route('fundings')->with('status', 'File size exceeds the maximum limit of 3MB.');
        }

        $ss_path = $request->file('screenshot')->store('manual_deposits', 'public');

        $payment_method = "Payoneer";
        $amount = $request->input('amount');
        $final_amount = $amount -1;
        $currency = $request->input('currency');
        $tx_id = $request->input('tx_id');
        $notes = $request->input('notes');

        // Create a new deposit record with 'PENDING' status
        Deposit::create([
            'user_id' => Auth::id(),
            'tx_id' => $tx_id,
            'amount' => $final_amount,
            'currency' => $currency,
            'notes' => $notes,
            'method' => $payment_method,
            'screenshot_path' => $ss_path,
            'type' => 'Manual',
            'status' => 'PENDING',
        ]);


        // New mail template

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
                            Payment Request Received 🕐
                        </h2>
                        <p style="margin: 0; font-size: 14px; color: #6b7280; line-height: 1.6;">
                            Hello <strong style="color: #111827;">' . e(Auth::user()->name) . '</strong>,
                            thank you for submitting your manual payment request. Our finance team has received it
                            and it is currently <strong style="color: #111827;">pending verification</strong>.
                        </p>

                        <!-- Payment Details Box -->
                        <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%"
                            style="margin-top: 24px; border: 1px solid #e5e7eb; border-radius: 12px; background-color: #f9fafb;">
                            <tr>
                                <td style="padding: 20px;">
                                    <p style="margin: 0 0 14px; font-size: 14px; font-weight: 600; color: #374151;">
                                        Payment Details
                                    </p>
                                    <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%">
                                        <tr>
                                            <td style="padding: 6px 0; font-size: 14px; color: #6b7280; border-bottom: 1px solid #e5e7eb;">
                                                Requested Amount
                                            </td>
                                            <td style="padding: 6px 0; font-size: 14px; font-weight: 600; color: #111827;
                                                       text-align: right; border-bottom: 1px solid #e5e7eb;">
                                                $' . number_format($request->amount, 2) . '
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="padding: 6px 0; font-size: 14px; color: #6b7280; border-bottom: 1px solid #e5e7eb;">
                                                Status
                                            </td>
                                            <td style="padding: 6px 0; font-size: 14px; font-weight: 600; color: #d97706;
                                                       text-align: right; border-bottom: 1px solid #e5e7eb;">
                                                Pending Review
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="padding: 10px 0 0; font-size: 14px; color: #6b7280;">
                                                Date Submitted
                                            </td>
                                            <td style="padding: 10px 0 0; font-size: 14px; font-weight: 600; color: #111827;
                                                       text-align: right;">
                                                ' . now()->format("F j, Y, g:i A") . '
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        </table>

                        <!-- Info Notice -->
                        <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%"
                            style="margin-top: 24px;">
                            <tr>
                                <td style="background-color: #fffbeb; border: 1px solid #fde68a;
                                           border-radius: 8px; padding: 14px 16px;">
                                    <p style="margin: 0; font-size: 12px; color: #92400e; line-height: 1.6;">
                                        🕐 You will receive another email once our team verifies and approves your payment.
                                        If you have already made the transfer, please upload proof of payment or contact our support team.
                                    </p>
                                </td>
                            </tr>
                        </table>

                        <!-- CTA Button -->
                        <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%"
                            style="margin-top: 32px;">
                            <tr>
                                <td align="center">
                                    <a href="https://lanocard.com/dashboard"
                                        style="display: inline-block; background-color: #2563eb; color: #ffffff;
                                               font-size: 14px; font-weight: 600; padding: 12px 32px;
                                               border-radius: 8px; text-decoration: none;
                                               box-shadow: 0 4px 6px rgba(37,99,235,0.3);">
                                        View Payment Status
                                    </a>
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

        sendCustomMail(Auth::user()->email, 'Lanocard - Manual Payment Request Received', $html);


        return redirect()->route('fundings')->with('status', '✅ Manual payment submitted. Awaiting admin approval.');
    }

    public function bkash_manual_deposit(Request $request)
    {
        // "payment_method" => "bkash"
        //   "currency" => "USD"
        //   "amount_bdt" => "43436546.00"
        //   "equivalent_usd" => "342020.05"
        //   "deposit_fee" => "1.00"
        //   "amount" => "342019.05"
        //   "amount_bdt_input" => "43436546"
        //   "tx_id" => "ergrt6vb546b5"
        //  "user_id" => "1"

        $request->validate([
            'amount_bdt_input' => 'required|numeric|min:1500',
            'tx_id' => 'required|string',
            'user_id' => 'required|integer',
        ]);

        $amount_bdt = $request->input('amount_bdt_input');
        $tx_id = $request->input('tx_id');

        $user = User::find($request->user_id);

        if (!$user || $user->id !== Auth::id()) {
            return redirect()->route('fundings')->with('status', 'Invalid user.');
        }

        if (Deposit::where('tx_id', $tx_id)->exists()) {
            return redirect()->route('fundings')->with('status', 'This transaction already exists.');
        }

        $bkash_rate = Setting::value('bkash_rate') ?? 125;
        $amount_usd = round($amount_bdt / $bkash_rate, 2);
        $amount_after_fee = $amount_usd - 1; // Deducting a flat fee of $1

        Deposit::create([
            'user_id' => Auth::id(),
            'tx_id' => $tx_id,
            'amount' => $amount_after_fee,
            'currency' => 'USD',
            'bdt_amount' => $amount_bdt,
            'method' => 'Bkash',
            'type' => 'Manual',
            'status' => 'PENDING',
        ]);

        return back()->with('status', 'Transaction submitted. Should take a minute to update. Waiting for confirmation.');
    }
}
