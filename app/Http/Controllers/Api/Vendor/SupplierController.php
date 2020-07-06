<?php

namespace App\Http\Controllers\Api\Vendor;

use App\Entities\Vendor\Supplier;
use App\Http\Controllers\Controller;
use App\Transformers\Vendor\SupplierTransformer;
use Dingo\Api\Routing\Helpers;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    use Helpers;    
    protected $model;
    public function __construct(Supplier $model)
    {
        $this->model = $model;
        $this->middleware('permission:List supplier')->only('index');
        $this->middleware('permission:List supplier')->only('show');
        $this->middleware('permission:Create supplier')->only('store');
        $this->middleware('permission:Update supplier')->only('update');
        $this->middleware('permission:Delete supplier')->only('destroy');
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
       
        return $this->response->paginator($paginator, new SupplierTransformer());
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Entities\Vendor\Supplier  $supplier
     * @return \Illuminate\Http\Response
     */
    public function show(Supplier $supplier)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Entities\Vendor\Supplier  $supplier
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Supplier $supplier)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Entities\Vendor\Supplier  $supplier
     * @return \Illuminate\Http\Response
     */
    public function destroy(Supplier $supplier)
    {
        $record = $this->model->findOrFail($supplier->id);
        $record->delete();
        return $this->response->noContent();
    }
}
