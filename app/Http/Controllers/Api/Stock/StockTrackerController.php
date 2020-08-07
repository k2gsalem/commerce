<?php

namespace App\Http\Controllers\Api\Stock;

use App\Entities\Stock\StockTracker;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class StockTrackerController extends Controller
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
     * @param  \App\Entities\Stock\StockTracker  $stockTracker
     * @return \Illuminate\Http\Response
     */
    public function show(StockTracker $stockTracker)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Entities\Stock\StockTracker  $stockTracker
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, StockTracker $stockTracker)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Entities\Stock\StockTracker  $stockTracker
     * @return \Illuminate\Http\Response
     */
    public function destroy(StockTracker $stockTracker)
    {
        //
    }
}
