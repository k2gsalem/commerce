<?php

namespace App\Http\Controllers\Api\CartManager;

use App\Entities\CartManager\Cart;
use App\Entities\User;
use App\Http\Controllers\Controller;
use Dingo\Api\Routing\Helpers;
use Illuminate\Http\Request;

class CartController extends Controller
{
    use Helpers;
    protected $model;
    public function __construct(Cart $model)
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
        $request['created_by'] = $request->user()->id;
        $request['updated_by'] = $request->user()->id;
        $rules = [
            'user_id' => 'required|integer|exists:users,id',
            'status_id' => 'required|integer|exists:conf_statuses,id',
        ];
        $this->validate($request, $rules);
        $cart = $this->model->create($request->all());
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Entities\CartManager\Cart  $cart
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        //  return $user;
        // $cart = new Cart();
        // $user_exist = $cart->where('user_id', $user->id)->count();
        // if ($user_exist == 0) {
        //     $user_cart = $this->model->create(['user_id' => $user->id, 'status_id' => 1, 'created_by' => $user->id, 'updated_by' => $user->id]);
        // } else {
        //     $user_cart = $user->cart;
        // }
        // return $this->response->created(url('api/cart/' . $user_cart->id));
        //
    }
    public function fetchCart(User $user)
    {
        //return $user;
        $cart = new Cart();
        $user_exist = $cart->where('user_id', $user->id)->count();
        if ($user_exist == 0) {

            $user_cart = $this->model->create(['user_id' => $user->id, 'status_id' => 1, 'created_by' => $user->id, 'updated_by' => $user->id]);
        } else {
            $user_cart = $user->cart;
        }
        return $user_cart;
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Entities\CartManager\Cart  $cart
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        // if ($user->cart !== null) {
        //     $cart_id = $user->cart->id;
        //     $cart = Cart::find($cart_id);
        // } else {
        //     $cart = $this->model->create(['user_id' => $user->id, 'status_id' => 1, 'created_by' => $user->id, 'updated_by' => $user->id]);
        // }
        $newcart = new Cart();
        $user_exist = $newcart->where('user_id', $user->id)->count();
        if ($user_exist == 0) {
            $cart = $this->model->create(['user_id' => $user->id, 'status_id' => 1, 'created_by' => $user->id, 'updated_by' => $user->id]);
        } else {
            $cart = $user->cart;
        }

        $request['created_by'] = $request->user()->id;
        $request['updated_by'] = $request->user()->id;
        $rules = [
            'item_id' => 'required|integer|exists:items,id',
            'status_id' => 'required|integer|exists:conf_statuses,id',
            'quantity' => 'required|integer',
        ];

        $this->validate($request, $rules);
        if ($request['variant_group_id'] === null) {
            if (count($cart->cartItem->where('item_id', $request['item_id'])) == 0) {

                $cartitem = $this->api->post('api/cartItem', ['cart_id' => $cart->id, 'item_id' => $request['item_id'], 'quantity' => $request['quantity'], 'status_id' => $request['status_id']]);

            } else {
                $item_id = $cart->cartItem->where('item_id', $request['item_id'])->first()->id;
                $cartitem = $this->api->put('api/cartItem/' . $item_id, ['quantity' => $request['quantity']]);
            }
        } else {
            // return $cart->id;

            if (count($cart->cartItem->where('variant_group_id', $request['variant_group_id'])) == 0 && $request['variant_id'] !== null) {
                return $request;
                $cartitem = $this->api->post('api/cartItem', [
                    'cart_id' => $cart->id,
                    'item_id' => $request['item_id'],
                    'quantity' => $request['quantity'],
                    'variant_group_id' => $request['variant_group_id'],
                    'variant_id' => $request['variant_id'],
                    'status_id' => $request['status_id']
                ]);
                // $cartitem = $this->api->post('api/cartItem', [
                //     'cart_id' => $cart->id,
                //     'item_id' => $request['item_id'],
                //     'quantity' => $request['quantity'],
                //     'variant_group_id' => $request['variant_group_id'],
                //     'variant_id' => $request['variant_id'],
                // ]);
            } else {

                $cart_item_id = $cart->cartItem->where('variant_group_id', $request['variant_group_id'])->first()->id;
                //return $cart_item_id;
                $cartitem = $this->api->put('api/cartItem/' . $cart_item_id, [
                    'quantity' => $request['quantity'],
                    'variant_group_id' => $request['variant_group_id'],
                    'variant_id' => $request['variant_id'],
                ]);
            }

        }
        // if (count($cart->cartItem->where('item_id', $request['item_id'])) == 0) {
        //     $cartitem = $this->api->post('api/cartItem', ['cart_id' => $cart->id, 'item_id' => $request['item_id'], 'quantity' => $request['quantity']]);
        // } else {
        //     $item_id = $cart->cartItem->where('item_id', $request['item_id'])->first()->id;
        //     $cartitem = $this->api->put('api/cartItem/' . $item_id, ['quantity' => $request['quantity']]);
        // }

        return $cartitem;
        //
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
