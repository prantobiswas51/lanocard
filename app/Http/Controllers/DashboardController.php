<?php

namespace App\Http\Controllers;

use App\Models\Bin;
use App\Models\Card;
use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $myActiveCards = Card::where('user_id', Auth::id())->where('state', 1)->get();

        // Calculate total amount spent this month of this user by summing up all the cards transactions of this user
        $amountSpentThisMonth = Transaction::where('user_id', Auth::id())
            ->where('type', 'consume')
            ->whereBetween('recordTime', [now()->startOfMonth(), now()->endOfMonth()])
            ->sum('amount');

        // one time card count of this user
        $oneTimeCardsCount = Card::where('user_id', Auth::id())
            ->where('type', 'onetime')
            ->where('state', 1) // only count active one-time cards
            ->count();

        // reloadable card count of this user
        $reloadableCardsCount = Card::where('user_id', Auth::id())
            ->where('type', 'reloadable')
            ->where('state', 1) // only count active reloadable cards
            ->count();

        // last transaction amount of this user
        $lastTransactionAmount = Transaction::where('user_id', Auth::id())
            ->orderBy('recordTime', 'desc')
            ->value('amount');

        // last transaction time of this user to show how long ago the last transaction was made
        $lastTransactionTime = Transaction::where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->value('created_at');

        $myCards = Card::where('user_id', Auth::id())->get();

        $bins = Bin::all();
        $organizations = $bins->pluck('organization')->unique();

        return view('dashboard/dashboard', compact(
            'myActiveCards',
            'amountSpentThisMonth',
            'oneTimeCardsCount',
            'reloadableCardsCount',
            'lastTransactionAmount',
            'lastTransactionTime',
            'myCards',
            'bins',
            'organizations',
        ));
    }


    public function settings()
    {
        return view('dashboard.settings');
    }

    public function notifications()
    {
        $notifications = Auth::user()->notifications()->latest()->get();
        // count unread notifications of this user
        $unreadNotificationsCount = Auth::user()->notifications()->where('is_read', false)->count();
        return view('dashboard.notifications', compact('notifications', 'unreadNotificationsCount'));
    }

    public function mark_as_read(Request $request, $id)
    {
        Auth::user()->notifications()->where('id', $id)->update(['is_read' => true]);

        return redirect()->route('notifications');
    }
}
