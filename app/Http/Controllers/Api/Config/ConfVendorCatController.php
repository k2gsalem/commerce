<?php

namespace App\Http\Controllers\Api\Config;

use App\Entities\Config\ConfVendorCat;
use App\Http\Controllers\Controller;
use App\Transformers\Config\ConfVendorTransformer;
use Dingo\Api\Routing\Helpers;
use Illuminate\Http\Request;


class ConfVendorCatController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    use Helpers;    
    protected $model;

    public function __construct(ConfVendorCat $model)
    {
        $this->model = $model;
        $this->middleware('permission:List config vendor')->only('index');
        $this->middleware('permission:List config vendor')->only('show');
        $this->middleware('permission:Create config vendor')->only('store');
        $this->middleware('permission:Update config vendor')->only('update');
        $this->middleware('permission:Delete config vendor')->only('destroy');
    }
  

    public function index(Request $request)
   {
        //
        $paginator = $this->model->paginate($request->get('limit', config('app.pagination_limit')));
        if ($request->has('limit')) {
            $paginator->appends('limit', $request->get('limit'));
        }      
       
        return $this->response->paginator($paginator, new ConfVendorTransformer());



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
            'vendor_cat_desc' => 'required|string|min:5|max:300',
            'status_id' => 'required|integer|exists:conf_statuses,id',
            // 'created_by' => 'required|integer|exists:users,id',
            // 'updated_by' => 'required|integer|exists:users,id',
        ];

        //
        $this->validate($request, $rules);
        $ConfVendorCat = $this->model->create($request->all());
        return $this->response->created(url('api/confVendorCat/'.$ConfVendorCat->id));

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Entities\Config\ConfVendorCat  $confVendorCat
     * @return \Illuminate\Http\Response
     */
    public function show(ConfVendorCat $confVendorCat)
    {
        return $this->response->item($confVendorCat, new ConfVendorTransformer());
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Entities\Config\ConfVendorCat  $confVendorCat
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ConfVendorCat $confVendorCat)
    {
        $request['updated_by']=$request->user()->id;
        $rules=[
            'vendor_cat_desc' => 'required|string|min:5|max:300',
            'status_id' => 'required|integer|exists:conf_statuses,id',
        ];
        if ($request->method() == 'PATCH') {
            $rules=[
                'vendor_cat_desc' => 'sometimes|required|string|min:5|max:300',
                'status_id' => 'sometimes|required|integer|exists:conf_statuses,id',
            ];
        }
        $this->validate($request, $rules);
      
        $confVendorCat->update($request->except('created_by'));
        return $this->response->item($confVendorCat->fresh(),new ConfVendorTransformer());
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Entities\Config\ConfVendorCat  $confVendorCat
     * @return \Illuminate\Http\Response
     */
    public function destroy(ConfVendorCat $confVendorCat)
    {
        $record = $this->model->findOrFail($confVendorCat->id);
        $record->delete();
        return $this->response->noContent();
    }
}
