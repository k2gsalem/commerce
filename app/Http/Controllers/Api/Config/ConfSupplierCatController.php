<?php

namespace App\Http\Controllers\Api\Config;

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
        //
        $this->validate($request, [
            'supplier_cat_desc' => 'required|max:300',
            'status_id' => 'required|numeric',
            'created_by' => 'required|numeric',
            'updated_by' => 'required|numeric',
        ]);
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
        //
    }
}
