<?php

namespace App\Http\Controllers;

use Exception;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Rules\WithdrawalRequest;

class WithdrawalController extends Controller
{
    public function show()
    {
        $data = Transaction::with('user')
            ->where('transaction_type', '=', 'withdrawal')
            ->get();
        return view('withdrawal.index', ['data' => $data]);
    }

    public function create()
    {
        return view('withdrawal.create');
    }

    public function store(WithdrawalRequest $request)
    {
        $user = Auth::user();
        $monthly_withdrawal = Transaction::with('user')
            ->where('user_id', $request->user_id)
            ->whereMonth('date', Carbon::now()->month)
            ->where('transaction_type', 'withdrawal')
            ->sum('amount');
        $total_amount = Transaction::with('user')
            ->where('user_id', $request->user_id)
            ->where('transaction_type', 'withdrawal')
            ->sum('amount');
        $balance_charge = 0;
        try {
            $data = $request->validated();
            if (!$user->balance == 0) {
                //Individual withdrawal condition
                if ($user->account_type == User::ACCOUNT_TYPE[0] && ($request->amount < $user->balance)) {
                    if (Carbon::now()->format('l') == 'Friday' || $request->amount <= 1000 || $monthly_withdrawal <= 5000) {
                        $user->balance = $user->balance - $request->amount;
                    } elseif ($request->amount > 1000) {
                        $remaining_amount = $request->amount - 1000;
                        $balance_charge = $remaining_amount * 0.015;  //Individual withdrawal rate (0.015);
                        if ($balance_charge > $user->balance) {
                            return redirect()->route('withdrawal.create')->with('error', "Infufficient balance");
                        }
                        $user->balance = ($user->balance - $request->amount - $remaining_amount);
                    }
                }
                //Business withdrawal condition
                elseif ($user->account_type == User::ACCOUNT_TYPE[1] && ($request->amount < $user->balance)) {
                    if ($total_amount > 50000) {
                        $balance_charge = $request->amount * 0.015;
                        if (($request->amount + $balance_charge) > $user->balance) {
                            return redirect()->route('withdrawal.create')->with('error', "Infufficient balance");
                        }
                        $user->balance = $user->balance - $balance_charge;
                    } else {
                        $balance_charge = $request->amount * 0.025; //Business withdrawal rate (0.025)
                        if (($request->amount + $balance_charge) > $user->balance) {
                            return redirect()->route('withdrawal.create')->with('error', "Couldn't withdraw,balance is low");
                        }
                        $user->balance = $user->balance - $balance_charge;
                    }
                } else {
                    return redirect()->route('withdrawal.create')->with('error', "Infufficient balance");
                }
            }
            $user->save();
            $data = [
                'user_id' => Auth::user()->id,
                'amount' => $request->amount,
                'transaction_type' => 'withdrawal',
                'fee' => $balance_charge,
                'date' => Carbon::now(),
            ];
            Transaction::create($data);
            return redirect()->route('withdrawal.create')->with('success', 'The withdrawal is successfully.');
        } catch (Exception $e) {
            return redirect()->route('withdrawal.create')->with('error', $e->getMessage());
        }
    }
}
