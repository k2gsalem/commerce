<?php

namespace App\Http\Controllers\Api\Config;

use App\Entities\Config\ConfOrderStatus;
use App\Http\Controllers\Controller;
use App\Transformers\Config\ConfOrderStatusTransformer;
use Dingo\Api\Routing\Helpers;
use Illuminate\Http\Request;

class ConfigOrderStatusController extends Controller
{
    use Helpers;
    protected $model;
    public function __construct(ConfOrderStatus $model)
    {
        $this->model = $model;
        // $this->middleware('permission:List conf order status')->only('index');
        // $this->middleware('permission:List conf order status')->only('show');
        // $this->middleware('permission:Create conf order status')->only('store');
        // $this->middleware('permission:Update conf order status')->only('update');
        // $this->middleware('permission:Delete conf order status')->only('destroy');
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

        return $this->response->paginator($paginator, new ConfOrderStatusTransformer());
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
            'status_desc' => 'required|string|min:1|max:300|unique:conf_order_statuses,status_desc',
        ];

        $this->validate($request, $rules);
        $confOrderStatus = $this->model->create($request->all());
        return $this->response->created(url('api/confOrderStatus/' . $confOrderStatus->id));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Entities\Config\ConfOrderStatus  $confOrderStatus
     * @return \Illuminate\Http\Response
     */
    public function show(ConfOrderStatus $confOrderStatus)
    {
        //
        return $this->response->item($confOrderStatus, new ConfOrderStatusTransformer());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Entities\Config\ConfOrderStatus  $confOrderStatus
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ConfOrderStatus $confOrderStatus)
    {
        //
        $request['updated_by'] = $request->user()->id;

        $rules = [
            'status_desc' => 'required|string|min:1|max:300|unique:conf_order_statuses,status_desc,'.$confOrderStatus->id,
            
        ];
        if ($request->method() == 'PATCH') {
            $rules = [
                'status_desc' => 'sometimes|required|string|min:1|max:300|unique:conf_order_statuses,status_desc,'.$confOrderStatus->id,                
            ];
        }
        $this->validate($request, $rules);
        $confOrderStatus->update($request->except('created_by'));
        return $this->response->item($confOrderStatus->fresh(), new ConfOrderStatusTransformer());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Entities\Config\ConfOrderStatus  $confOrderStatus
     * @return \Illuminate\Http\Response
     */
    public function destroy(ConfOrderStatus $confOrderStatus)
    {
        $record = $this->model->findOrFail($confOrderStatus->id);
        if ($confOrderStatus->userOrders()->count()) {
            $response = array(
                'message' => 'Cannot delete: This status has User Orders!'
            );
            return response()->json($response, 403);          
        }
        $record->delete();
        return $this->response->noContent();
        //
    }
}
