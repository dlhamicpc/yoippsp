<?php

namespace App\Http\Controllers\API\InnerWebsite;

use App\Models\InnerWebsite\UserBankLink;
use App\Models\InnerWebsite\Bank;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserBankLinkController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Bank::get(['id', 'bank_name']);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $this->validate_data($request);

        //IF DATA IS VALID
        if( $this->link_bank( $data ) ){

            //Upon Successful linkage
            return 'success';

        }
        else{
            return 'failed';
        }

    }



    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\InnerWebsite\UserBankLink  $UserBankLink
     * @return \Illuminate\Http\Response
     */
    public function destroy( $id )
    {
        $UserBankLink = UserBankLink::findOrFail($id);

        if( $UserBankLink->user_id == auth()->user()->id ){
            $UserBankLink->delete();
        }
        else{
            return 'failed';
        }

    }



    ////////////////  HELPER FUNCTIONS //////////////////////////

    private function validate_data(Request $request)
    {
        return $request->validate([
            'bank_name' => 'required|numeric|exists:banks,id',
            'account_number' => 'required|string|unique:user_bank_links,account_number',
            'book_number' => 'required|string|unique:user_bank_links,book_number',
            'full_name' => 'required|string',
            'confirm'   => 'required',
        ]);
    }


    private function link_bank( $data )
    {
        $data = $this->merge_data ( $data );
        return UserBankLink::create($data);
    }

    private function merge_data( $data )
    {
           return array_merge( $data, [
            'user_id' => auth()->user()->id,
            'bank_id' => $data['bank_name'],
        ]);
    }







}
