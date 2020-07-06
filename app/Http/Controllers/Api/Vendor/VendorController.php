<?php

namespace App\Http\Controllers\Api\Vendor;

use App\Entities\Vendor\Vendor;
use App\Http\Controllers\Controller;
use App\Transformers\Vendor\VendorTransformer;
use Dingo\Api\Routing\Helpers;
use Illuminate\Http\Request;

class VendorController extends Controller
{
    use Helpers;    
    protected $model;
    public function __construct(Vendor $model)
    {
        $this->model = $model;
        $this->middleware('permission:List vendor')->only('index');
        $this->middleware('permission:List vendor')->only('show');
        $this->middleware('permission:Create vendor')->only('store');
        $this->middleware('permission:Update vendor')->only('update');
        $this->middleware('permission:Delete vendor')->only('destroy');
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
       
        return $this->response->paginator($paginator, new VendorTransformer());
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
     * @param  \App\Entities\Vendor\Vendor  $vendor
     * @return \Illuminate\Http\Response
     */
    public function show(Vendor $vendor)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Entities\Vendor\Vendor  $vendor
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Vendor $vendor)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Entities\Vendor\Vendor  $vendor
     * @return \Illuminate\Http\Response
     */
    public function destroy(Vendor $vendor)
    {
        $record = $this->model->findOrFail($vendor->id);
        $record->delete();
        return $this->response->noContent();
    }
}
