<?php

namespace App\Http\Controllers\Api\Vendor;

use App\Entities\Assets\Asset;
use App\Entities\Config\ConfStatus;
use App\Entities\Config\ConfSupplierCat;
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
        $this->validate($request,[
            'supplier_name'=>'required|string',
            'supplier_logo'=>'file|size:512|mimes:jpeg,jpg,png',
            'supplier_category_id'=>'required|integer',
            'supplier_desc'=>'required|srting|max:300',
            'supplier_address'=>'required|string|max:300',
            'supplier_contact'=>'required|size:10',
            'supplier_email'=>'required|email',
            'status_id'=>'required|integer',
            'created_by'=>'required|integer',
            'updated_by'=>'required|integer'
           
        ]);
        ConfStatus::findOrFail($request->status_id);
        ConfSupplierCat::findOrFail($request->supplier_category_id);
        $supplier = $this->model->create($request->all());
        if($request->has('file')){
            foreach($request->file as $file){
                $assets =$this->api->attach(['file'=>$file])->post('api/assets');
                $supplier->assets()->save($assets);
            }
        }else if($request->has('url')){
            $assets = $this->api->post('api/assets', ['url' => $request->url]);
            $supplier->assets()->save($assets);
        }else if($request->has('uuid')){
            $a=Asset::byUuid($request->uuid)->get();
            $assets= Asset::findOrFail($a[0]->id);
            $supplier->assets()->save($assets);         

        } 
        return $this->response->created(url('api/supplier/' . $supplier->id));
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
