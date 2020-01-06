<?php

namespace App\Http\Controllers\API\InnerWebsite\Transaction;

use App\Models\InnerWebsite\WebsitePaymentTransactionTemporary;
use App\Models\InnerWebsite\WebsiteUser;
use App\Models\InnerWebsite\Api;
use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class WebsitePaymentTransactionTemporaryController extends Controller
{

    private $website_user_api_info;
    private $website_user;
    private $errors = array();
    private $response = array('status' => 'failed');
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index( $id )
    {
        $data = $this->check_if_the_data_belong_to_the_payer( $id );
        return view('innerWebsite.gateway.pay.index', $data);
    }

    private function check_if_the_data_belong_to_the_payer( $id )
    {
        $wptt = WebsitePaymentTransactionTemporary::find($id);
        if($wptt == null) {
            abort(404);
        }
        else {
            $website_user = WebsiteUser::where('webhook_url', request()->server('HTTP_REFERER'))->get()->first();

            if( $website_user == null ) {
                abort(404);
            }
            else{
                if( $wptt->website_user_id != $website_user->id ) {
                    abort(404);
                }
                else{
                    return [
                        'website_name' => $website_user->website_name,
                        'website_url' => $website_user->website_url,
                        'amount' => $wptt->amount
                    ];
                }
            }
            
        }
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store_payment_data(Request $request)
    {
        if( !$this->validate_store_payment_data( $request ) ) {
            $this->response['status'] = 'failed';
            $this->response['errors'] = $this->errors;
            return $this->response;
        }

        $wptt = $this->fill_wptt_table( $request );

        if( $wptt->id ) {
            $this->response['status'] = 'success';
            $this->response['data'] = $wptt;
            return $this->response;
        }
        else {

            $this->response['errors'] = [
                'unknown' => 'Unknown error.'
            ];
            return $this->response;

        }

    }

    //website_payemnt_transaction_temporaries (wptt)
    private function fill_wptt_table( $request )
    {
        $this->find_website_user();

        $wptt = new WebsitePaymentTransactionTemporary();
        $wptt->website_user_id = $this->website_user->website_user->id;
        $wptt->website_user_public_key = $this->website_user_api_info->public_key;
        $wptt->payer_ip = $request->payer_ip;
        $wptt->payer_identification = $request->payer_identification;
        $wptt->amount = $request->amount;
        $wptt->metadata = $request->metadata;
        $wptt->save();

        return $wptt;
    }


    private function find_website_user()
    {
        $this->website_user = User::find($this->website_user_api_info->user_id);
    }

    private function validate_store_payment_data( $request )
    {
        $this->validate_private_key( $request );
        $this->validate_payer_ip( $request );
        $this->validate_payer_identification( $request );
        $this->validate_amount( $request );
        $this->validate_metadata( $request );

        if( count($this->errors) > 0 ){
            return false;
        }
        return true;
    }

    private function validate_payer_ip( $request )
    {
        try {
            $request->validate([
                'payer_ip' => ['bail', 'required', 'ip']
            ]);
        } catch (\Throwable $th) {
            $this->errors['payer_ip'] = 'Invalid IP Address.';
        }
    }

    private function validate_payer_identification( $request )
    {
        try {
            $request->validate([
                'payer_identification' => ['bail', 'required', 'string']
            ]);
        } catch (\Throwable $th) {
            $this->errors['payer_identification'] = 'Invalid payer identifier.';
        }
    }

    private function validate_private_key( $request )
    {
        $this->website_user_api_info = Api::where('private_key', $request->private_key)->get()->first();

        if( $this->website_user_api_info == null ){
            $this->errors['private_key'] = 'Private key not found.';
        }
    }

    private function validate_amount( $request )
    {
        try {
            $request->validate([
                'amount' => ['bail', 'required', 'numeric']
            ]);
        } catch (\Throwable $th) {
            $this->errors['amount'] = 'Invalid amount.';
        }
    }

    private function validate_metadata( $request )
    {
        try {
            $request->validate([
                'metadata' => ['bail', 'sometimes']
            ]);
        } catch (\Throwable $th) {
            $this->errors['metadata'] = 'Invalid metadata.';
        }
    }














    /**
     * Return the newly created transaction in for this website user in website_payment_transaction_temporaries.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function get_payment_data(Request $request)
    {
        //
    }

}
