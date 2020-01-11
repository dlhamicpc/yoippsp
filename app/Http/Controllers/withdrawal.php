<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Customer;
class withdrawal extends Controller
{

    public function list()
    {
        $data =  request()->validate([
            'id_number'=> 'required',
            'amount'=>'numeric|min:45',
        ]);
        $id = request('id_number');
        $name = request('username');
        $amount = request('amount');
        $person = Customer::where('id',$id)->get();
        $length = count($person);
        if($length==0){
            return redirect('withdrawal')->with('noAccount','there is no customer with this id \n check your input');
        }
        $balance = $person['0']['balance'];
        $current_balance = $balance-$amount;
        if($current_balance <= 50){
            return redirect('withdrawal')->with('balanceError','insufficient balane');
        }
        else{
            return view('teller/withdrawal/checkForAccount',compact('person','amount'));
        }
    }
    public function update()
    {
        $id = request('id_number');
        $cur_balance = request('balance');
        $cus = Customer::where('id',$id)->get();
        $cus['0']['balance']=$cur_balance;
        $cus['0']->update();
        return redirect('withdrawal')->with('withSuccess','withdrawal successfuly ...');
    }
}
