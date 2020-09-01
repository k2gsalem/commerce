<?php

namespace App\Http\Controllers\Api\Config;

use App\Entities\Config\ConfPaymentStatus;
use App\Http\Controllers\Controller;
use App\Transformers\Config\ConfPaymentStatusTransformer;
use Dingo\Api\Routing\Helpers;
use Illuminate\Http\Request;

class ConfPaymentStatusController extends Controller
{

    use Helpers;
    protected $model;
    public function __construct(ConfPaymentStatus $model)
    {
        $this->model = $model;
        $this->middleware('permission:List config payment status')->only('index');
        $this->middleware('permission:List config payment status')->only('show');
        $this->middleware('permission:Create config payment status')->only('store');
        $this->middleware('permission:Update config payment status')->only('update');
        $this->middleware('permission:Delete config payment status')->only('destroy');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $paginator = $this->model->paginate($request->get('limit', config('app.pagination_limit')));
        if ($request->has('limit')) {
            $paginator->appends('limit', $request->get('limit'));
        }

        return $this->response->paginator($paginator, new ConfPaymentStatusTransformer());
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
            'payment_status_desc' => 'required|string|min:1|max:300',
            'title' => 'required|string|min:5|max:500|unique:conf_payment_statuses,title',
        ];

        $this->validate($request, $rules);
        $confPaymentStatus = $this->model->create($request->all());
        return $this->response->created(url('api/confPaymentStatus/' . $confPaymentStatus->id));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\ConfPaymentStatus  $confPaymentStatus
     * @return \Illuminate\Http\Response
     */
    public function show(ConfPaymentStatus $confPaymentStatus)
    {
        return $this->response->item($confPaymentStatus, new ConfPaymentStatusTransformer());
    }

  

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ConfPaymentStatus  $confPaymentStatus
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ConfPaymentStatus $confPaymentStatus)
    {
        
        $request['updated_by'] = $request->user()->id;

        $rules = [
            'payment_status_desc' => 'required|string|min:1|max:300',
            'title' => 'required|string|min:5|max:500|unique:conf_payment_statuses,title,'.$confPaymentStatus->id,
        ];
        if ($request->method() == 'PATCH') {
            $rules = [
                'payment_status_desc' => 'sometimes|required|string|min:1|max:300',
                'title' => 'sometimes|required|string|min:5|max:500|unique:conf_payment_statuses,title,'.$confPaymentStatus->id,
            ];
        }
        $this->validate($request, $rules);
        $confPaymentStatus->update($request->except('created_by'));
        return $this->response->item($confPaymentStatus->fresh(), new ConfPaymentStatusTransformer());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ConfPaymentStatus  $confPaymentStatus
     * @return \Illuminate\Http\Response
     */
    public function destroy(ConfPaymentStatus $confPaymentStatus)
    {
        $record = $this->model->findOrFail($confPaymentStatus->id);
        $record->delete();
        return $this->response->noContent();
    }
}
