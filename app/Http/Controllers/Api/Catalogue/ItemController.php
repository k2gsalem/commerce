<?php

namespace App\Http\Controllers\Api\Catalogue;

use App\Entities\Assets\Asset;
use App\Entities\Catalogue\Item;
use App\Http\Controllers\Controller;
use App\Transformers\Catalogue\ItemTransfomer;
use Dingo\Api\Routing\Helpers;
use Illuminate\Http\Request;

class ItemController extends Controller
{
    use Helpers;
    protected $model;

    public function __construct(Item $model)
    {
        $this->model = $model;
        // $this->middleware('permission:List item')->only('index');
        // $this->middleware('permission:List item')->only('show');
        $this->middleware('permission:Create item')->only('store');
        $this->middleware('permission:Update item')->only('update');
        $this->middleware('permission:Delete item')->only('destroy');
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

        return $this->response->paginator($paginator, new ItemTransfomer());

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
            'category_id' => 'required|integer|exists:prod_cats,id',
            'sub_category_id' => 'integer|exists:prod_sub_cats,id',
            'item_code' => 'required|string|min:1|max:50|unique:items,item_code',
            'item_desc' => 'required|string|min:5|max:500',
            'title' => 'required|string|min:5|max:500|unique:items,title',
            'file' => 'array',
            'file.*' => 'image|mimes:jpeg,jpg,png|max:2048',
            'min_order_quantity'=> 'integer',
            'min_order_amount'=> 'gt:0|regex:/^\d*(\.\d{1,2})?$/',
            'max_order_quantity'=> 'integer',
            'max_order_amount'=> 'gt:0|regex:/^\d*(\.\d{1,2})?$/',
            'discount_percentage'=> 'gt:0|lte:100|regex:/^\d*(\.\d{1,2})?$/',
            'discount_amount'=> 'gt:0|regex:/^\d*(\.\d{1,2})?$/',
            'quantity'=>  'integer',
            'threshold'=> 'integer',
            'supplier_id' => 'integer|exists:suppliers,id',
            // 'item_image',
            'vendor_id' => 'required|integer|exists:vendors,id',
            'vendor_store_id' => 'required|integer|exists:vendor_stores,id',
            'MRP' => 'gt:0|regex:/^\d*(\.\d{1,2})?$/',
            'selling_price' => 'gt:0|lte:MRP|regex:/^\d*(\.\d{1,2})?$/',
            'status_id' => 'required|integer|exists:conf_statuses,id',
            // 'created_by' => 'required|integer|exists:users,id',
            // 'updated_by' => 'required|integer|exists:users,id'
        ];
        $this->validate($request, $rules);
        $item = $this->model->create($request->all());
        if ($request->has('file')) {
            foreach ($request->file as $file) {
                $assets = $this->api->attach(['file' => $file])->post('api/assets');
                // $item = $this->model->create($request->all());
                $item->assets()->save($assets);
            }
        } else if ($request->has('url')) {
            $assets = $this->api->post('api/assets', ['url' => $request->url]);
            // $item = $this->model->create($request->all());
            $item->assets()->save($assets);
        } else if ($request->has('uuid')) {
            $a = Asset::byUuid($request->uuid)->get();
            $assets = Asset::findOrFail($a[0]->id);
            // $item = $this->model->create($request->all());
            $item->assets()->save($assets);

        } 
        // else {
        //     $item = $this->model->create($request->all());
        // }
        return $this->response->created(url('api/item/' . $item->id));

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Entities\Catalogue\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function show(Item $item)
    {
        return $this->response->item($item, new ItemTransfomer());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Entities\Catalogue\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Item $item)
    {
        $request['updated_by'] = $request->user()->id;
        $rules = [
            'category_id' => 'required|integer|exists:prod_cats,id',
            'sub_category_id' => 'integer|exists:prod_sub_cats,id',
            'item_code' => 'required|string|min:1|max:50|unique:items,item_code,'.$item->id,
            'item_desc' => 'required|string|min:5|max:500',
            'title' => 'required|string|min:5|max:500|unique:items,title,'.$item->id,
            'file' => 'array',
            'file.*' => 'image|mimes:jpeg,jpg,png|max:2048',
            'min_order_quantity'=> 'integer',
            'min_order_amount'=> 'gt:0|regex:/^\d*(\.\d{1,2})?$/',
            'max_order_quantity'=> 'integer',
            'max_order_amount'=> 'gt:0|regex:/^\d*(\.\d{1,2})?$/',
            'discount_percentage'=> 'gt:0|lte:100|regex:/^\d*(\.\d{1,2})?$/',
            'discount_amount'=> 'gt:0|regex:/^\d*(\.\d{1,2})?$/',
            'quantity'=>  'integer',
            'threshold'=> 'integer',
            'supplier_id' => 'integer|exists:suppliers,id',
            // 'item_image',
           
            'vendor_id' => 'required|integer|exists:vendors,id',
            'vendor_store_id' => 'required|integer|exists:vendor_stores,id',
            'MRP' => 'gt:0|regex:/^\d*(\.\d{1,2})?$/',
            'selling_price' => 'gt:0|lte:MRP|regex:/^\d*(\.\d{1,2})?$/',
            'status_id' => 'required|integer|exists:conf_statuses,id',
        ];
        if ($request->method() == 'PATCH') {
            $rules = [
                'category_id' => 'sometimes|required|integer|exists:prod_cats,id',
                'sub_category_id' => 'sometimes|integer|exists:prod_sub_cats,id',
                'item_code' => 'sometimes|required|string|min:3|max:100|unique:items,item_code,'.$item->id,
                'item_desc' => 'sometimes|required|string|min:5|max:300',
                'title' => 'sometimes|required|string|min:5|max:500|unique:items,title,'.$item->id,
                // 'vendor_store_id' => 'sometimes|required|integer|exists:vendors,id',
                'file' => 'array',
                'file.*' => 'sometimes|required|image|mimes:jpeg,jpg,png|max:2048',
                'min_order_quantity'=> 'sometimes|integer',
                'min_order_amount'=> 'sometimes|gt:0|regex:/^\d*(\.\d{1,2})?$/',
                'max_order_quantity'=> 'sometimes|integer',
                'max_order_amount'=> 'sometimes|gt:0|regex:/^\d*(\.\d{1,2})?$/',
                'discount_percentage'=> 'sometimes|gt:0|lte:100|regex:/^\d*(\.\d{1,2})?$/',
                'discount_amount'=> 'sometimes|gt:0|regex:/^\d*(\.\d{1,2})?$/',
                'quantity'=>  'sometimes|integer',
                'threshold'=> 'sometimes|integer',
                'supplier_id' => 'sometimes|required|integer|exists:suppliers,id',
                // 'item_simage',
                'vendor_id' => 'sometimes|required|integer|exists:vendors,id',
                'vendor_store_id' => 'sometimes|required|integer|exists:vendor_stores,id',
                'MRP' => 'sometimes|gt:0|regex:/^\d*(\.\d{1,2})?$/',
                'selling_price' => 'sometimes|gt:0|lte:MRP|regex:/^\d*(\.\d{1,2})?$/',
                'status_id' => 'sometimes|required|integer|exists:conf_statuses,id',
            ];

        }
        $this->validate($request, $rules);
        $item->update($request->except('created_by'));
        if ($request->has('file')) {
            foreach ($request->file as $file) {
                $assets = $this->api->attach(['file' => $file])->post('api/assets');
                $item->assets()->save($assets);
            }
        }
        return $this->response->item($item->fresh(), new ItemTransfomer());

        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Entities\Catalogue\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function destroy(Item $item)
    {
        $item->assets()->delete();

        if ($item->itemVariants()->count()) {
            $response = array(
                'message' => 'Cannot delete: This item has item variants!'
            );
            return response()->json($response, 403);

           
        }

        if ($item->itemVariantGroups()->count()) {
            $response = array(
                'message' => 'Cannot delete: This item has item variant groups!'
            );
            return response()->json($response, 403);

            // return $this->response('Cannot delete: this project has transactions');
        }

        if ($item->stockTrackers()->count()) {
            $response = array(
                'message' => 'Cannot delete: This item has stock tracker!'
            );
            return response()->json($response, 403);

            // return $this->response('Cannot delete: this project has transactions');
        }
        
        $item->delete();
        // $record = $this->model->findOrFail($item->id);
        // $record->delete();
        return $this->response->noContent();
    }
}
