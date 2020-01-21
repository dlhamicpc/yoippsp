<?php

namespace App\Http\Controllers\API\InnerWebsite;

use App\Models\InnerWebsite\Deposit;
use App\Models\InnerWebsite\UserBankLink;
use App\Models\InnerWebsite\UserCardLink;
use App\Models\InnerWebsite\Bank;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DepositController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user_id = auth()->user()->id;
        $userBankLinks = UserBankLink::where(['user_id' => $user_id ])->where(['approved' => 'yes'])->get();
        $userCardLinks = UserCardLink::where(['user_id' => $user_id ])->where(['approved' => 'yes'])->get();
        $banks = Bank::get();

        $card_bank_link = [
            'card_links' => $userCardLinks ,
            'bank_links' => $userBankLinks,
            'banks'      => $banks,
        ];

        return $card_bank_link;

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\InnerWebsite\Deposit  $deposit
     * @return \Illuminate\Http\Response
     */
    public function show(Deposit $deposit)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\InnerWebsite\Deposit  $deposit
     * @return \Illuminate\Http\Response
     */
    public function edit(Deposit $deposit)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\InnerWebsite\Deposit  $deposit
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Deposit $deposit)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\InnerWebsite\Deposit  $deposit
     * @return \Illuminate\Http\Response
     */
    public function destroy(Deposit $deposit)
    {
        //
    }
}
