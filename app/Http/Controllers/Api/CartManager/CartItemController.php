<?php

namespace App\Http\Controllers\Api\CartManager;

use App\Entities\CartManager\CartItem;
use App\Entities\CartManager\CartItemVariant;
use App\Entities\Catalogue\Item;
use App\Http\Controllers\Controller;
use Dingo\Api\Routing\Helpers;
use Illuminate\Http\Request;

class CartItemController extends Controller
{
    use Helpers;
    protected $model;

    public function __construct(CartItem $model)
    {
        $this->model = $model;
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
        return $request;
        
        if ($request['variant_group_id'] === null) {
            $rules = [
                'cart_id' => 'required|integer|exists:carts,id',
                'item_id' => 'required|integer|exists:items,id',
                'quantity' => 'required|integer',
            ];
        } else {
            $rules = [
                'cart_id' => 'required|integer|exists:carts,id',
                'item_id' => 'required|integer|exists:items,id',
                'quantity' => 'required|integer',
                'variant_id' => 'required|integer|exists:item_variants,id',
                'variant_group_id' => 'required|integer|exists:item_variant_groups,id',
            ];
        }

        $this->validate($request, $rules);
        $item = Item::findOrFail($request['item_id']);

        $request['cart_id'] = $request['cart_id'];
        $request['item_id'] = $request['item_id'];
     //   $request['variant_group_id'] = $item->variant_group_id;
        $request['item_selling_price'] = $item->selling_price;
        $request['item_discount_percentage'] = $item->discount_percentage;
        $request['item_discount_amount'] = $item->discount_amount;
        $request['item_quantity'] = $request['quantity'];
        $request['vendor_store_id'] = $item->vendor_store_id;
        $request['status_id'] = $item->status_id;
        $request['created_by'] = $request->user()->id;
        $request['updated_by'] = $request->user()->id;
        
        if ($request['variant_group_id'] === null) {
            $cartitem = $this->model->create($request->except('variant_group_id','variant_id'));
           // return $cartitem;
        } else {
            //return $request;
            $cartitem = $this->model->create($request->except('variant_id'));
         //  return $request;
            $cartitemvariant = $this->api->post('api/cart/cartItemVariant', [
                
                'cart_item_id' => $cartitem->id,
                'item_id' => $request['item_id'],
                'item_variant_id' => $request['variant_id'],
                'variant_group_id' => $request['variant_group_id'],
                'item_quantity' => $request['quantity'],

            ]);
                //return $cartitemvariant;
        }

       // return $this->response->created(url('api/cartItem/' . $cartitem->id));

        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Entities\CartManager\CartItem  $cartItem
     * @return \Illuminate\Http\Response
     */
    public function show(CartItem $cartItem)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Entities\CartManager\CartItem  $cartItem
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, CartItem $cartItem)
    {
        if ($request->variant_group_id === null) {
            $cartItem->item_quantity = $request['quantity'];
            $request['updated_by'] = $request->user()->id;
            if ($cartItem->item_quantity >= 1) {
                $cartItem->update($request->except('created_by'));
            } else {
                $cartItem->delete();
            }
        } else {
            
           $item_variant_id= CartItemVariant::where('cart_item_id',$cartItem->id)->first()->id;
         //  return  $item_variant_id;
         //   $item_id = $cartItem->where('variant_id', $request['variant_id'])->first()->id;
            //$cartItem->cartItemVariants;
            //$itemvariant_id = $cart->cartItem->where('item_id', $request['item_id'])->first()->id;
            $cartitemvariant = $this->api->put('api/cart/cartItemVariant/' . $item_variant_id, [
                'quantity' => $request['quantity'],
                'variant_group_id' => $request['variant_group_id'],
                'variant_id' => $request['variant_id'],
            ]);
        //    return $cartitemvariant;
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Entities\CartManager\CartItem  $cartItem
     * @return \Illuminate\Http\Response
     */
    public function destroy(CartItem $cartItem)
    {
        //
    }
}
