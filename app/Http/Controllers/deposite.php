<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Customer;
use App\transaction;
class deposite extends Controller
{
    public function show()
    {
        $data = request()->validate([
            'required_money'=>'numeric|min:20',
            'id_number'=>'required|numeric',
            'username'=> 'required',
        ]);

        $account = request('id_number');
        $money = request('required_money');
        $persons = Customer::where('id',$account)->get();
        $len = count($persons);
        if ($len == 0) {
            return redirect('deposite')->with('invalidId','there is no customer with this id ');
        }
            return view('teller/deposite/checkForAccount',compact('persons','money'));
    }
    public function showkak()
    {
        $account = request('account_number');
        $money = request('required_money');
        $persons = Customer::where('id',$account)->get();
        return view('teller/deposite/checkForAccount',compact('persons'));
    }
    public function store()
    {

        $data = request()->validate([
            'id_number'=>'required',
            'balance'=>'numeric|min:5',
        ]);

        
        
        
        $new = request('balance');
        $id = request('id_number');
        $cus = Customer::where('id',$id)->get();
        $pre = $cus['0']['balance'];
        $current = $pre + $new;

        $trans = new Transaction();
        $trans->transaction_type = 'deposite';
        $trans->from = request('id_number');
        $trans->to = '2';
        $trans->save();
        $cus['0']['balance'] = $current;
        $cus['0']->save();
        return redirect('deposite')->with('success','Deposite is seccessfully applieds');
    }
}
