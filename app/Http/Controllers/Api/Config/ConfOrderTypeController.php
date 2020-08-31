<?php

namespace App\Http\Controllers\Api\Config;

use App\Entities\Config\ConfOrderType;
use App\Http\Controllers\Controller;
use App\Transformers\Config\ConfOrderTypeTransformer;
use Dingo\Api\Routing\Helpers;
use Illuminate\Http\Request;

class ConfOrderTypeController extends Controller
{
    use Helpers;
    protected $model;
    public function __construct(ConfOrderType $model)
    {
        $this->model = $model;
        $this->middleware('permission:List order type')->only('index');
        $this->middleware('permission:List order type')->only('show');
        $this->middleware('permission:Create order type')->only('store');
        $this->middleware('permission:Update order type')->only('update');
        $this->middleware('permission:Delete order type')->only('destroy');
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

        return $this->response->paginator($paginator, new ConfOrderTypeTransformer());

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
            'order_type_desc' => 'required|string|min:1|max:300',
            'title' => 'required|string|min:5|max:500|unique:conf_order_types,title',
        ];

        $this->validate($request, $rules);
        $confOrderType = $this->model->create($request->all());
        return $this->response->created(url('api/confOrderType/' . $confOrderType->id));

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\ConfOrderType  $confOrderType
     * @return \Illuminate\Http\Response
     */
    public function show(ConfOrderType $confOrderType)
    {
        return $this->response->item($confOrderType, new ConfOrderTypeTransformer());
    }

  
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ConfOrderType  $confOrderType
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ConfOrderType $confOrderType)
    {
        $request['updated_by'] = $request->user()->id;

        $rules = [
            'order_type_desc' => 'required|string|min:1|max:300',
            'title' => 'required|string|min:5|max:500|unique:conf_order_types,title,'.$confOrderType->id,
        ];
        if ($request->method() == 'PATCH') {
            $rules = [
                'status_desc' => 'sometimes|required|string|min:1|max:300',
                'title' => 'sometimes|required|string|min:5|max:500|unique:conf_order_types,title,'.$confOrderType->id,
            ];
        }
        $this->validate($request, $rules);
        $confOrderType->update($request->except('created_by'));
        return $this->response->item($confOrderType->fresh(), new ConfOrderTypeTransformer());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ConfOrderType  $confOrderType
     * @return \Illuminate\Http\Response
     */
    public function destroy(ConfOrderType $confOrderType)
    {
        $record = $this->model->findOrFail($confOrderType->id);
        $record->delete();
        return $this->response->noContent();
    }
}
