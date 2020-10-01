<?php

namespace App\Http\Controllers\Api\Order;

use App\Entities\Order\UserOrder;
use App\Http\Controllers\Controller;
use App\Transformers\Order\UserOrderTransformer;
use Dingo\Api\Routing\Helpers;
use Illuminate\Http\Request;

class UserOrderController extends Controller
{
    use Helpers;
    protected $model;
    public function __construct(UserOrder $model)
    {
        $this->model = $model;
        // $this->middleware('permission:List user order')->only('index');
        // $this->middleware('permission:List user order')->only('show');
        // $this->middleware('permission:Create user order')->only('store');
        // $this->middleware('permission:Update user order')->only('update');
        // $this->middleware('permission:Delete user order')->only('destroy');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        $paginator = $this->model->paginate($request->get('limit', config('app.pagination_limit')));
        if ($request->has('limit')) {
            $paginator->appends('limit', $request->get('limit'));
        }

        return $this->response->paginator($paginator, new UserOrderTransformer());
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
        $request['created_by'] = $request->user()->id;
        $request['updated_by'] = $request->user()->id;

        $rules = [            
            'user_id'=>'required|integer|exists:users,id',
            'vendor_store_id'=>'required|integer|exists:vendor_stores,id',
            'order_status_id'=>'required|integer|exists:conf_order_statuses,id',
            'order_type'=>'required|integer',
            'user_address_id'=>'required|integer|exists:user_addresses,id',
            'order_amount'=>'required',
            'order_date'=>'required',           
            'created_at'=>'required',
            'updated_at'=>'required',
        ];

        $this->validate($request, $rules);
        $userOrder = $this->model->create($request->all());
        return $this->response->created(url('api/orders/userOrder/' . $userOrder->id));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Entities\Order\UserOrder  $userOrder
     * @return \Illuminate\Http\Response
     */
    public function show(UserOrder $userOrder)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Entities\Order\UserOrder  $userOrder
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, UserOrder $userOrder)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Entities\Order\UserOrder  $userOrder
     * @return \Illuminate\Http\Response
     */
    public function destroy(UserOrder $userOrder)
    {
        //
    }
}
