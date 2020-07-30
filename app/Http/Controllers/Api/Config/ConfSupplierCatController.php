<?php

namespace App\Http\Controllers\Api\Config;

use App\Entities\Config\ConfStatus;
use App\Entities\Config\ConfSupplierCat;
use App\Http\Controllers\Controller;
use App\Transformers\Config\ConfSupplierTransformer;
use Dingo\Api\Routing\Helpers;
use Illuminate\Http\Request;

class ConfSupplierCatController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */ 
    use Helpers;    
    protected $model;

    public function __construct(ConfSupplierCat $model)
    {
        $this->model = $model;
        $this->middleware('permission:List config supplier')->only('index');
        $this->middleware('permission:List config supplier')->only('show');
        $this->middleware('permission:Create config supplier')->only('store');
        $this->middleware('permission:Update config supplier')->only('update');
        $this->middleware('permission:Delete config supplier')->only('destroy');
    }
     
    public function index(Request $request)
    {
        //

        $paginator = $this->model->paginate($request->get('limit', config('app.pagination_limit')));
        if ($request->has('limit')) {
            $paginator->appends('limit', $request->get('limit'));
        }      
       
    
        return $this->response->paginator($paginator, new ConfSupplierTransformer());

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request['created_by']=$request->user()->id;
        $request['updated_by']=$request->user()->id;
        $rules=[
            'supplier_cat_desc' => 'required|string|min:5|max:300',
            'status_id' => 'required|integer|exists:conf_statuses,id',
            // 'created_by' => 'required|integer|exists:users,id',
            // 'updated_by' => 'required|integer|exists:users,id',
        ];
        $this->validate($request, $rules);
        // ConfStatus::findOrFail($request->id);
        $confSupplierCat = $this->model->create($request->all());
        return $this->response->created(url('api/confSupplierCat/'.$confSupplierCat->id));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Entities\Config\ConfSupplierCat  $confSupplierCat
     * @return \Illuminate\Http\Response
     */
    public function show(ConfSupplierCat $confSupplierCat)
    {
        return $this->response->item($confSupplierCat, new ConfSupplierTransformer());
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Entities\Config\ConfSupplierCat  $confSupplierCat
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ConfSupplierCat $confSupplierCat)
    {
       
        $request['updated_by']=$request->user()->id;
        $rules=[
            'supplier_cat_desc' => 'required|string|min:5|max:300',
            'status_id' => 'required|integer|exists:conf_statuses,id',          
        ];
        if ($request->method() == 'PATCH') {
            $rules=[
                'supplier_cat_desc' => 'sometimes|required|string|min:5|max:300',
                'status_id' => 'sometimes|required|integer|exists:conf_statuses,id',          
            ];
        }
        $this->validate($request, $rules);
      
        $confSupplierCat->update($request->except('created_by'));
        return $this->response->item($confSupplierCat->fresh(),new ConfSupplierTransformer());
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Entities\Config\ConfSupplierCat  $confSupplierCat
     * @return \Illuminate\Http\Response
     */
    public function destroy(ConfSupplierCat $confSupplierCat)
    {
        $record = $this->model->findOrFail($confSupplierCat->id);
        $record->delete();
        return $this->response->noContent();
    }
}
