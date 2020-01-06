<?php

namespace App\Http\Controllers\API\InnerWebsite;

use App\Models\InnerWebsite\UserCardLink;
use App\Models\InnerWebsite\Bank;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserCardLinkController extends Controller
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
        if( $this->link_card( $data ) ){

            //Upon Successful linkage
            return 'success';

        }
        else{
            return 'failed';
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\InnerWebsite\UserCardLink  $userCardLink
     * @return \Illuminate\Http\Response
     */
    public function show(UserCardLink $userCardLink)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\InnerWebsite\UserCardLink  $userCardLink
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $userCardLink = UserCardLink::findOrFail($id);

        if( $userCardLink->user_id == auth()->user()->id ){
            $data = $this->validate_data_for_update($request, $id);
            //IF DATA IS VALID
            if( $this->update_card( $data, $userCardLink ) ){

                //Upon Successful linkage
                return 'success';

            }
            else{
                return 'failed';
            }
        }
        else{
            return 'failed';
        }


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\InnerWebsite\UserCardLink  $userCardLink
     * @return \Illuminate\Http\Response
     */
    public function destroy( $id )
    {
        $userCardLink = UserCardLink::findOrFail($id);

        if( $userCardLink->user_id == auth()->user()->id ){
            $userCardLink->delete();
        }
        else{
            return 'failed';
        }

    }



    ////////////////  HELPER FUNCTIONS //////////////////////////

    private function validate_data(Request $request)
    {
        if( strlen($request['card_number']) == 16 ){
          $request['card_number'] = rtrim( chunk_split($request['card_number'],4,"-"), '-' );
        }

        return $request->validate([
            'bank_name' => 'required|numeric|exists:banks,id',
            'type' => "required",
            'card_number' => "required|string|min:16|max:19|unique:user_card_links,card_number",
            'expire_date' => "required|string",
            'cvv' => "required|string|min:3|max:3",
            'holder_name' => "required|string"
        ]);
    }

    private function validate_data_for_update(Request $request, $id)
    {
        if( strlen($request['card_number']) == 16 ){
          $request['card_number'] = rtrim( chunk_split($request['card_number'],4,"-"), '-' );
        }

        return $request->validate([
            'bank_name' => 'required|numeric|exists:banks,id',
            'type' => "required",
            'card_number' => "required|string|min:16|max:19|unique:user_card_links,card_number,".$id,
            'expire_date' => "required|string",
            'cvv' => "required|string|min:3|max:3",
            'holder_name' => "required|string"
        ]);
    }



    private function link_card( $data )
    {
        $data = $this->merge_data ( $data );
        return UserCardLink::create($data);
    }

    private function update_card( $data, $userCardLink )
    {
        $data = $this->merge_data ( $data );
        return $userCardLink->update($data);
    }

    private function update_front_end_data()
    {
       return UserCardLink::where( 'user_id', auth()->user()->id )->get();

    }

    private function merge_data( $data )
    {
           return array_merge( $data, [
            'user_id' => auth()->user()->id,
            'bank_id' => $data['bank_name'],
        ]);
    }







}
