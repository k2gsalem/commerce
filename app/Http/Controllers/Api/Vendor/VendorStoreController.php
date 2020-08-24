<?php

namespace App\Http\Controllers\Api\Vendor;

use App\Entities\Assets\Asset;
use App\Entities\Vendor\VendorStore;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Validation\Rule;
use App\Transformers\Vendor\VendorStoreTransformer;
use Dingo\Api\Routing\Helpers;


class VendorStoreController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    use Helpers;
    protected $model;

    public function __construct(VendorStore $model)
    {
        $this->model = $model;
        $this->middleware('permission:List vendor store')->only('index');
        $this->middleware('permission:List vendor store')->only('show');
        $this->middleware('permission:Create vendor store')->only('store');
        $this->middleware('permission:Update vendor store')->only('update');
        $this->middleware('permission:Delete vendor store')->only('destroy');
    }
    public function index(Request $request)
    {
        $paginator = $this->model->paginate($request->get('limit', config('app.pagination_limit')));
        if ($request->has('limit')) {
            $paginator->appends('limit', $request->get('limit'));
        }

        return $this->response->paginator($paginator, new VendorStoreTransformer());
      
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
   

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
            'vendor_id' => 'required|integer|exists:vendors,id',
            'file' => 'array',
            'file.*' => 'image|mimes:jpeg,jpg,png|max:1024',
            
            'vendor_store_name' => 'required|string|min:5|max:300',
            'vendor_store_location' => 'required|string|min:5|max:300',
              
            'vendor_store_location' => Rule::unique('vendor_stores')->where(function ($query) use ($request) {
                return $query->where('vendor_store_name', $request->vendor_store_name)->where('vendor_store_location', $request->vendor_store_location);
            }),
            'vendor_store_address' => 'string|min:5|max:300',
            'vendor_store_contact' => 'required|string|min:10',
            'latitude'=> 'required|gt:0|regex:/^\d*(\.\d{1,2})?$/',
            'longitude'=> 'required|gt:0|regex:/^\d*(\.\d{1,2})?$/',
            'status_id' => 'required|integer|exists:conf_statuses,id',
           
        ];
        $this->validate($request, $rules,[
          
            'vendor_store_location.unique'=>'Vendor store name in the location is already exists. Please try with other store name or other location',
            
           ]);
        $vendorStore = $this->model->create($request->all());
        if ($request->has('file')) {
            foreach ($request->file as $file) {
                $assets = $this->api->attach(['file' => $file])->post('api/assets');
                // $vendor = $this->model->create($request->all());
                $vendorStore->assets()->save($assets);
            }
        } else if ($request->has('url')) {
            $assets = $this->api->post('api/assets', ['url' => $request->url]);
            // $vendor = $this->model->create($request->all());
            $vendorStore->assets()->save($assets);
        } else if ($request->has('uuid')) {
            $a = Asset::byUuid($request->uuid)->get();
            $assets = Asset::findOrFail($a[0]->id);
            // $vendor = $this->model->create($request->all());
            $vendorStore->assets()->save($assets);

        }
        //  else{
        //     $vendor = $this->model->create($request->all());
        // }
        return $this->response->created(url('api/vendorStores/' . $vendorStore->id));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\VendorStore  $vendorStore
     * @return \Illuminate\Http\Response
     */
    public function show(VendorStore $vendorStore)
    {
        return $this->response->item($vendorStore, new VendorStoreTransformer());
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\VendorStore  $vendorStore
     * @return \Illuminate\Http\Response
     */
   

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\VendorStore  $vendorStore
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, VendorStore $vendorStore)
    {
               
        $request['updated_by'] = $request->user()->id;
        $rules = [
            'vendor_id' => 'required|integer|exists:vendors,id',
            'file' => 'array',
            'file.*' => 'image|mimes:jpeg,jpg,png|max:1024',
            'vendor_store_name' => 'required|string|min:5|max:300',
            'vendor_store_location' => 'required|string|min:5|max:300',
            'vendor_store_location' => Rule::unique('vendor_stores')->where(function ($query) use ($request) {
                return $query->where('vendor_store_name', $request->vendor_store_name)->where('vendor_store_location', $request->vendor_store_location);
            })->ignore($vendorStore->id),
            'vendor_store_address' => 'string|min:5|max:300',
            'vendor_store_contact' => 'required|string|min:10',
            'latitude'=> 'required|gt:0|regex:/^\d*(\.\d{1,2})?$/',
            'longitude'=> 'required|gt:0|regex:/^\d*(\.\d{1,2})?$/',
            'status_id' => 'required|integer|exists:conf_statuses,id',

        ];



        
        if ($request->method() == 'PATCH') {
            $rules = [
                'vendor_id' => 'sometimes|required|integer|exists:vendors,id',
                'file' => 'array',
                'file.*' => 'sometimes|image|mimes:jpeg,jpg,png|max:1024',
                'vendor_store_name' => 'sometimes|required|string|min:5|max:300',
                'vendor_store_location' => 'sometimes|required|string|min:5|max:300',
                'vendor_store_location' => Rule::unique('vendor_stores')->where(function ($query) use ($request) {
                    return $query->where('vendor_store_name', $request->vendor_store_name)->where('vendor_store_location', $request->vendor_store_location);
                })->ignore($vendorStore->id),
                'vendor_store_address' => 'sometimes|string|min:5|max:300',
                'vendor_store_contact' => 'sometimes|required|string|min:10',
                'latitude'=> 'sometimes|required|gt:0|regex:/^\d*(\.\d{1,2})?$/',
                'longitude'=> 'sometimes|required|gt:0|regex:/^\d*(\.\d{1,2})?$/',
                'status_id' => 'sometimes|required|integer|exists:conf_statuses,id',


            ];

        }
        $this->validate($request, $rules,[
          
            'vendor_store_location.unique'=>'Vendor store name in the location is already exists. Please try with other store name or other location',
            
           ]);
        $vendorStore->update($request->except('created_by'));
        if ($request->has('file')) {
            foreach ($request->file as $file) {
                $assets = $this->api->attach(['file' => $file])->post('api/assets');
                $vendorStore->assets()->save($assets);
            }
        }
        return $this->response->item($vendorStore->fresh(), new VendorStoreTransformer());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\VendorStore  $vendorStore
     * @return \Illuminate\Http\Response
     */
    public function destroy(VendorStore $vendorStore)
    {
        $vendorStore->assets()->delete();
        $vendorStore->delete();
        // $record = $this->model->findOrFail($vendor->id);
        // $record->delete();
        return $this->response->noContent();
        
    }
}
