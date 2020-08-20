<?php

namespace App\Http\Controllers\Api\Catalogue;

use App\Entities\Assets\Asset;
use App\Entities\Catalogue\ItemVariant;
use App\Http\Controllers\Controller;
use App\Transformers\Catalogue\ItemVariantTransformer;
use Dingo\Api\Routing\Helpers;
use Illuminate\Http\Request;

class ItemVariantController extends Controller
{
    use Helpers;
    protected $model;

    public function __construct(ItemVariant $model)
    {
        $this->model = $model;
        // $this->middleware('permission:List item variant')->only('index');
        // $this->middleware('permission:List item variant')->only('show');
        $this->middleware('permission:Create item variant')->only('store');
        $this->middleware('permission:Update item variant')->only('update');
        $this->middleware('permission:Delete item variant')->only('destroy');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //

        $paginator = $this->model->paginate($request->get('limit', config('app.pagination_limit')));
        if ($request->has('limit')) {
            $paginator->appends('limit', $request->get('limit'));
        }

        return $this->response->paginator($paginator, new ItemVariantTransformer());
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
            'item_id' => 'required|integer|exists:items,id',
            'variant_group_id' => 'integer|exists:item_variant_groups,id',
            'variant_code' => 'required|string|min:1|max:50|unique:item_variants,variant_code',
            'variant_desc' => 'required|string|min:5|max:500',
            'min_order_quantity'=> 'required|integer',
            'min_order_amount'=> 'required|gt:0|regex:/^\d*(\.\d{1,2})?$/',
            'max_order_quantity'=> 'required|integer',
            'max_order_amount'=> 'required|gt:0|regex:/^\d*(\.\d{1,2})?$/',
            'discount_percentage'=> 'gt:0|lte:100|regex:/^\d*(\.\d{1,2})?$/',
            'discount_amount'=> 'gt:0|regex:/^\d*(\.\d{1,2})?$/',
            'quantity'=>  'required|integer',
            'threshold'=> 'required|integer',
            'supplier_id' => 'integer|exists:suppliers,id',
            // 'item_image',
           
            'vendor_store_id' => 'required|integer|exists:vendors,id',
            'MRP' => 'required|gt:0|regex:/^\d*(\.\d{1,2})?$/',
            'selling_price' => 'required|gt:0|lte:MRP|regex:/^\d*(\.\d{1,2})?$/',
            'default' => 'boolean',
            'file' => 'array',
            'file.*' => 'image|mimes:jpeg,jpg,png|max:2048',
           
            'status_id' => 'required|integer|exists:conf_statuses,id',
            // 'created_by' => 'required|integer|exists:users,id',
            // 'updated_by' => 'required|integer|exists:users,id'
        ];
        $this->validate($request, $rules);
        if($request->has('default')){
            if($request->default===true){
                $this->model->query()->where('item_id',$request->variant_group_id)->update(['default'=>false]);
            }           
        }        
        $itemVariant = $this->model->create($request->all());

