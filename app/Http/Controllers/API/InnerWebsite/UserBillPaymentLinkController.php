<?php

namespace App\Http\Controllers\API\InnerWebsite;

use App\Models\InnerWebsite\UserBillPaymentLink;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserBillPaymentLinkController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
     * @param  \App\Models\InnerWebsite\UserBillPaymentLink  $userBillPaymentLink
     * @return \Illuminate\Http\Response
     */
    public function show(UserBillPaymentLink $userBillPaymentLink)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\InnerWebsite\UserBillPaymentLink  $userBillPaymentLink
     * @return \Illuminate\Http\Response
     */
    public function edit(UserBillPaymentLink $userBillPaymentLink)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\InnerWebsite\UserBillPaymentLink  $userBillPaymentLink
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, UserBillPaymentLink $userBillPaymentLink)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\InnerWebsite\UserBillPaymentLink  $userBillPaymentLink
     * @return \Illuminate\Http\Response
     */
    public function destroy(UserBillPaymentLink $userBillPaymentLink)
    {
        //
    }

    ///////////////////// PAYMENT LINK HANDLER/////////////////////////////

    private function check_if_user_linked_payment_info_before( $billPaymentLink )
    {
        return $billPaymentLink->isEmpty() ? false:true;
    }

    private function get_user_bill_payment_link(  $bill_payment_id )
    {
        return UserBillPaymentLink::where([
            'user_id' => auth()->user()->id,
            'bill_payment_id' => $bill_payment_id
        ])->get();
    }


    //////////////////-----WATER-----/////////////////////////

    public function update_water_payment_info(Request $request)
    {
        $data = $this->validate_water_payment_info( $request );

        $waterPaymentLink = $this->get_user_bill_payment_link( $data['water_service_provider'] );
        
        if( $this->check_if_user_linked_payment_info_before( $waterPaymentLink ) ) {
            $waterPaymentLink = $waterPaymentLink->first();
            $result = $waterPaymentLink->update( [ 
                'bill_payment_id' => $data['water_service_provider'],
                'user_payment_identification' => $data['water_payment_identification']
            ]);

            if( $result ) {
                return $waterPaymentLink;
            }
            return 'failed';
        }
        else{

            try {
                $newWaterPaymentLink = UserBillPaymentLink::create([
                    'user_id' => auth()->user()->id,
                    'bill_payment_id' => $data['water_service_provider'],
                    'user_payment_identification' => $data['water_payment_identification'],
                    'type' => 0,
                ]);
    
                return $newWaterPaymentLink;
            } catch (\Throwable $th) {
                return 'failed';
            }
            
        }
        
    }

    private function validate_water_payment_info( $request )
    {
        return $request->validate([
            'water_service_provider'      => [
                'bail', 'required', 'integer', 'exists:bill_payment_users,id'
            ],
            'water_payment_identification'      => [
                'bail', 'required',
            ],
        ]);

    }




    public function update_electricity_payment_info(Request $request)
    {
        $data = $this->validate_electricity_payment_info( $request );

        $electricityPaymentLink = $this->get_user_bill_payment_link( $data['electricity_service_provider'] );
        
        if( $this->check_if_user_linked_payment_info_before( $electricityPaymentLink ) ) {
            $electricityPaymentLink = $electricityPaymentLink->first();
            $result = $electricityPaymentLink->update( [ 
                'bill_payment_id' => $data['electricity_service_provider'],
                'user_payment_identification' => $data['electricity_payment_identification']
            ]);

            if( $result ) {
                return $electricityPaymentLink;
            }
            return 'failed';
        }
        else{

            try {
                $newElectricityPaymentLink = UserBillPaymentLink::create([
                    'user_id' => auth()->user()->id,
                    'bill_payment_id' => $data['electricity_service_provider'],
                    'user_payment_identification' => $data['electricity_payment_identification'],
                    'type' => 1,
                ]);
    
                return $newElectricityPaymentLink;
            } catch (\Throwable $th) {
                return 'failed';
            }
            
        }
        
    }

    private function validate_electricity_payment_info( $request )
    {
        return $request->validate([
            'electricity_service_provider'      => [
                'bail', 'required', 'integer', 'exists:bill_payment_users,id'
            ],
            'electricity_payment_identification'      => [
                'bail', 'required',
            ],
        ]);

    }



    public function update_dstv_payment_info(Request $request)
    {
        $data = $this->validate_dstv_payment_info( $request );

        $dstvPaymentLink = $this->get_user_bill_payment_link( $data['dstv_service_provider'] );
        
        if( $this->check_if_user_linked_payment_info_before( $dstvPaymentLink ) ) {
            $dstvPaymentLink = $dstvPaymentLink->first();
            $result = $dstvPaymentLink->update( [ 
                'bill_payment_id' => $data['dstv_service_provider'],
                'user_payment_identification' => $data['dstv_payment_identification']
            ]);

            if( $result ) {
                return $dstvPaymentLink;
            }
            return 'failed';
        }
        else{

            try {
                $newDstvPaymentLink = UserBillPaymentLink::create([
                    'user_id' => auth()->user()->id,
                    'bill_payment_id' => $data['dstv_service_provider'],
                    'user_payment_identification' => $data['dstv_payment_identification'],
                    'type' => 2,
                ]);
    
                return $newDstvPaymentLink;
            } catch (\Throwable $th) {
                return 'failed';
            }
            
        }
        
    }

    private function validate_dstv_payment_info( $request )
    {
        return $request->validate([
            'dstv_service_provider'      => [
                'bail', 'required', 'integer', 'exists:bill_payment_users,id'
            ],
            'dstv_payment_identification'      => [
                'bail', 'required',
            ],
        ]);

    }


    public function delete_bill_payment_link(Request $request)
    {
        $id = $this->validate_delete_bill_payment_link( $request );
        if( UserBillPaymentLink::destroy($id) ){
            return 'deleted';
        }
        else{
            abort(401);
        }  

    }

    private function validate_delete_bill_payment_link( $request )
    {
        return $request->validate([
            'link_id' => ['bail', 'required', 'integer', 'exists:user_bill_payment_links,id']
        ]);
    }










}
