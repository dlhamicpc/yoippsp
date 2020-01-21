<?php

namespace App\Http\Controllers\WEB\OuterWebsite;

use App\Models\OuterWebsite\Subscriber;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class SubscriberController extends Controller
{

    public function __construct(){

        //checking for honey pot /spam bot
        if( request()->new_email ){
            /**
             * ######### ADD the ip to Ip bannlist table
             */
            return back()->with('message', 'Subscribed successfully.');
        }
    }

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
        $request->validate(Subscriber::$rules, Subscriber::$messages);

        $request->merge([
            'ip' => $request->ip(),
            'device_info' => $request->server('HTTP_USER_AGENT'),
            'subscribed_at' => Carbon::now()->format('Y-m-d h:m:i'),
        ]);
        

        Subscriber::create($request->all());

        return back()->with('message', 'Subscribed successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\OuterWebsite\Subscriber  $subscriber
     * @return \Illuminate\Http\Response
     */
    public function show(Subscriber $subscriber)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\OuterWebsite\Subscriber  $subscriber
     * @return \Illuminate\Http\Response
     */
    public function edit(Subscriber $subscriber)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\OuterWebsite\Subscriber  $subscriber
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Subscriber $subscriber)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\OuterWebsite\Subscriber  $subscriber
     * @return \Illuminate\Http\Response
     */
    public function destroy(Subscriber $subscriber)
    {
        //
    }


}
