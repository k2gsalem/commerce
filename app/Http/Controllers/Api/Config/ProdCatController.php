<?php

namespace App\Http\Controllers\Api\Config;

use App\Entities\Assets\Asset;
use App\Entities\Config\ConfStatus;
use App\Entities\Config\ProdCat;
use App\Http\Controllers\Controller;
use App\Transformers\Config\ProdCatTransformer;
use Dingo\Api\Routing\Helpers;
use Illuminate\Http\Request;

class ProdCatController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    use Helpers;
    protected $model;

    public function __construct(ProdCat $model)
    {
        $this->model = $model;
        // $this->middleware('permission:List users')->only('index');
        // $this->middleware('permission:List users')->only('show');
        // $this->middleware('permission:Create users')->only('store');
        // $this->middleware('permission:Update users')->only('update');
        // $this->middleware('permission:Delete users')->only('destroy');
    }

    public function index(Request $request)
    {
        //
        $paginator = $this->model->paginate($request->get('limit', config('app.pagination_limit')));
        if ($request->has('limit')) {
            $paginator->appends('limit', $request->get('limit'));
        }


        return $this->response->paginator($paginator, new ProdCatTransformer());
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
            'category_short_code' => 'required|max:300',
            'category_desc' => 'required|max:300',
            'category_desc' => 'required|max:300',
            'status_id' => 'required|numeric',
            'created_by' => 'required|numeric',
            'updated_by' => 'required|numeric',
        ]);
        ConfStatus::findOrFail($request->status_id);
        $proCat = $this->model->create($request->all());
        // $assets =$this->api->attach(['file'=>$request->file])->post('api/assets');

        $assets = $this->api->post('api/assets', ['url' => $request->url]);
        $proCat->assets()->save($assets);
        //  $assets->imageable()->save($proCat);
        return $this->response->created(url('api/proCat/' . $proCat->id));

        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Entities\Config\ProdCat  $prodCat
     * @return \Illuminate\Http\Response
     */
    public function show(ProdCat $prodCat)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Entities\Config\ProdCat  $prodCat
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ProdCat $prodCat)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Entities\Config\ProdCat  $prodCat
     * @return \Illuminate\Http\Response
     */
    public function destroy(ProdCat $prodCat)
    {
        //
    }
}
