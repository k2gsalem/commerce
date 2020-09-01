<?php

namespace App\Http\Controllers\Api\CartManager;

use App\Entities\CartManager\CartItemVariant;
use App\Entities\Catalogue\ItemVariant;
use App\Http\Controllers\Controller;
use Dingo\Api\Routing\Helpers;
use Illuminate\Http\Request;

class CartItemVariantController extends Controller
{
    use Helpers;
    protected $model;

    public function __construct(CartItemVariant $model)
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

        $rules = [
            'cart_item_id' => 'required|integer|exists:cart_items,id',
            'item_id' => 'required|integer|exists:items,id',
            'item_quantity' => 'required|integer',
            'variant_group_id' => 'required|integer|exists:item_variant_groups,id',
        ];

        $this->validate($request, $rules);

        $itemvariant = ItemVariant::findOrFail($request->item_variant_id);
        $request['cart_item_id'] = $request->cart_item_id;
        $request['item_id'] = $itemvariant->item_id;
        $request['variant_group_id'] = $itemvariant->variant_group_id;
        $request['item_selling_price'] = $itemvariant->selling_price;
        $request['item_discount_percentage'] = $itemvariant->discount_percentage;
        $request['item_discount_amount'] = $itemvariant->discount_amount;
        $request['item_quantity'] = $request->item_quantity;
        $request['vendor_store_id'] = $itemvariant->vendor_store_id;
        $request['status_id'] = $itemvariant->status_id;
        $request['created_by'] = $request->user()->id;
        $request['updated_by'] = $request->user()->id;

        $cartitemvariant = $this->model->create($request->all());
        return $cartitemvariant;
        // return $this->response->created(url('api/cartItemVariant/' . $cartitemvariant->id));
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Entities\CartManager\CartItemVariant  $cartItemVariant
     * @return \Illuminate\Http\Response
     */
    public function show(CartItemVariant $cartItemVariant)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Entities\CartManager\CartItemVariant  $cartItemVariant
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, CartItemVariant $cartItemVariant)
    {
        
        $cartItemVariant->item_quantity = $request['quantity'];
        //return $request->user()->id;
        $request['updated_by'] = $request->user()->id;
        if ($cartItemVariant->item_quantity >= 1) {
            $cartItemVariant->update($request->except('created_by'));
        } else {
            $cartItemVariant->delete();
            $cartItemVariant->cartItem()->delete();
        }

        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Entities\CartManager\CartItemVariant  $cartItemVariant
     * @return \Illuminate\Http\Response
     */
    public function destroy(CartItemVariant $cartItemVariant)
    {
        //
    }
}