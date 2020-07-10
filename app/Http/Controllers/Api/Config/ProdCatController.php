<?php

namespace App\Http\Controllers\Api\Config;

use App\Entities\Assets\Asset;
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
        $this->middleware('permission:List product category')->only('index');
        $this->middleware('permission:List product category')->only('show');
        $this->middleware('permission:Create product category')->only('store');
        $this->middleware('permission:Update product category')->only('update');
        $this->middleware('permission:Delete product category')->only('destroy');
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
        $request['created_by'] = $request->user()->id;
        $request['updated_by'] = $request->user()->id;
        $rules = [
            'category_short_code' => 'required|string|unique:prod_cats,category_short_code|min:3|max:20',
            'category_desc' => 'required|string|max:300',
            'file' => 'array',
            'file.*' => 'image|mimes:jpeg,jpg,png|max:2048',
            'status_id' => 'required|integer|exists:conf_statuses,id',
            // 'created_by' => 'required|integer|exists:users,id',
            // 'updated_by' => 'required|integer|exists:users,id',
        ];
        $this->validate($request, $rules);

        if ($request->has('file')) {
            foreach ($request->file as $file) {
                $assets = $this->api->attach(['file' => $file])->post('api/assets');
                $proCat = $this->model->create($request->all());
                $proCat->assets()->save($assets);
            }
        } else if ($request->has('url')) {
            $assets = $this->api->post('api/assets', ['url' => $request->url]);
            $proCat = $this->model->create($request->all());
            $proCat->assets()->save($assets);
        } else if ($request->has('uuid')) {
            $a = Asset::byUuid($request->uuid)->get();
            $assets = Asset::findOrFail($a[0]->id);
            $proCat = $this->model->create($request->all());
            $proCat->assets()->save($assets);

        } else {
            $proCat = $this->model->create($request->all());
        }
        return $this->response->created(url('api/proCat/' . $proCat->id));
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
        $record = $this->model->findOrFail($prodCat->id);
        $record->delete();
        return $this->response->noContent();
    }
}
