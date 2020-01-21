<?php

namespace App\Http\Controllers;

use App\Models\TimeZone;
use Illuminate\Http\Request;

class TimeZoneController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return TimeZone::get(['name']);
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
     * @param  \App\Models\TimeZone  $timeZone
     * @return \Illuminate\Http\Response
     */
    public function show(TimeZone $timeZone)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\TimeZone  $timeZone
     * @return \Illuminate\Http\Response
     */
    public function edit(TimeZone $timeZone)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\TimeZone  $timeZone
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, TimeZone $timeZone)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\TimeZone  $timeZone
     * @return \Illuminate\Http\Response
     */
    public function destroy(TimeZone $timeZone)
    {
        //
    }
}
