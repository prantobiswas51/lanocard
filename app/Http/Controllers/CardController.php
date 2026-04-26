<?php

namespace App\Http\Controllers;

use App\Models\Bin;
use App\Models\Card;
use App\Models\Notification;
use App\Models\Setting;
use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class CardController extends Controller
{
    protected string $baseUrl = 'http://api.vcc.center';

    protected string $userSerial;

    protected string $secretKey;

    public function __construct()
    {
        $this->userSerial = Setting::value('vcc_user_serial') ?? '';
        $this->secretKey = Setting::value('vcc_secret_key') ?? '';
    }

    public function index()
    {
        $mycards = Card::where('user_id', Auth::id())->get();

        return view('dashboard/cards', compact('mycards'));
    }

    protected function sign(array $params): string
    {
        $filtered = array_filter($params, fn ($value) => ! is_null($value) && $value !== '');
        ksort($filtered);
        $query = urldecode(http_build_query($filtered));
        $query = str_replace('+', '%20', $query);
        $stringToSign = $query.'&key='.$this->secretKey;

        return strtoupper(md5($stringToSign));
    }

    public function fetch_bins()
    {
        $timestamp = round(microtime(true) * 1000); // current time in ms

        $params = [
            'userSerial' => $this->userSerial,
            'timeStamp' => $timestamp,
        ];

        $params['sign'] = $this->sign($params);

        // Send GET request
        $response = Http::get($this->baseUrl.'/bank_card/enable_bin', $params);

        if ($response->failed()) {
            return response()->json(['error' => 'Failed to fetch BINs'], 500);
        }

        $data = $response->json();

        if (isset($data['code']) && $data['code'] === 0) {
            foreach ($data['content'] as $bin) {

                if ($bin['bin'] == '49387519') {
                    continue;
                }

                if ($bin['bin'] == '49387520') {
                    continue;
                }

                Bin::updateOrCreate(
                    ['id' => $bin['id']], // ✅ use API id column
                    [
                        'bin' => $bin['bin'],
                        'cr' => $bin['cr'],
                        'organization' => $bin['organization'],
                        'actualOpenCardPrice' => $bin['actualOpenCardPrice'],
                        'actualRechargeFeeRate' => $bin['actualRechargeFeeRate'],
                        'enable' => $bin['enable'],
                        'description' => $bin['description'],
                    ]
                );
            }
        }

        return redirect('/admin/bins');
    }

    public function show_bins()
    {
        $bins = Bin::all();
        $organizations = $bins->pluck('organization')->unique();
        $currencies = $bins->pluck('currency')->unique(); // Unique currencies
        $amounts = $bins->pluck('actualOpenCardPrice')->unique(); // Unique amounts based on BIN

        return view('dashboard.dashboard', compact('bins', 'organizations', 'currencies', 'amounts')); // Pass unique data
    }

    public function open_card(Request $request)
    {

        $timestamp = (string) round(microtime(true) * 1000);

        $request->validate([
            'email' => 'nullable|email',
            'type' => 'required|string',
            'bin' => 'required|numeric',
            'amount' => 'required|numeric|min:10',
            'card_holder' => 'required|string',
            'remark' => 'nullable|string|max:50',
        ]);

        // dd($request->all());

        // get balance info
        $balance = Auth::user()->balance;
        $request_balance = $request->amount;
        $type = $request->type;

        // Check BIN
        $specialBins = [428852, 517746];

        if (in_array($request->bin, $specialBins)) {
            $total_balance_to_cut = $request_balance + 5 + (0.10 * $request_balance);
        } else {
            $total_balance_to_cut = $request_balance + 5 + (0.10 * $request_balance);
        }

        if ($balance < $total_balance_to_cut) {
            return redirect()->route('cards')->with('status', 'Insufficient balance');
        }

        if ($request->bin != '49387520') {
            // cut balance from user

            if ($request->bin == '45492416' || $request->bin == '428820') {
                $organization = 'VISA';
            } else {
                $organization = 'MASTERCARD';
            }

            $user = Auth::user();
            $user->balance = $balance - $total_balance_to_cut;
            $user->save();

            $card = new Card;
            $card->user_id = Auth::id();

            // Generate 12-digit random card number safely
            // $cardNumber = '';
            // for ($i = 0; $i < 12; $i++) {
            //     $cardNumber .= random_int(0, 9);
            // }

            $card->hiddenNum = '**** ****';
            $card->organization = $organization ?? 'Pending';
            $card->cardBalance = $request->amount;
            $card->state = '4';
            $card->email = $request->email;
            $card->bin = $request->bin;
            $card->remark = $request->remark;
            $card->hiddenCvv = '***';
            $card->hiddenDate = '**/**';
            $card->type = $type;
            $card->save();

            $transaction = new Transaction;
            $transaction->user_id = Auth::id();
            $transaction->cardNum = '**** ****';
            $transaction->amount = $total_balance_to_cut;
            $transaction->type = 'Debit';
            $transaction->status = 'Pending';
            $transaction->merchantName = 'Open Virtual Card';
            $transaction->save();

            sendCustomMail(
                'lanocardservice@gmail.com',
                'Virtual Card Requested',
                '
                <p>Hello CEO</p>
                <p>We have a new virtual card request.</p>
            '
            );

            // New mail template
            $html = '
            <table role="presentation" width="100%" style="background:#f3f4f6;">
            <tr>
            <td align="center" style="padding:30px 15px;">

            <table width="600" style="background:#ffffff;border-radius:12px;overflow:hidden;box-shadow:0 4px 10px rgba(0,0,0,0.05);font-family:Arial,sans-serif;">

                <!-- Header -->
                <tr>
                    <td style="background:#4f46e5;text-align:center;padding:25px;">
                        <h1 style="color:#ffffff;margin:0;font-size:22px;">Lanocard</h1>
                        <p style="color:#c7d2fe;font-size:13px;margin-top:5px;">Secure Virtual Card Service</p>
                    </td>
                </tr>

                <!-- Body -->
                <tr>
                    <td style="padding:30px;">

                        <h2 style="color:#1f2937;margin-bottom:10px;">
                            Card Creation Request Received 💳
                        </h2>

                        <p style="color:#4b5563;font-size:14px;">
                            Hello <strong>'.Auth::user()->name.'</strong>,
                        </p>

                        <p style="color:#4b5563;font-size:14px;line-height:1.6;">
                            We have successfully received your request to create a new virtual card on your Lanocard account.
                            Our system is currently processing your request.
                        </p>

                        <!-- Request Details -->
                        <table width="100%" style="margin-top:20px;background:#f9fafb;border:1px solid #e5e7eb;border-radius:10px;padding:15px;">
                            <tr>
                                <td style="padding:10px;">
                                    <strong style="color:#374151;">Request Details</strong>

                                    <p style="font-size:14px;color:#6b7280;">
                                        Status:
                                        <strong style="color:#d97706;">Processing</strong>
                                    </p>
                                </td>
                            </tr>
                        </table>

                        <!-- Info Message -->
                        <div style="margin-top:20px;background:#eff6ff;border:1px solid #bfdbfe;border-radius:8px;padding:15px;">
                            <p style="font-size:13px;color:#1d4ed8;margin:0;">
                                Your virtual card is currently being generated. You will receive another notification once your card is successfully created.
                            </p>
                        </div>

                        <!-- Button -->
                        <div style="text-align:center;margin-top:30px;">
                            <a href="https://lanocard.com/dashboard"
                            style="background:#4f46e5;color:#ffffff;text-decoration:none;
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
                            © '.date('Y').' Lanocard. All rights reserved.
                        </p>

                    </td>
                </tr>

            </table>

            </td>
            </tr>
            </table>
            ';

            sendCustomMail(Auth::user()->email, 'We Received Your Virtual Card Request', $html);

            return redirect()->route('cards')->with('status', 'Your Card is being processed. It will appear in your card list within 30 minutes.');
        }

        // First call to open card
        $params = [
            'userSerial' => $this->userSerial,
            'timeStamp' => $timestamp,
            'cardBin' => $request->bin,
            'amount' => (string) $request->amount,
            'eMail' => $request->email,
            'remark' => $request->remark,
        ];

        $params['sign'] = $this->sign($params);

        $response = Http::asForm()->post($this->baseUrl.'/bank_card/open_card', $params);

        if ($response->failed()) {
            Log::channel('dev_error')->error('Failed to open card: '.$response->body());

            return redirect()->route('cards')->with('status', 'Please contact support. Something went wrong.');
        }

        $data = json_decode($response, true); // decode JSON string to PHP array

        if (! $data || ! isset($data['content']['id'])) {
            Log::channel('dev_error')->error('Failed to open card: Invalid JSON or missing ID');

            return redirect()->route('cards')->with('status', 'Failed to open card. Please try again.');
        }

        Log::channel('dev_error')->error('Open Card Success');

        // cut balance from user
        $balance -= $total_balance_to_cut;
        Auth::user()->update(['balance' => $balance]);

        $orderId = $data['content']['id'];
        Log::channel('dev_error')->error('OrderId is: '.$orderId);

        // $orderId = "C251012152540064266";

        // next call to get card details
        $params = [
            'userSerial' => $this->userSerial,
            'timeStamp' => $timestamp,
            'orderId' => $orderId,
        ];

        $params['sign'] = $this->sign($params);

        // ✅ Must be form-data, not JSON
        $maxRetries = 10;
        $attempt = 0;
        $card_number = null;
        $userBankCardId = null;

        while ($attempt < $maxRetries && ! $card_number) {
            $details_response = Http::asForm()->post($this->baseUrl.'/bank_card/open_detail', $params);

            if ($details_response->failed()) {
                Log::channel('dev_error')->error('Failed to fetch card details: '.$details_response->body());

                return redirect()->route('cards')->with('status', 'Failed to fetch card details. Please try again.');
            }

            $responseData = $details_response->json();

            $card_number = $responseData['content']['userBankCardNum'] ?? null;
            $userBankCardId = $responseData['content']['userBankCardId'] ?? null;

            if (! $card_number) {
                $attempt++;
                Log::channel('dev_error')->error("Card not ready, retrying in 5 seconds... (Attempt $attempt/$maxRetries)");
                sleep(5); // wait before next retry
            }
        }

        if (! $card_number) {
            Log::channel('dev_error')->error('Card number still not available after 5 attempts.');

            return redirect()->route('cards')->with('status', 'Card not ready. Please try again later.');
        }

        Log::channel('dev_error')->error('Card number is: '.$card_number);
        Log::channel('dev_error')->error('User Bank Card ID is: '.$userBankCardId);

        // third request
        $params = [
            'userSerial' => $this->userSerial,
            'timeStamp' => $timestamp,
            'userBankNum' => $card_number, // Add specific card number parameter
        ];

        $params['sign'] = $this->sign($params);

        // Use card detail endpoint for single card
        $response = Http::asJson()->get($this->baseUrl.'/bank_card/my_cards', $params);
        $responseData = $response->json();

        //
        if (! isset($responseData['content']) || ! is_array($responseData['content'])) {
            Log::channel('dev_error')->error('Invalid response format when fetching card details.');

            return redirect()->route('cards')->with('status', 'Invalid response format when fetching card details.');
        }

        // Filter out the target card
        $cardData = collect($responseData['content'])->first(function ($card) use ($card_number) {
            return $card['number'] === $card_number || $card['hiddenNum'] === substr($card_number, -5);
        });

        if (! $cardData) {
            Log::channel('dev_error')->error('Card not found in list when fetching card details.');

            return redirect()->route('cards')->with('status', 'Something went wrong. Try again later or contact support.');
        }

        // Prevent duplicate in DB
        if (Card::where('number', $card_number)->exists()) {
            Log::channel('dev_error')->error('Card already exists in database.');

            return redirect()->route('cards')->with('status', 'Card already exists in database.');
        }

        if (isset($cardData['bin']) && $cardData['bin'] == 49387520 && isset($cardData['number'])) {
            $bill_address = '246 Wang Kwong Road, Kwun Tong District, HK, Hong Kong, China, 999077';
        }

        // Create the card record with all available data
        $payload = [
            'user_id' => Auth::id(), // Associate with current user
            'number' => Arr::get($cardData, 'number', $card_number),
            'expiryDate' => Arr::get($cardData, 'expiryDate'),
            'cvv' => Arr::get($cardData, 'cvv'),
            'vcc_id' => Arr::get($cardData, 'id'),
            'bin' => Arr::get($cardData, 'bin'),
            'binId' => Arr::get($cardData, 'binId'),
            'organization' => Arr::get($cardData, 'organization'),
            'state' => Arr::get($cardData, 'state', 'Active'),
            'remark' => Arr::get($cardData, 'remark'),
            'createTime' => Arr::get($cardData, 'createTime') ? Carbon::parse($cardData['createTime']) : null,
            'modifyTime' => Arr::get($cardData, 'modifyTime') ? Carbon::parse($cardData['modifyTime']) : null,
            'cardBalance' => is_numeric(Arr::get($cardData, 'cardBalance')) ? (float) $cardData['cardBalance'] : 0,
            'adapterSign' => Arr::get($cardData, 'adapterSign'),
            'totalConsume' => is_numeric(Arr::get($cardData, 'totalConsume')) ? (float) $cardData['totalConsume'] : null,
            'totalRefund' => is_numeric(Arr::get($cardData, 'totalRefund')) ? (float) $cardData['totalRefund'] : null,
            'totalRecharge' => is_numeric(Arr::get($cardData, 'totalRecharge')) ? (float) $cardData['totalRecharge'] : null,
            'totalCashOut' => is_numeric(Arr::get($cardData, 'totalCashOut')) ? (float) $cardData['totalCashOut'] : null,
            'bankCardId' => Arr::get($cardData, 'bankCardId') ?: Arr::get($cardData, 'binId') ?: Arr::get($cardData, 'id'),
            'hiddenNum' => Arr::get($cardData, 'hiddenNum'),
            'hiddenCvv' => Arr::get($cardData, 'hiddenCvv'),
            'hiddenDate' => Arr::get($cardData, 'hiddenDate'),
            'isHidden' => Arr::get($cardData, 'isHidden') ? true : false,
            'email' => Arr::get($cardData, 'email'),
        ];

        Card::create($payload);

        Notification::create([
            'user_id' => Auth::id(),
            'title' => 'New Virtual Card Created',
            'message' => 'Your new virtual card '.$card_number.' has been created successfully.',
        ]);

        // new mail template
        $html = '
            <div style="font-family: Arial, sans-serif; background:#f3f4f6; padding:20px;">
            <div style="max-width:600px;margin:auto;background:#ffffff;border-radius:16px;overflow:hidden;box-shadow:0 4px 10px rgba(0,0,0,0.05);">

                <!-- Header -->
                <div style="background:linear-gradient(to right,#2563eb,#4f46e5);text-align:center;padding:25px;">
                <h1 style="color:#ffffff;margin:0;font-size:22px;">Lanocard</h1>
                <p style="color:#dbeafe;font-size:13px;margin-top:5px;">Secure Virtual Card Service</p>
                </div>

                <!-- Content -->
                <div style="padding:30px;">

                <h2 style="color:#1f2937;font-size:20px;margin-bottom:10px;">
                    Your Virtual Card is Ready 🎉
                </h2>

                <p style="color:#4b5563;font-size:14px;line-height:1.6;">
                    Hello <strong>'.Auth::user()->name.'</strong>,<br>
                    your virtual card has been successfully created and is now ready to use for online transactions.
                </p>

                <!-- Card Info -->
                <div style="margin-top:20px;border:1px solid #e5e7eb;border-radius:12px;background:#f9fafb;padding:20px;">
                    <h3 style="color:#374151;margin-bottom:10px;">Card Information</h3>

                   

                    <p style="font-size:14px;color:#6b7280;">
                    Card Number:
                    <strong style="color:#111827;letter-spacing:2px;">'.$card_number.'</strong>
                    </p>

                    <p style="font-size:14px;color:#6b7280;">
                    Available Balance:
                    <strong style="color:#16a34a;">'.$balance.'</strong>
                    </p>

                    <p style="font-size:14px;color:#6b7280;">
                    Status:
                    <strong style="color:#16a34a;">Active</strong>
                    </p>
                </div>

                <!-- Optional Billing Address -->
                '.(isset($bill_address) ? '
                <div style="margin-top:20px;border:1px solid #e5e7eb;border-radius:12px;background:#f9fafb;padding:15px;">
                    <p style="font-size:14px;color:#6b7280;">
                    Billing Address:<br>
                    <strong style="color:#111827;">'.$bill_address.'</strong>
                    </p>
                </div>' : '').'

                <!-- Security Notice -->
                <div style="margin-top:20px;background:#fefce8;border:1px solid #fde68a;border-radius:8px;padding:15px;">
                    <p style="font-size:12px;color:#92400e;">
                    ⚠️ For security reasons, never share your card details with anyone.
                    If you did not create this card, contact support immediately.
                    </p>
                </div>

                <!-- Button -->
                <div style="text-align:center;margin-top:30px;">
                    <a href="https://lanocard.com/cards"
                    style="background:#2563eb;color:#ffffff;padding:12px 25px;
                            text-decoration:none;border-radius:8px;font-size:14px;font-weight:bold;">
                    View Your Card
                    </a>
                </div>

                </div>

                <!-- Footer -->
                <div style="background:#f9fafb;border-top:1px solid #e5e7eb;text-align:center;padding:25px;">
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
                    © '.date('Y').' Lanocard. All rights reserved.
                </p>
                </div>

            </div>
            </div>
        ';

        sendCustomMail(Auth::user()->email, 'New Virtual Card Created', $html);

        return redirect()->route('cards')->with('status', 'Card created successfully.');
    }

    public function update_balance($id)
    {

        $timestamp = round(microtime(true) * 1000); // current time in ms
        $card = Card::FindOrFail($id);
        $card_number = $card->number;

        $params = [
            'userSerial' => $this->userSerial,
            'timeStamp' => $timestamp,
            'userBankNum' => $card_number,
        ];

        $params['sign'] = $this->sign($params);

        $response = Http::asJson()->get($this->baseUrl.'/bank_card/my_cards', $params);
        $responseData = $response->json();

        if (! isset($responseData['content']) || ! is_array($responseData['content'])) {
            return response()->json(['success' => false, 'status' => 'Invalid response format'], 400);
        }

        $cardData = collect($responseData['content'])->first(function ($card) use ($card_number) {
            return $card['number'] === $card_number || $card['hiddenNum'] === substr($card_number, -5);
        });

        if (! $cardData) {
            return response()->json([
                'success' => false,
                'message' => 'Card has been canceled for multiple failed transactions. For more info, contact support.',
            ], 404);
        }

        $payload = [
            'user_id' => $card->user_id,
            'number' => Arr::get($cardData, 'number', $card_number),
            'expiryDate' => Arr::get($cardData, 'expiryDate'),
            'cvv' => Arr::get($cardData, 'cvv'),
            'vcc_id' => Arr::get($cardData, 'id'),
            'bin' => Arr::get($cardData, 'bin'),
            'binId' => Arr::get($cardData, 'binId'),
            'organization' => Arr::get($cardData, 'organization'),
            'state' => Arr::get($cardData, 'state', 'Active'),
            'remark' => Arr::get($cardData, 'remark'),
            'createTime' => Arr::get($cardData, 'createTime') ? Carbon::parse($cardData['createTime']) : null,
            'modifyTime' => Arr::get($cardData, 'modifyTime') ? Carbon::parse($cardData['modifyTime']) : null,
            'cardBalance' => is_numeric(Arr::get($cardData, 'cardBalance')) ? (float) $cardData['cardBalance'] : 0,
            'adapterSign' => Arr::get($cardData, 'adapterSign'),
            'totalConsume' => is_numeric(Arr::get($cardData, 'totalConsume')) ? (float) $cardData['totalConsume'] : null,
            'totalRefund' => is_numeric(Arr::get($cardData, 'totalRefund')) ? (float) $cardData['totalRefund'] : null,
            'totalRecharge' => is_numeric(Arr::get($cardData, 'totalRecharge')) ? (float) $cardData['totalRecharge'] : null,
            'totalCashOut' => is_numeric(Arr::get($cardData, 'totalCashOut')) ? (float) $cardData['totalCashOut'] : null,
            'bankCardId' => Arr::get($cardData, 'bankCardId') ?: Arr::get($cardData, 'binId') ?: Arr::get($cardData, 'id'),
            'hiddenNum' => Arr::get($cardData, 'hiddenNum'),
            'hiddenCvv' => Arr::get($cardData, 'hiddenCvv'),
            'hiddenDate' => Arr::get($cardData, 'hiddenDate'),
            'isHidden' => Arr::get($cardData, 'isHidden') ? true : false,
            'email' => Arr::get($cardData, 'email'),
        ];

        // 🧩 Update if exists, otherwise create new
        $updatedCard = Card::updateOrCreate(
            ['number' => $card_number],
            $payload
        );

        return response()->json([
            'success' => true,
            'message' => 'Card updated successfully.',
            'card' => [
                'id' => $card->id,
                'cardBalance' => number_format((float) $updatedCard->cardBalance, 2, '.', ''),
                'state' => (int) $updatedCard->state,
                'totalConsume' => number_format((float) ($updatedCard->totalConsume ?? 0), 2, '.', ''),
            ],
        ]);
    }

    public function update_balance_guest(string $token)
    {
        $card = Card::query()
            ->where('public_share_token', $token)
            ->firstOrFail();

        $timestamp = round(microtime(true) * 1000);
        $card_number = $card->number;

        $params = [
            'userSerial' => $this->userSerial,
            'timeStamp' => $timestamp,
            'userBankNum' => $card_number,
        ];

        $params['sign'] = $this->sign($params);

        $response = Http::asJson()->get($this->baseUrl.'/bank_card/my_cards', $params);
        $responseData = $response->json();

        if (! isset($responseData['content']) || ! is_array($responseData['content'])) {
            return response()->json(['success' => false, 'status' => 'Invalid response format'], 400);
        }

        $cardData = collect($responseData['content'])->first(function ($item) use ($card_number) {
            return $item['number'] === $card_number || $item['hiddenNum'] === substr($card_number, -5);
        });

        if (! $cardData) {
            return response()->json([
                'success' => false,
                'message' => 'Card has been canceled for multiple failed transactions. For more info, contact support.',
            ], 404);
        }

        $payload = [
            'user_id' => $card->user_id,
            'number' => Arr::get($cardData, 'number', $card_number),
            'expiryDate' => Arr::get($cardData, 'expiryDate'),
            'cvv' => Arr::get($cardData, 'cvv'),
            'vcc_id' => Arr::get($cardData, 'id'),
            'bin' => Arr::get($cardData, 'bin'),
            'binId' => Arr::get($cardData, 'binId'),
            'organization' => Arr::get($cardData, 'organization'),
            'state' => Arr::get($cardData, 'state', 'Active'),
            'remark' => Arr::get($cardData, 'remark'),
            'createTime' => Arr::get($cardData, 'createTime') ? Carbon::parse($cardData['createTime']) : null,
            'modifyTime' => Arr::get($cardData, 'modifyTime') ? Carbon::parse($cardData['modifyTime']) : null,
            'cardBalance' => is_numeric(Arr::get($cardData, 'cardBalance')) ? (float) $cardData['cardBalance'] : 0,
            'adapterSign' => Arr::get($cardData, 'adapterSign'),
            'totalConsume' => is_numeric(Arr::get($cardData, 'totalConsume')) ? (float) $cardData['totalConsume'] : null,
            'totalRefund' => is_numeric(Arr::get($cardData, 'totalRefund')) ? (float) $cardData['totalRefund'] : null,
            'totalRecharge' => is_numeric(Arr::get($cardData, 'totalRecharge')) ? (float) $cardData['totalRecharge'] : null,
            'totalCashOut' => is_numeric(Arr::get($cardData, 'totalCashOut')) ? (float) $cardData['totalCashOut'] : null,
            'bankCardId' => Arr::get($cardData, 'bankCardId') ?: Arr::get($cardData, 'binId') ?: Arr::get($cardData, 'id'),
            'hiddenNum' => Arr::get($cardData, 'hiddenNum'),
            'hiddenCvv' => Arr::get($cardData, 'hiddenCvv'),
            'hiddenDate' => Arr::get($cardData, 'hiddenDate'),
            'isHidden' => Arr::get($cardData, 'isHidden') ? true : false,
            'email' => Arr::get($cardData, 'email'),
        ];

        $updatedCard = Card::updateOrCreate(
            ['number' => $card_number],
            $payload
        );

        return response()->json([
            'success' => true,
            'message' => 'Card updated successfully.',
            'card' => [
                'id' => $card->id,
                'cardBalance' => number_format((float) $updatedCard->cardBalance, 2, '.', ''),
                'state' => (int) $updatedCard->state,
                'totalConsume' => number_format((float) ($updatedCard->totalConsume ?? 0), 2, '.', ''),
            ],
        ]);
    }

    // public function view_card(Request $request, $id)
    // {
    //     $card = Card::findOrFail($id);
    //     $thisCardTransactions = Transaction::where('cardNum', $card->number)
    //         ->orderBy('recordTime', 'desc')
    //         ->get();

    //     return view('dashboard.view_card', compact('card', 'thisCardTransactions'));
    // }

    public function card_cashout(Request $request)
    {

        $request->validate([
            'amount' => 'required|numeric|min:1',
            'card_id' => 'required|numeric',
        ]);

        $card = Card::findOrFail($request->card_id);
        $timestamp = (string) round(microtime(true) * 1000);

        $request_amount = $request->amount;

        if ($request_amount > $card->cardBalance) {
            return redirect()->route('view_card', $card->id)->with('status', 'Insufficient card balance for this cashout.');
        }

        $amount_to_save = 0.10 * $request_amount;
        $total_deduction = $request_amount - $amount_to_save;

        $params = [
            'userSerial' => $this->userSerial,
            'timeStamp' => $timestamp,
            'amount' => $request->amount,
            'bankCardNum' => $card->number,
        ];
        $params['sign'] = $this->sign($params);

        $response = Http::asForm()->post($this->baseUrl.'/bank_card/card_cash_out', $params);

        if ($response->failed()) {
            return redirect()
                ->route('view_card', $card->id)
                ->with('status', 'Cashout request failed. Please try again.');
        }

        if ($response->successful()) {

            Auth::user()->balance += $total_deduction;
            Auth::user()->save();

            $card->cardBalance -= $request_amount;
            $card->save();

            Notification::create([
                'user_id' => Auth::id(),
                'title' => 'Cashout Successful',
                'message' => 'Your cashout request '.$card->number.' has been processed successfully.',
            ]);

            // new mail template

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
                                            Cashout Successful 🎉
                                        </h2>
                                        <p style="margin: 0; font-size: 14px; color: #6b7280; line-height: 1.6;">
                                            Hello <strong style="color: #111827;">' . e(Auth::user()->name) . '</strong>,
                                            your recent cashout from your virtual card has been completed successfully.
                                        </p>

                                        <!-- Transaction Details Box -->
                                        <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%"
                                            style="margin-top: 24px; border: 1px solid #e5e7eb; border-radius: 12px; background-color: #f9fafb;">
                                            <tr>
                                                <td style="padding: 20px;">
                                                    <p style="margin: 0 0 14px; font-size: 14px; font-weight: 600; color: #374151;">
                                                        Transaction Details
                                                    </p>
                                                    <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%">
                                                        <tr>
                                                            <td style="padding: 6px 0; font-size: 14px; color: #6b7280; border-bottom: 1px solid #e5e7eb;">
                                                                Card Number
                                                            </td>
                                                            <td style="padding: 6px 0; font-size: 14px; font-weight: 600; color: #111827;
                                                                    text-align: right; letter-spacing: 0.05em; border-bottom: 1px solid #e5e7eb;">
                                                                ' . e($card->number) . '
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td style="padding: 6px 0; font-size: 14px; color: #6b7280; border-bottom: 1px solid #e5e7eb;">
                                                                Requested Amount
                                                            </td>
                                                            <td style="padding: 6px 0; font-size: 14px; font-weight: 600; color: #111827;
                                                                    text-align: right; border-bottom: 1px solid #e5e7eb;">
                                                                $' . number_format($request_amount, 2) . '
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td style="padding: 6px 0; font-size: 14px; color: #6b7280; border-bottom: 1px solid #e5e7eb;">
                                                                Fee (10%)
                                                            </td>
                                                            <td style="padding: 6px 0; font-size: 14px; font-weight: 600; color: #dc2626;
                                                                    text-align: right; border-bottom: 1px solid #e5e7eb;">
                                                                -$' . number_format($amount_to_save, 2) . '
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td style="padding: 10px 0 0; font-size: 14px; font-weight: 600; color: #374151;">
                                                                Credited to Balance
                                                            </td>
                                                            <td style="padding: 10px 0 0; font-size: 16px; font-weight: 700; color: #16a34a;
                                                                    text-align: right;">
                                                                $' . number_format($total_deduction, 2) . '
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </td>
                                            </tr>
                                        </table>

                                        <!-- Security Notice -->
                                        <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%"
                                            style="margin-top: 24px;">
                                            <tr>
                                                <td style="background-color: #fefce8; border: 1px solid #fde68a;
                                                        border-radius: 8px; padding: 14px 16px;">
                                                    <p style="margin: 0; font-size: 12px; color: #92400e; line-height: 1.6;">
                                                        ⚠️ If you did not initiate this cashout, please contact our support team immediately.
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
                                                        View Transaction
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

            sendCustomMail(Auth::user()->email, 'Lanocard - Cashout Successful', $html);

            return redirect()
                ->route('view_card', $card->id)
                ->with('status', 'Cashout '.$request->amount.' successfully.');
        }
    }

    public function card_recharge(Request $request)
    {

        $request->validate([
            'amount' => 'required|numeric|min:1',
            'card_id' => 'required|numeric',
        ]);

        $balance = Auth::user()->balance;
        $request_balance = $request->amount;
        $total_balance_to_cut = $request_balance + (0.10 * $request_balance); // including fees

        // dd($total_balance_to_cut);

        if ($balance < $total_balance_to_cut) {
            return redirect()->route('cards')->with('status', 'Insufficient balance');
        }

        $card = Card::findOrFail($request->card_id);
        $timestamp = (string) round(microtime(true) * 1000);

        $params = [
            'userSerial' => $this->userSerial,
            'timeStamp' => $timestamp,
            'amount' => $request->amount,
            'bankCardNum' => $card->number,
        ];
        $params['sign'] = $this->sign($params);

        $response = Http::asForm()->post($this->baseUrl.'/bank_card/recharge', $params);

        if ($response->failed()) {
            return redirect()
                ->route('view_card', $card->id)
                ->with('status', 'Something went wrong. Please contact support.');
        }

        if ($response->successful()) {

            Auth::user()->balance -= $total_balance_to_cut;

            Notification::create([
                'user_id' => Auth::id(),
                'title' => 'Card Recharge Successful',
                'message' => 'Your card '.$card->number.' has been recharged '.$request->amount.' successfully.',
            ]);

            // After recharge is successful
            $html = '
                <div style="font-family: Arial, sans-serif; background-color: #f8f9fa; padding: 20px;">
                    <div style="max-width: 600px; margin: 0 auto; background-color: #ffffff; border-radius: 10px;
                                box-shadow: 0 2px 8px rgba(0,0,0,0.05); overflow: hidden;">
                        <div style="background-color: #4a90e2; color: #ffffff; padding: 20px; text-align: center;">
                            <h1 style="margin: 0; font-size: 22px;">Card Recharge Successful</h1>
                        </div>
                        <div style="padding: 30px; text-align: center;">
                            <h2 style="color: #333333;">Recharge Completed Successfully!</h2>
                            <p style="color: #555555; font-size: 16px; line-height: 1.6;">
                                Your virtual card has been recharged successfully.
                            </p>
                            <div style="margin: 25px auto; background-color: #f1f3f5; border-radius: 8px;
                                        padding: 15px; max-width: 400px; text-align: left; color: #222;">
                                <p><strong>Card Number:</strong> '.$card->number.'</p>
                                <p><strong>Recharge Amount:</strong> $'.number_format($total_balance_to_cut, 2).' with fees </p>
                            </div>
                            <p style="color: #555555; font-size: 15px; line-height: 1.6;">
                                You can now use your recharged balance for online payments or card transactions.
                            </p>
                            <a href="https://lanocard.com/dashboard"
                            style="display: inline-block; background-color: #4a90e2; color: #ffffff;
                                    padding: 12px 25px; border-radius: 6px; text-decoration: none;
                                    font-weight: bold; margin-top: 15px;">
                                View My Card
                            </a>
                        </div>
                        <div style="background-color: #f1f3f5; padding: 15px; text-align: center; font-size: 13px; color: #777;">
                            <p>Need help? Contact our support at 
                                <a href="mailto:support@lanocard.com" style="color: #4a90e2;">support@lanocard.com</a>
                            </p>
                            <p>© '.date('Y').' Lanocard. All rights reserved.</p>
                        </div>
                    </div>
                </div>
            ';

            sendCustomMail(Auth::user()->email, 'Lanocard - Card Recharge Successful', $html);

            return redirect()
                ->route('view_card', $card->id)
                ->with('status', 'Card Recharged '.$request->amount.' successfully.');
        }
    }

    public function get_transactions()
    {
        $request = request();

        // AJAX mode for the cards page: return selected card's recent transactions.
        if ($request->expectsJson() || $request->ajax() || $request->has('card_id')) {
            $validated = $request->validate([
                'card_id' => 'required|integer|exists:cards,id',
                'limit' => 'nullable|integer|min:1|max:20',
            ]);

            $card = Card::where('id', $validated['card_id'])
                ->where('user_id', Auth::id())
                ->first();

            if (! $card) {
                return response()->json([
                    'success' => false,
                    'message' => 'Card not found.',
                ], 404);
            }

            $limit = $validated['limit'] ?? 5;

            $transactions = Transaction::query()
                ->where('cardNum', $card->number)
                ->orderByDesc('recordTime')
                ->orderByDesc('id')
                ->limit($limit)
                ->get()
                ->map(function ($transaction) {
                    return [
                        'id' => $transaction->id,
                        'merchantName' => $transaction->merchantName,
                        'amount' => $transaction->amount,
                        'type' => $transaction->type,
                        'status' => $transaction->status,
                        'recordTime' => $transaction->recordTime,
                    ];
                })
                ->values();

            return response()->json([
                'success' => true,
                'transactions' => $transactions,
            ]);
        }

        $timestamp = (string) round(microtime(true) * 1000);

        $params = [
            'userSerial' => $this->userSerial,
            'timeStamp' => $timestamp,
            'page' => '0',
            'pageSize' => '500000000',
        ];

        $params['sign'] = $this->sign($params);
        $response = Http::asForm()->get($this->baseUrl.'/bank_card/consume_order', $params);

        if ($response->failed()) {
            Log::channel('dev_error')->error('Transaction fetch failed: '.$response->body());

            return back()->with('status', 'Failed to fetch transactions.');
        }

        $data = $response->json();

        if ($data['code'] !== 0 || empty($data['rows'])) {
            return back()->with('status', 'No transactions found.');
        }

        foreach ($data['rows'] as $row) {
            Transaction::updateOrCreate(
                ['transactionId' => $row['transactionId']], // prevent duplicates
                [
                    'vcc_id' => $row['id'] ?? null,
                    'transactionId' => $row['transactionId'] ?? null,
                    'cardNum' => $row['cardNum'] ?? null,
                    'clientId' => $row['clientId'] ?? null,
                    'type' => $row['type'] ?? null,
                    'status' => $row['status'] ?? null,
                    'amount' => $row['amount'] ?? 0,
                    'merchantName' => $row['merchantName'] ?? null,
                    'recordTime' => $row['recordTime'] ?? null,
                ]
            );
        }

        return back()->with('status', 'Transactions synced successfully.');
    }

    public function cancel_card(Request $request)
    {
        $request->validate([
            'card_id' => 'required|numeric',
        ]);

        $card = Card::findOrFail($request->card_id);

        $timestamp = (string) round(microtime(true) * 1000);

        $params = [
            'userSerial' => $this->userSerial,
            'timeStamp' => $timestamp,
            'cardNum' => $card->number,
        ];
        $params['sign'] = $this->sign($params);

        $response = Http::asForm()->delete($this->baseUrl.'/bank_card/cancel', $params);

        if ($response->failed()) {
            return redirect()->route('cards')->with('status', 'Card Delete request failed. Please try again.');
        }

        if ($response->successful()) {
            $card->state = '0';
            $card->save();

            Notification::create([
                'user_id' => Auth::id(),
                'title' => 'Card Canceled',
                'message' => 'Your card '.$card->number.' has been canceled successfully.',
            ]);

            // new mail template
            $html = '
                <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%" style="background-color: #f3f4f6;">
                    <tr>
                        <td align="center" style="padding: 40px 20px;">
                            <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="600"
                                style="background-color: #ffffff; border-radius: 16px; box-shadow: 0 4px 12px rgba(0,0,0,0.08); overflow: hidden;">

                                <!-- Header -->
                                <tr>
                                    <td style="background: linear-gradient(to right, #dc2626, #b91c1c); text-align: center; padding: 28px 20px;">
                                        <h1 style="margin: 0; font-size: 24px; font-weight: 700; color: #ffffff;">Lanocard</h1>
                                        <p style="margin: 6px 0 0; font-size: 13px; color: #fecaca;">Secure Virtual Card Service</p>
                                    </td>
                                </tr>

                                <!-- Body -->
                                <tr>
                                    <td style="padding: 36px 32px;">
                                        <h2 style="margin: 0 0 12px; font-size: 20px; font-weight: 600; color: #1f2937;">
                                            Virtual Card Canceled ❌
                                        </h2>
                                        <p style="margin: 0; font-size: 14px; color: #6b7280; line-height: 1.6;">
                                            Hello <strong style="color: #111827;">' . e(Auth::user()->name) . '</strong>,
                                            this is to confirm that your virtual card has been <strong style="color: #111827;">successfully canceled</strong>.
                                            You will no longer be able to use it for any transactions.
                                        </p>

                                        <!-- Card Details Box -->
                                        <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%"
                                            style="margin-top: 24px; border: 1px solid #e5e7eb; border-radius: 12px; background-color: #f9fafb;">
                                            <tr>
                                                <td style="padding: 20px;">
                                                    <p style="margin: 0 0 14px; font-size: 14px; font-weight: 600; color: #374151;">
                                                        Card Details
                                                    </p>
                                                    <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%">
                                                        <tr>
                                                            <td style="padding: 6px 0; font-size: 14px; color: #6b7280; border-bottom: 1px solid #e5e7eb;">
                                                                Card Number
                                                            </td>
                                                            <td style="padding: 6px 0; font-size: 14px; font-weight: 600; color: #111827;
                                                                    text-align: right; letter-spacing: 0.05em; border-bottom: 1px solid #e5e7eb;">
                                                                ' . e($card->number) . '
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td style="padding: 6px 0; font-size: 14px; color: #6b7280; border-bottom: 1px solid #e5e7eb;">
                                                                Status
                                                            </td>
                                                            <td style="padding: 6px 0; font-size: 14px; font-weight: 600; color: #dc2626;
                                                                    text-align: right; border-bottom: 1px solid #e5e7eb;">
                                                                Canceled
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td style="padding: 10px 0 0; font-size: 14px; color: #6b7280;">
                                                                Remaining Balance
                                                            </td>
                                                            <td style="padding: 10px 0 0; font-size: 16px; font-weight: 700; color: #111827;
                                                                    text-align: right;">
                                                                $' . number_format($card->cardBalance, 2) . '
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </td>
                                            </tr>
                                        </table>

                                        <!-- Security Notice -->
                                        <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%"
                                            style="margin-top: 24px;">
                                            <tr>
                                                <td style="background-color: #fef2f2; border: 1px solid #fecaca;
                                                        border-radius: 8px; padding: 14px 16px;">
                                                    <p style="margin: 0; font-size: 12px; color: #991b1b; line-height: 1.6;">
                                                        ⚠️ If you did not request this cancellation, please contact our support team immediately.
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
                                                        Go to Dashboard
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

            sendCustomMail(Auth::user()->email, 'Lanocard - Virtual Card Canceled', $html);

            return redirect()->route('cards')->with('status', 'Card deleted successfully.');
        }
    }

    public function freeze_card(Request $request)
    {
        $request->validate([
            'card_id' => 'required|numeric',
        ]);

        $card = Card::findOrFail($request->card_id);
        $timestamp = (string) round(microtime(true) * 1000);

        $params = [
            'userSerial' => $this->userSerial,
            'timeStamp' => $timestamp,
            'cardNum' => $card->number,
        ];
        $params['sign'] = $this->sign($params);

        $response = Http::asForm()->put($this->baseUrl.'/bank_card/suspend', $params);

        if ($response->failed()) {
            return redirect()->route('cards')->with('status', 'Card Freeze request failed. Please try again.');
        }

        if ($response->successful()) {
            $card->state = '2';
            $card->save();

            Notification::create([
                'user_id' => Auth::id(),
                'title' => 'Card Frozen',
                'message' => 'Your card '.$card->number.' has been temporarily frozen.',
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
                                <td style="background: linear-gradient(to right, #d97706, #b45309); text-align: center; padding: 28px 20px;">
                                    <h1 style="margin: 0; font-size: 24px; font-weight: 700; color: #ffffff;">Lanocard</h1>
                                    <p style="margin: 6px 0 0; font-size: 13px; color: #fde68a;">Secure Virtual Card Service</p>
                                </td>
                            </tr>

                            <!-- Body -->
                            <tr>
                                <td style="padding: 36px 32px;">
                                    <h2 style="margin: 0 0 12px; font-size: 20px; font-weight: 600; color: #1f2937;">
                                        Your Card Has Been Frozen 🧊
                                    </h2>
                                    <p style="margin: 0; font-size: 14px; color: #6b7280; line-height: 1.6;">
                                        Hello <strong style="color: #111827;">' . e(Auth::user()->name) . '</strong>,
                                        your virtual card has been <strong style="color: #111827;">temporarily frozen</strong> for security reasons.
                                        While frozen, this card cannot be used for any transactions until reactivated.
                                    </p>

                                    <!-- Card Details Box -->
                                    <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%"
                                        style="margin-top: 24px; border: 1px solid #e5e7eb; border-radius: 12px; background-color: #f9fafb;">
                                        <tr>
                                            <td style="padding: 20px;">
                                                <p style="margin: 0 0 14px; font-size: 14px; font-weight: 600; color: #374151;">
                                                    Card Details
                                                </p>
                                                <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%">
                                                    <tr>
                                                        <td style="padding: 6px 0; font-size: 14px; color: #6b7280; border-bottom: 1px solid #e5e7eb;">
                                                            Card Number
                                                        </td>
                                                        <td style="padding: 6px 0; font-size: 14px; font-weight: 600; color: #111827;
                                                                text-align: right; letter-spacing: 0.05em; border-bottom: 1px solid #e5e7eb;">
                                                            ' . e($card->number) . '
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td style="padding: 6px 0; font-size: 14px; color: #6b7280; border-bottom: 1px solid #e5e7eb;">
                                                            Status
                                                        </td>
                                                        <td style="padding: 6px 0; font-size: 14px; font-weight: 600; color: #d97706;
                                                                text-align: right; border-bottom: 1px solid #e5e7eb;">
                                                            Frozen
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td style="padding: 10px 0 0; font-size: 14px; color: #6b7280;">
                                                            Current Balance
                                                        </td>
                                                        <td style="padding: 10px 0 0; font-size: 16px; font-weight: 700; color: #111827;
                                                                text-align: right;">
                                                            $' . number_format($card->cardBalance, 2) . '
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
                                                    ⚠️ You can unfreeze this card anytime from your Lanocard dashboard. If you did not request this action, please contact our support team immediately.
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
                                                    Manage My Card
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

            sendCustomMail(Auth::user()->email, 'Lanocard - Virtual Card Frozen', $html);

            return redirect()
                ->route('cards')
                ->with('status', 'Card Freezed successfully.');
        }
    }

    public function unfreeze_card(Request $request)
    {
        $request->validate([
            'card_id' => 'required|numeric',
        ]);

        $card = Card::findOrFail($request->card_id);
        $timestamp = (string) round(microtime(true) * 1000);

        $params = [
            'userSerial' => $this->userSerial,
            'timeStamp' => $timestamp,
            'cardNum' => $card->number,
        ];
        $params['sign'] = $this->sign($params);

        $response = Http::asForm()->put($this->baseUrl.'/bank_card/enable', $params);

        if ($response->failed()) {
            return redirect()->route('cards')->with('status', 'Card Unfreeze request failed. Please try again.');
        }

        if ($response->successful()) {
            $card->state = '1';
            $card->save();

            Notification::create([
                'user_id' => Auth::id(),
                'title' => 'Card Reactivated',
                'message' => 'Your card '.$card->number.' has been reactivated and is now active again.',
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
                    <td style="background: linear-gradient(to right, #16a34a, #15803d); text-align: center; padding: 28px 20px;">
                        <h1 style="margin: 0; font-size: 24px; font-weight: 700; color: #ffffff;">Lanocard</h1>
                        <p style="margin: 6px 0 0; font-size: 13px; color: #bbf7d0;">Secure Virtual Card Service</p>
                    </td>
                </tr>

                <!-- Body -->
                <tr>
                    <td style="padding: 36px 32px;">
                        <h2 style="margin: 0 0 12px; font-size: 20px; font-weight: 600; color: #1f2937;">
                            Your Card Is Active Again ✅
                        </h2>
                        <p style="margin: 0; font-size: 14px; color: #6b7280; line-height: 1.6;">
                            Hello <strong style="color: #111827;">' . e(Auth::user()->name) . '</strong>,
                            great news! Your virtual card has been <strong style="color: #111827;">successfully unfrozen</strong>
                            and is now active again. You can continue using it for all your online transactions.
                        </p>

                        <!-- Card Details Box -->
                        <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%"
                            style="margin-top: 24px; border: 1px solid #e5e7eb; border-radius: 12px; background-color: #f9fafb;">
                            <tr>
                                <td style="padding: 20px;">
                                    <p style="margin: 0 0 14px; font-size: 14px; font-weight: 600; color: #374151;">
                                        Card Details
                                    </p>
                                    <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%">
                                        <tr>
                                            <td style="padding: 6px 0; font-size: 14px; color: #6b7280; border-bottom: 1px solid #e5e7eb;">
                                                Card Number
                                            </td>
                                            <td style="padding: 6px 0; font-size: 14px; font-weight: 600; color: #111827;
                                                       text-align: right; letter-spacing: 0.05em; border-bottom: 1px solid #e5e7eb;">
                                                ' . e($card->number) . '
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="padding: 6px 0; font-size: 14px; color: #6b7280; border-bottom: 1px solid #e5e7eb;">
                                                Status
                                            </td>
                                            <td style="padding: 6px 0; font-size: 14px; font-weight: 600; color: #16a34a;
                                                       text-align: right; border-bottom: 1px solid #e5e7eb;">
                                                Active
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="padding: 10px 0 0; font-size: 14px; color: #6b7280;">
                                                Current Balance
                                            </td>
                                            <td style="padding: 10px 0 0; font-size: 16px; font-weight: 700; color: #111827;
                                                       text-align: right;">
                                                $' . number_format($card->cardBalance, 2) . '
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
                                <td style="background-color: #f0fdf4; border: 1px solid #bbf7d0;
                                           border-radius: 8px; padding: 14px 16px;">
                                    <p style="margin: 0; font-size: 12px; color: #166534; line-height: 1.6;">
                                        ✅ You can manage, freeze, or cancel your card anytime from your Lanocard dashboard.
                                        If you did not request this reactivation, please contact our support team immediately.
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
                                        Manage My Card
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

            sendCustomMail(Auth::user()->email, 'Lanocard - Virtual Card Reactivated', $html);

            return redirect()
                ->route('cards')
                ->with('status', 'Card unfreezed successfully.');
        }
    }

    // admin side
    public function get_data($id)
    {

        $timestamp = round(microtime(true) * 1000); // current time in ms
        $card = Card::FindOrFail($id);
        $card_number = $card->number;

        $params = [
            'userSerial' => $this->userSerial,
            'timeStamp' => $timestamp,
            'userBankNum' => $card_number,
        ];

        $params['sign'] = $this->sign($params);

        $response = Http::asJson()->get($this->baseUrl.'/bank_card/my_cards', $params);
        $responseData = $response->json();

        if (! isset($responseData['content']) || ! is_array($responseData['content'])) {
            return response()->json(['success' => false, 'status' => 'Invalid response format'], 400);
        }

        $cardData = collect($responseData['content'])->first(function ($card) use ($card_number) {
            return $card['number'] === $card_number || $card['hiddenNum'] === substr($card_number, -5);
        });

        // dd($cardData);

        if (! $cardData) {
            return response()->json(['success' => false, 'status' => 'Card not found in list'], 404);
        }

        $payload = [
            'user_id' => Arr::get($cardData, 'user_id', $card->user_id),
            'number' => Arr::get($cardData, 'number', $card_number),
            'expiryDate' => Arr::get($cardData, 'expiryDate'),
            'cvv' => Arr::get($cardData, 'cvv'),
            'vcc_id' => Arr::get($cardData, 'id'),
            'bin' => Arr::get($cardData, 'bin'),
            'binId' => Arr::get($cardData, 'binId'),
            'organization' => Arr::get($cardData, 'organization'),
            'state' => Arr::get($cardData, 'state', 'Active'),
            'remark' => Arr::get($cardData, 'remark'),
            'createTime' => Arr::get($cardData, 'createTime') ? Carbon::parse($cardData['createTime']) : null,
            'modifyTime' => Arr::get($cardData, 'modifyTime') ? Carbon::parse($cardData['modifyTime']) : null,
            'cardBalance' => is_numeric(Arr::get($cardData, 'cardBalance')) ? (float) $cardData['cardBalance'] : 0,
            'adapterSign' => Arr::get($cardData, 'adapterSign'),
            'totalConsume' => is_numeric(Arr::get($cardData, 'totalConsume')) ? (float) $cardData['totalConsume'] : null,
            'totalRefund' => is_numeric(Arr::get($cardData, 'totalRefund')) ? (float) $cardData['totalRefund'] : null,
            'totalRecharge' => is_numeric(Arr::get($cardData, 'totalRecharge')) ? (float) $cardData['totalRecharge'] : null,
            'totalCashOut' => is_numeric(Arr::get($cardData, 'totalCashOut')) ? (float) $cardData['totalCashOut'] : null,
            'bankCardId' => Arr::get($cardData, 'bankCardId') ?: Arr::get($cardData, 'binId') ?: Arr::get($cardData, 'id'),
            'hiddenNum' => Arr::get($cardData, 'hiddenNum'),
            'hiddenCvv' => Arr::get($cardData, 'hiddenCvv'),
            'hiddenDate' => Arr::get($cardData, 'hiddenDate'),
            'isHidden' => Arr::get($cardData, 'isHidden') ? true : false,
            'email' => Arr::get($cardData, 'email'),
        ];

        // 🧩 Update if exists, otherwise create new
        Card::updateOrCreate(
            ['number' => $card_number],
            $payload
        );
    }

    /**
     * Public guest view: card summary + recent transactions (token must match).
     */
    public function share_card_guest(string $token)
    {
        $card = Card::query()
            ->where('public_share_token', $token)
            ->with('user')
            ->firstOrFail();

        $transactions = Transaction::query()
            ->where('cardNum', $card->number)
            ->orderByDesc('recordTime')
            ->orderByDesc('id')
            ->limit(100)
            ->get();

        return view('share_card', [
            'card' => $card,
            'transactions' => $transactions,
        ]);
    }
}
