<?php

namespace App\Http\Controllers\Api\Vendor;

use App\Entities\Assets\Asset;
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
        $request['created_by']=$request->user()->id;
        $request['updated_by']=$request->user()->id;
        $rules=[
            'vendor_name'=>'required|string',
            'file'=>'array',
            'file.*'=>'image|mimes:jpeg,jpg,png|max:1024',
            'vendor_category_id'=>'required|integer|exists:conf_vendor_cats,id',
            'vendor_desc'=>'required|string|min:5|max:300',
            'vendor_address'=>'required|string|min:5|max:200',
            'vendor_contact'=>'required|string|min:10|max:13',
            'vendor_email'=>'required|email',
            'status_id' => 'required|integer|exists:conf_statuses,id',
            // 'created_by' => 'required|integer|exists:users,id',
            // 'updated_by' => 'required|integer|exists:users,id'         
           
            
        ];
        $this->validate($request,$rules);
        $vendor = $this->model->create($request->all());
        if($request->has('file')){
            foreach($request->file as $file){
                $assets =$this->api->attach(['file'=>$file])->post('api/assets');
                $vendor->assets()->save($assets);
            }
        }else if($request->has('url')){
            $assets = $this->api->post('api/assets', ['url' => $request->url]);
            $vendor->assets()->save($assets);
        }else if($request->has('uuid')){
            $a=Asset::byUuid($request->uuid)->get();
            $assets= Asset::findOrFail($a[0]->id);
            $vendor->assets()->save($assets);         

        } 
        return $this->response->created(url('api/vendor/' . $vendor->id));
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
