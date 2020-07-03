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
        // $this->middleware('permission:List users')->only('index');
        // $this->middleware('permission:List users')->only('show');
        // $this->middleware('permission:Create users')->only('store');
        // $this->middleware('permission:Update users')->only('update');
        // $this->middleware('permission:Delete users')->only('destroy');
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
        //
        $this->validate($request, [
            'vendor_cat_desc' => 'required|max:300',
            'status_id' => 'required|numeric',
            'created_by' => 'required|numeric',
            'updated_by' => 'required|numeric',
        ]);
        $ConfVendorCat = $this->model->create($request->all());
        return $this->response->created(url('api/ConfVendorCat/'.$ConfVendorCat->id));

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Entities\Config\ConfVendorCat  $confVendorCat
     * @return \Illuminate\Http\Response
     */
    public function show(ConfVendorCat $confVendorCat)
    {
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
        //
    }
}
