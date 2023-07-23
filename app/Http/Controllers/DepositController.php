<?php

namespace App\Http\Controllers;

use Exception;
use Carbon\Carbon;
use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Rules\DepositRequest;

class DepositController extends Controller
{
    public function show()
    {
        $data = Transaction::with('user')
            ->where('transaction_type', '=', 'deposit')
            ->get();
        return view('deposit.index', ['data' => $data]);
    }
    public function create()
    {
        return view('deposit.create');
    }

    public function store(DepositRequest $request)
    {
        try {
            $data = $request->validated();
            $user = Auth::user();
            $user->balance = $user->balance + $request->amount;
            $user->save();
            $data = [
                'user_id' => Auth::user()->id,
                'amount' => $request->amount,
                'transaction_type' => 'Deposit',
                'fee' => 0.00,
                'date' => Carbon::now(),
            ];
            Transaction::create($data);
            return redirect()->route('deposit.create')->with('success', 'The deposit is created.');
        } catch (Exception $e) {
            return redirect()->route('deposit.create')->with('error', $e->getMessage());
        }
    }
}
