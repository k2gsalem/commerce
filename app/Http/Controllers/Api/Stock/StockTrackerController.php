<?php

namespace App\Http\Controllers\Api\Stock;

use App\Entities\Stock\StockTracker;
use App\Http\Controllers\Controller;
use App\Transformers\Stock\StockTrackerTransformer;
use Dingo\Api\Routing\Helpers;
use Illuminate\Http\Request;

class StockTrackerController extends Controller
{
    use Helpers;
    protected $model;

    public function __construct(StockTracker $model)
    {
        $this->model = $model;
        // $this->middleware('permission:List stock tracker')->only('index');
        // $this->middleware('permission:List stock tracker')->only('show');
        $this->middleware('permission:Create stock tracker')->only('store');
        $this->middleware('permission:Update stock tracker')->only('update');
        $this->middleware('permission:Delete stock tracker')->only('destroy');
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
        return $this->response->paginator($paginator, new StockTrackerTransformer());
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
        $request['created_by'] = $request->user()->id;
        $request['updated_by'] = $request->user()->id;
        $rules = [
            'item_id' => 'required|integer|exists:items,id',
            'variant_id' => 'required|integer|exists:item_variants,id',
            'supplier_id' => 'required|integer|exists:suppliers,id',
            'vendor_id' => 'required|integer|exists:vendors,id',
            'vendor_store_id' => 'required|integer|exists:vendor_stores,id',
            'order_ref'=>'string',
            'order_date'=>'date_format:Y-m-d',
            'order_type_id' => 'required|integer|exists:conf_order_types,id',
            'MRP' => 'gt:0|regex:/^\d*(\.\d{1,2})?$/',
            'purchase_price'=>'required_if:order_type_id,==,1|regex:/^\d*(\.\d{1,2})?$/',    
            'selling_price' => 'required_if:order_type_id,==,2|gt:0|lte:MRP|regex:/^\d*(\.\d{1,2})?$/',
          //  'purchase_order_date'=>'date_format:Y-m-d H:i:s',
                  
            'stock_quantity' => 'required|integer',
            'total_amount' =>  'required|gt:0|regex:/^\d*(\.\d{1,2})?$/',
            'payment_status_id' => 'required|integer|exists:conf_payment_statuses,id',
            'payment_date'=>'date_format:Y-m-d',
            'comments'=>'string',            
            'status_id' => 'required|integer|exists:conf_statuses,id',
        ];
        $this->validate($request, $rules);
        $stockTracker = $this->model->create($request->all());
        return $this->response->created(url('api/stockTracker/' . $stockTracker->id));
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Entities\Stock\StockTracker  $stockTracker
     * @return \Illuminate\Http\Response
     */
    public function show(StockTracker $stockTracker)
    {
        return $this->response->item($stockTracker, new StockTrackerTransformer());
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Entities\Stock\StockTracker  $stockTracker
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, StockTracker $stockTracker)
    {
        $request['updated_by'] = $request->user()->id;
        $rules = [
            'item_id' => 'required|integer|exists:items,id',
            'variant_id' => 'required|integer|exists:item_variants,id',
            'supplier_id' => 'required|integer|exists:suppliers,id',
            'vendor_id' => 'required|integer|exists:vendors,id',
            'vendor_store_id' => 'required|integer|exists:vendor_stores,id',
            'order_ref'=>'string',
            'order_date'=>'date_format:Y-m-d',
            'order_type_id' => 'required|integer|exists:conf_order_types,id',
            'MRP' => 'gt:0|regex:/^\d*(\.\d{1,2})?$/',
            'purchase_price'=>'required_if:order_type_id,==,1|regex:/^\d*(\.\d{1,2})?$/',    
            'selling_price' => 'required_if:order_type_id,==,2|gt:0|lte:MRP|regex:/^\d*(\.\d{1,2})?$/',
          //  'purchase_order_date'=>'date_format:Y-m-d H:i:s',
                  
            'stock_quantity' => 'required|integer',
            'total_amount' =>  'required|gt:0|regex:/^\d*(\.\d{1,2})?$/',
            'payment_status_id' => 'required|integer|exists:conf_payment_statuses,id',
            'payment_date'=>'date_format:Y-m-d',
            'comments'=>'string',            
            'status_id' => 'required|integer|exists:conf_statuses,id',
        ];
        if($request->method()=='PATCH'){
            $rules = [
                'item_id' => 'sometimes|required|integer|exists:items,id',
                'variant_id' => 'sometimes|required|integer|exists:item_variants,id',
                'supplier_id' => 'sometimes|required|integer|exists:suppliers,id',
                'vendor_id' => 'sometimes|required|integer|exists:vendors,id',
                'vendor_store_id' => 'sometimes|required|integer|exists:vendor_stores,id',
                'order_ref'=>'sometimes|string',
                'order_date'=>'sometimes|date_format:Y-m-d',
                'order_type_id' => 'sometimes|required|integer|exists:conf_order_types,id',
                'MRP' => 'sometimes|gt:0|regex:/^\d*(\.\d{1,2})?$/',
                'purchase_price'=>'sometimes|required_if:order_type_id,==,1|regex:/^\d*(\.\d{1,2})?$/',    
                'selling_price' => 'sometimes|required_if:order_type_id,==,2|gt:0|lte:MRP|regex:/^\d*(\.\d{1,2})?$/',
              //  'purchase_order_date'=>'date_format:Y-m-d H:i:s',
                      
                'stock_quantity' => 'sometimes|required|integer',
                'total_amount' =>  'sometimes|required|gt:0|regex:/^\d*(\.\d{1,2})?$/',
                'payment_status_id' => 'sometimes|required|integer|exists:conf_payment_statuses,id',
                'payment_date'=>'sometimes|date_format:Y-m-d',
                'comments'=>'sometimes|string',            
                'status_id' => 'sometimes|required|integer|exists:conf_statuses,id',
            ];
        }
        $this->validate($request, $rules);        
        $stockTracker->update($request->except('created_by'));
        return $this->response->item($stockTracker->fresh(), new StockTrackerTransformer());
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Entities\Stock\StockTracker  $stockTracker
     * @return \Illuminate\Http\Response
     */
    public function destroy(StockTracker $stockTracker)
    {       
        $stockTracker->delete();
        return $this->response->noContent();
        //
    }
}
