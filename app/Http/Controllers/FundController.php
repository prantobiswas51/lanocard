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

        

        $html = '
            <div style="font-family: Arial, sans-serif; background-color: #f8f9fa; padding: 20px;">
                <div style="max-width: 600px; margin: 0 auto; background-color: #ffffff; border-radius: 10px;
                            box-shadow: 0 2px 8px rgba(0,0,0,0.05); overflow: hidden;">
                    <div style="background-color: #f0ad4e; color: #ffffff; padding: 20px; text-align: center;">
                        <h1 style="margin: 0; font-size: 22px;">Manual Payment Request Received</h1>
                    </div>
                    <div style="padding: 30px; text-align: center;">
                        <h2 style="color: #333333;">We\'ve Received Your Payment Request</h2>
                        <p style="color: #555555; font-size: 16px; line-height: 1.6;">
                            Thank you for submitting your manual payment request. Our finance team has received your request 
                            and it is currently <strong>pending verification</strong>.
                        </p>
                        <div style="margin: 25px auto; background-color: #f1f3f5; border-radius: 8px;
                                    padding: 15px; max-width: 400px; text-align: left; color: #222;">
                            <p><strong>Requested Amount:</strong> $' . number_format($request->amount, 2) . '</p>
                            <p><strong>Status:</strong> Pending Review</p>
                            <p><strong>Date Submitted:</strong> ' . now()->format("F j, Y, g:i A") . '</p>
                        </div>
                        <p style="color: #555555; font-size: 15px; line-height: 1.6;">
                            You will receive another email once our team verifies and approves your payment. 
                            Please allow some time for processing.
                        </p>
                        <a href="https://lanocard.com/dashboard"
                        style="display: inline-block; background-color: #4a90e2; color: #ffffff;
                                padding: 12px 25px; border-radius: 6px; text-decoration: none;
                                font-weight: bold; margin-top: 15px;">
                            View Payment Status
                        </a>
                    </div>
                    <div style="background-color: #f1f3f5; padding: 15px; text-align: center; font-size: 13px; color: #777;">
                        <p>If you have already made the transfer, please upload proof of payment or contact support.</p>
                        <p>Need help? Email us at 
                            <a href="mailto:support@lanocard.com" style="color: #4a90e2;">support@lanocard.com</a>
                        </p>
                        <p>© ' . date("Y") . ' Lanocard. All rights reserved.</p>
                    </div>
                </div>
            </div>
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
