<?php

namespace App\Http\Controllers\Api\Catalogue;

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
        $this->middleware('permission:List item')->only('index');
        $this->middleware('permission:List item')->only('show');
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Entities\Catalogue\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function show(Item $item)
    {
        //
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
        $record = $this->model->findOrFail($item->id);
        $record->delete();
        return $this->response->noContent();
    }
}
