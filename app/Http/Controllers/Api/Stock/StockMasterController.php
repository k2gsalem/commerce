<?php

namespace App\Http\Controllers\Api\Stock;

use App\Entities\Stock\StockMaster;
use App\Http\Controllers\Controller;
use App\Transformers\Stock\StockMasterTransformer;
use Dingo\Api\Routing\Helpers;
use Illuminate\Http\Request;

class StockMasterController extends Controller
{
    use Helpers;
    protected $model;

    public function __construct(StockMaster $model)
    {
        $this->model = $model;
        $this->middleware('permission:List stock')->only('index');
        $this->middleware('permission:List stock')->only('show');
        $this->middleware('permission:Create stock')->only('store');
        $this->middleware('permission:Update stock')->only('update');
        $this->middleware('permission:Delete stock')->only('destroy');
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


        return $this->response->paginator($paginator, new StockMasterTransformer());
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
            'variant_id' => 'required|integer|exists:item_variants,id|unique:stock_masters,variant_id',
            'vendor_id' => 'required|integer|exists:vendors,id',
            'stock_quantity' => 'required|integer',
            'stock_threshold' => 'required|integer',
            'status_id' => 'required|integer|exists:conf_statuses,id',
        ];
        $this->validate($request, $rules);
        $stock = $this->model->create($request->all());
        return $this->response->created(url('api/stockMaster/' . $stock->id));
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Entities\Stock\StockMaster  $stockMaster
     * @return \Illuminate\Http\Response
     */
    public function show(StockMaster $stockMaster)
    {
        
     //  $stockMaster= $this->model::findOrFail($id);
        
        return $this->response->item($stockMaster, new StockMasterTransformer());
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Entities\Stock\StockMaster  $stockMaster
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, StockMaster $stockMaster)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Entities\Stock\StockMaster  $stockMaster
     * @return \Illuminate\Http\Response
     */
    public function destroy(StockMaster $stockMaster)
    {
        $record = $this->model->findOrFail($stockMaster->id);
        $record->delete();
        return $this->response->noContent();
    }
}
