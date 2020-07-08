<?php

namespace App\Http\Controllers\Api\Catalogue;

use App\Entities\Assets\Asset;
use App\Entities\Catalogue\Item;
use App\Entities\Config\ConfStatus;
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
        $this->validate($request, [    
            'sub_category_id'=>'required|numeric',
            'item_code'=>'required|min:3|max:100',
            'item_desc'=>'required|max:300',           
            'vendor_store_id'=>'required|numeric',
            'status_id'=>'exists:App\Entities\Config\ConfStatus,id',
            'created_by'=>'required|numeric',
            'updated_by'=>'required|numeric',                       
        ]);
        ConfStatus::findOrFail($request->status_id);
        $item = $this->model->create($request->all());
        if($request->has('file')){
            foreach($request->file as $file){
                $assets =$this->api->attach(['file'=>$file])->post('api/assets');
                $item->assets()->save($assets);
            }
        }else if($request->has('url')){
            $assets = $this->api->post('api/assets', ['url' => $request->url]);
            $item->assets()->save($assets);
        }else if($request->has('uuid')){
            $a=Asset::byUuid($request->uuid)->get();
            $assets= Asset::findOrFail($a[0]->id);
            $item->assets()->save($assets);         

        } 
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
