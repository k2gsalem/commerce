<?php

namespace App\Http\Controllers\Api\CartManager;

use App\Entities\CartManager\Cart;
use App\Entities\CartManager\CartItem;
use App\Entities\User;
use App\Http\Controllers\Controller;
use Dingo\Api\Routing\Helpers;
use Illuminate\Http\Request;

class AddToCartController extends Controller
{
    use Helpers;
    protected $model;
    public function __construct(Cart $model)
    {
        $this->model = $model;
        // $this->middleware('permission:List item')->only('index');
        // $this->middleware('permission:List item')->only('show');
        // $this->middleware('permission:Create item')->only('store');
        // $this->middleware('permission:Update item')->only('update');
        // $this->middleware('permission:Delete item')->only('destroy');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    // public function index(Request $request)
    // {

    // }

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
     * @param  \App\Entities\CartManager\Cart  $cart
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
       
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Entities\CartManager\Cart  $cart
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Cart $cart)
    {
        //return $request['item_id'];
        $request['created_by'] = $request->user()->id;
        $request['updated_by'] = $request->user()->id;
        if ($request->variant_group_id === null) {
            $rules = [                
                'item_id' => 'required|integer|exists:items,id',
                'status_id' => 'required|integer|exists:conf_statuses,id',
            ];
        } else {
            $rules = [                
                'item_variant_id' => 'required|integer|exists:items_variants,id',
                'status_id' => 'required|integer|exists:conf_statuses,id',
            ];
        }

        $this->validate($request, $rules);
        if ($request->variant_group_id === null) {
            $cartitem = $this->api->post('api/cartItem',['cart_id'=>$cart->id,'item_id'=>$request['item_id']]);
        }
        // else{
            
        // }
        return $this->response($cart->fresh());
       // return $this->response->item($cart->fresh(), new ItemTransfomer());
       
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Entities\CartManager\Cart  $cart
     * @return \Illuminate\Http\Response
     */
    public function destroy(Cart $cart)
    {
        //
    }
}
