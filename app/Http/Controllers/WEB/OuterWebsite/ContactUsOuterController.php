<?php

namespace App\Http\Controllers\WEB\OuterWebsite;

use App\Models\OuterWebsite\ContactUsOuter;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class ContactUsOuterController extends Controller
{
    public function __construct(){

        //checking for honey pot /spam bot
        if( request()->new_email ){
            /**
             * ######### ADD the ip to Ip bannlist table
             */
            return back()->with('message', 'Message sent successfully.');
        }
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate(ContactUsOuter::$rules, ContactUsOuter::$messages);

        $request->merge([
            'email' => $request->contact_email,
            'ip' => $request->ip(),
            'device_info' => $request->server('HTTP_USER_AGENT'),
            'sent_at' => Carbon::now()->format('Y-m-d h:m:i'),
        ]);
        
        ContactUsOuter::create($request->all());

        return back()->with('message', 'Message sent successfully.');
    }    


}
