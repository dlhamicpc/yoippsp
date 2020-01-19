<?php

namespace App\Http\Controllers\API\InnerWebsite;

use App\Models\InnerWebsite\BillPaymentPost;
use App\Events\InnerWebsite\BillPaymentPostedEvent;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BillPaymentPostController extends Controller
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
        $data = $this->validate_start_accepting_money($request);

        $this->check_if_posts_already_created( $data['payment_of_month'], $data['payment_of_year'] );
        $this->check_given_data_exist_in_bill_payment_database( $data );
        
        $billPaymentPost = BillPaymentPost::create($data);
        
        if( $billPaymentPost->id ){
            event( new BillPaymentPostedEvent( $billPaymentPost ));
            return $billPaymentPost;
        }
        else{
            return abort(500, 'UNKNOWN_ERROR');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\InnerWebsite\BillPaymentPost  $billPaymentPost
     * @return \Illuminate\Http\Response
     */
    public function show(BillPaymentPost $billPaymentPost)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\InnerWebsite\BillPaymentPost  $billPaymentPost
     * @return \Illuminate\Http\Response
     */
    public function edit(BillPaymentPost $billPaymentPost)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\InnerWebsite\BillPaymentPost  $billPaymentPost
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, BillPaymentPost $billPaymentPost)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\InnerWebsite\BillPaymentPost  $billPaymentPost
     * @return \Illuminate\Http\Response
     */
    public function destroy(BillPaymentPost $billPaymentPost)
    {
        //
    }

    private function validate_start_accepting_money($request)
    {
        $startEndDate = $this->split_date_interval( $request->date_range_picker );

        $request['date_range_picker'] = $this->fix_date( $startEndDate[0] ); 
        $startDate = $request->validate([
            'date_range_picker' => ['bail', 'required', 'date']
        ]);
        
        $request['date_range_picker'] = $this->fix_date( $startEndDate[1] );
        $endDate = $request->validate([
            'date_range_picker' => ['bail', 'required', 'date']
        ]);

        $thisYear = (int) date('Y');
        $data = $request->validate([
            'payment_of_month' => ['bail', 'required', 'integer', 'min:1', 'max:12'],
            'payment_of_year' => ['bail', 'required', 'integer', 'min:2000', "max:$thisYear"],
        ]);

        $data['payment_start_on'] = $startDate['date_range_picker'];
        $data['payment_end_on'] = $endDate['date_range_picker'];
        $data['bill_payment_user_id'] = auth()->user()->bill_payment_user->id;

        return $data;
    }

    private function split_date_interval( $fullDate )
    {
        return explode('-', $fullDate);
    }

    private function fix_date( $date )
    {
        $month_day_year = explode('/', trim($date) );
        return $month_day_year[2].'-'.$month_day_year[0].'-'.$month_day_year[1];
    }

    private function check_if_posts_already_created( $month, $year )
    {
        $billPaymentPost = BillPaymentPost::where([
            'payment_of_month' => $month,
            'payment_of_year' => $year
        ])->get();

        if( !$billPaymentPost->isEmpty() ){
            return abort(403, 'POST_ALREADY_EXIST');
        }
    }

    //external
    private function check_given_data_exist_in_bill_payment_database( $data )
    {
        //dd($this->get_bill_payment_provider_database_connection_name( auth()->user()->bill_payment_user->bill_payment_name ));
        $exist = DB::connection( 
            $this->get_bill_payment_provider_database_connection_name( auth()->user()->bill_payment_user->bill_payment_name )
            )->table('bill_payment_post')->where([
            'month' => $data['payment_of_month'],
            'year' => $data['payment_of_year']
        ])->get();
        
        //dump()

        if( $exist->isEmpty() ){
            abort(500, 'INFORMATION_NOT_FOUND');
        }
    }

    private function get_bill_payment_provider_database_connection_name( $billPaymentProviderName )
    {
        $billPaymentProviderToLower = strtolower($billPaymentProviderName);
        $billPaymentProviderSlugged = join( '_', explode( ' ', $billPaymentProviderToLower ) );
        return 'external_database_bill_payment_provider_'.$billPaymentProviderSlugged;
    }

    
}
