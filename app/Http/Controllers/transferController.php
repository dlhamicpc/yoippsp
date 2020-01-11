<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Customer;
class transferController extends Controller
{
    public function check()
    {
        $data = request()->validate([
            'Sender_Name'=>'required',
            'Reciever_Name'=>'required',
            'sender_id'=>'required',
            'reciever_id'=>'required',
            'money'=>'numeric|min:25',

        ]);
        $transferd_money = request('money');
        $sender_id = request('sender_id');
        $reciever_id = request('reciever_id');
        $customer_sender = Customer::where('id',$sender_id)->get();
        $customer_reciever = Customer::where('id',$reciever_id)->get();
        $len = count($customer_reciever);
        $len2 = count($customer_sender);
        if($len==0 || $len2==0){
            return redirect('transfer')->with('account_error','there is no customer with this id check your input');
        }
        else{
            return view('teller/transfer/check',compact('customer_sender','customer_reciever','transferd_money'));
        }
    }
    public function update()
    {
        $data = request()->validate([
            'Sender_Name'=>'required',
            'Reciever_Name'=>'required',
            'sender_id'=>'required',
            'reciever_id'=>'required',
            'money'=>'numeric|min:25',

        ]);
        $money = request('money');
        $sender_id = request('sender_id');
        $reciever_id = request('reciever_id');
        $sender = Customer::where('id',$sender_id)->get();
        $reciever = Customer::where('id',$reciever_id)->get();
       $sender_balance=$sender['0']['balance'];
       $reciver_balance=$reciever['0']['balance'];
       $sender_balance -=$money;
       $reciver_balance +=$money;
       $sender['0']['balance']=$sender_balance;
       $sender['0']->save();
       $reciever['0']['balance']=$reciver_balance;
       $reciever['0']->save();
       return redirect('transfer')->with('successTransfer','money success fully transfered');
       
    }
}
