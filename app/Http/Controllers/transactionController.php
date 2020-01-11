<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Transaction;
class transactionController extends Controller
{
    //
    public function check()
    {
        $find_for = request('search');
        $result = Transaction::where('id',$find_for)->get();
        return view('teller/transaction/showResult',compact('result'));
    }
    public function show()
    {
       $transactions = Transaction::all()->paginate('5');
       return redirect('transaction')->with([
           'transactions' => $transactions,
       ]);
    }
}