        if ($request->has('file')) {
            foreach ($request->file as $file) {
                $assets = $this->api->attach(['file' => $file])->post('api/assets');
                // $itemVariant = $this->model->create($request->all());
                $itemVariant->assets()->save($assets);
            }
        } else if ($request->has('url')) {
            $assets = $this->api->post('api/assets', ['url' => $request->url]);
            // $itemVariant = $this->model->create($request->all());
            $itemVariant->assets()->save($assets);
        } else if ($request->has('uuid')) {
            $a = Asset::byUuid($request->uuid)->get();
            $assets = Asset::findOrFail($a[0]->id);
            // $itemVariant = $this->model->create($request->all());
            $itemVariant->assets()->save($assets);
        }
        // else {
        //     $itemVariant = $this->model->create($request->all());
        // }
        return $this->response->created(url('api/itemVariant/' . $itemVariant->id));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Entities\Catalogue\ItemVariant  $itemVariant
     * @return \Illuminate\Http\Response
     */
    public function show(ItemVariant $itemVariant)
    {
        return $this->response->item($itemVariant, new ItemVariantTransformer());
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Entities\Catalogue\ItemVariant  $itemVariant
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ItemVariant $itemVariant)
    {
        $request['updated_by'] = $request->user()->id;
        $rules = [
            'item_id' => 'required|integer|exists:items,id',
            'variant_group_id' => 'required|integer|exists:item_variant_groups,id',
            'variant_code' => 'required|string|min:1|max:50|unique:item_variants,variant_code,' . $itemVariant->id,
            'variant_desc' => 'required|string|min:5|max:500',
            'min_order_quantity'=> 'required|integer',
            'min_order_amount'=> 'required|gt:0|regex:/^\d*(\.\d{1,2})?$/',
            'max_order_quantity'=> 'required|integer',
            'max_order_amount'=> 'required|gt:0|regex:/^\d*(\.\d{1,2})?$/',
            'discount_percentage'=> 'gt:0|lte:100|regex:/^\d*(\.\d{1,2})?$/',
            'discount_amount'=> 'gt:0|regex:/^\d*(\.\d{1,2})?$/',
            'quantity'=>  'required|integer',
            'threshold'=> 'required|integer',
            'supplier_id' => 'integer|exists:suppliers,id',
            // 'item_image',
           
            'vendor_store_id' => 'required|integer|exists:vendors,id',
            'MRP' => 'required|gt:0|regex:/^\d*(\.\d{1,2})?$/',
            'selling_price' => 'required|gt:0|lte:MRP|regex:/^\d*(\.\d{1,2})?$/',
            'default' => 'boolean',
            'file' => 'array',
            'file.*' => 'image|mimes:jpeg,jpg,png|max:2048',
            
            'status_id' => 'required|integer|exists:conf_statuses,id',
        ];
        if ($request->method() == 'PATCH') {
            $rules = [
                'item_id' => 'sometimes|required|integer|exists:items,id',
                'variant_group_id' => 'sometimes|required|integer|exists:item_variant_groups,id',
                'variant_code' => 'sometimes|required|string|min:1|max:50|unique:item_variants,variant_code,' . $itemVariant->id,
                'variant_desc' => 'sometimes|required|string|min:5|max:500',
                'min_order_quantity'=> 'sometimes|required|integer',
                'min_order_amount'=> 'sometimes|required|gt:0|regex:/^\d*(\.\d{1,2})?$/',
                'max_order_quantity'=> 'sometimes|required|integer',
                'max_order_amount'=> 'sometimes|required|gt:0|regex:/^\d*(\.\d{1,2})?$/',
                'discount_percentage'=> 'sometimes|gt:0|lte:100|regex:/^\d*(\.\d{1,2})?$/',
                'discount_amount'=> 'sometimes|gt:0|regex:/^\d*(\.\d{1,2})?$/',
                'quantity'=>  'sometimes|required|integer',
                'threshold'=> 'sometimes|required|integer',
                'supplier_id' => 'sometimes|required|integer|exists:suppliers,id',
                // 'item_image',
               
                'vendor_store_id' => 'sometimes|required|integer|exists:vendors,id',
                'MRP' => 'sometimes|required|gt:0|regex:/^\d*(\.\d{1,2})?$/',
                'selling_price' => 'sometimes|required|gt:0|lte:MRP|regex:/^\d*(\.\d{1,2})?$/',
                'default' => 'sometimes|boolean',
                'file' => 'array',
                'file.*' => 'sometimes|image|mimes:jpeg,jpg,png|max:2048',
                'status_id' => 'sometimes|required|integer|exists:conf_statuses,id',
            ];
        }
        $this->validate($request, $rules);
        if($request->has('default')){
            if($request->default===true){
                $this->model->query()->where('item_id',$request->variant_group_id)->update(['default'=>false]);
            }           
        }        
        $itemVariant->update($request->except('created_by'));
        if ($request->has('file')) {
            foreach ($request->file as $file) {
                $assets = $this->api->attach(['file' => $file])->post('api/assets');
                $itemVariant->assets()->save($assets);
            }
        }
        return $this->response->item($itemVariant->fresh(), new ItemVariantTransformer());
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Entities\Catalogue\ItemVariant  $itemVariant
     * @return \Illuminate\Http\Response
     */
    public function destroy(ItemVariant $itemVariant)
    {
        $itemVariant->assets()->delete();
        $itemVariant->delete();
        // $record = $this->model->findOrFail($itemVariant->id);
        // $record->delete();
        return $this->response->noContent();
    }
}
