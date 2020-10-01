<?php

namespace App\Http\Controllers\Api\Order;

use App\Entities\Order\UserOrderItem;
use App\Http\Controllers\Controller;
use Dingo\Api\Routing\Helpers;
use Illuminate\Http\Request;

class UserOrderItemController extends Controller
{
    use Helpers;
    protected $model;
    public function __construct(UserOrderItem $model)
    {
        $this->model = $model;
        // $this->middleware('permission:List user order item')->only('index');
        // $this->middleware('permission:List user order item')->only('show');
        // $this->middleware('permission:Create user order item')->only('store');
        // $this->middleware('permission:Update user order item')->only('update');
        // $this->middleware('permission:Delete user order item')->only('destroy');
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
     * @param  \App\Entities\Order\UserOrderItem  $userOrderItem
     * @return \Illuminate\Http\Response
     */
    public function show(UserOrderItem $userOrderItem)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Entities\Order\UserOrderItem  $userOrderItem
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, UserOrderItem $userOrderItem)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Entities\Order\UserOrderItem  $userOrderItem
     * @return \Illuminate\Http\Response
     */
    public function destroy(UserOrderItem $userOrderItem)
    {
        //
    }
}
