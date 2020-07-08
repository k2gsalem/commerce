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
        $request['created_by']=$request->user()->id;
        $request['updated_by']=$request->user()->id;
        $rules=[
            'sub_category_id'=>'required|exists:prod_sub_cats,id',
            'item_code'=>'required|srting|min:3|max:100',
            'item_desc'=>'required|string|min:5|max:300',
            'file'=>'file|size:512|mimes:jpeg,jpg,png',           
            'vendor_store_id'=>'required|integer|exists:vendors,id',
            'status_id' => 'required|integer|exists:conf_statuses,id',
            // 'created_by' => 'required|integer|exists:users,id',
            // 'updated_by' => 'required|integer|exists:users,id'  
        ];
        $this->validate($request, $rules);
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
