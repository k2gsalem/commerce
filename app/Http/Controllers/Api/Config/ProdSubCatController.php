<?php

namespace App\Http\Controllers\Api\Config;

use App\Entities\Assets\Asset;
use App\Entities\Config\ProdSubCat;
use App\Http\Controllers\Controller;
use App\Transformers\Config\ProdSubCatTransformer;
use Dingo\Api\Routing\Helpers;
use Illuminate\Http\Request;

class ProdSubCatController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    use Helpers;
    protected $model;

    public function __construct(ProdSubCat $model)
    {
        $this->model = $model;
        // $this->middleware('permission:List product sub category')->only('index');
        // $this->middleware('permission:List product sub category')->only('show');
        $this->middleware('permission:Create product sub category')->only('store');
        $this->middleware('permission:Update product sub category')->only('update');
        $this->middleware('permission:Delete product sub category')->only('destroy');
    }
    public function index(Request $request)
    {
        //
        $paginator = $this->model->paginate($request->get('limit', config('app.pagination_limit')));
        if ($request->has('limit')) {
            $paginator->appends('limit', $request->get('limit'));
        }

        return $this->response->paginator($paginator, new ProdSubCatTransformer());

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
            'category_id' => 'required|exists:prod_cats,id',
            'sub_category_short_code' => 'required|unique:prod_sub_cats,sub_category_short_code|string|min:3|max:20',
            'sub_category_desc' => 'required|string|min:5|max:300',
            'file' => 'array',
            'file.*' => 'image|mimes:jpeg,jpg,png|max:2048',
            'status_id' => 'required|integer|exists:conf_statuses,id',
            // 'created_by' => 'required|integer|exists:users,id',
            // 'updated_by' => 'required|integer|exists:users,id'
        ];
        $this->validate($request, $rules);
        $proSubCat = $this->model->create($request->all());
        if ($request->has('file')) {
            foreach ($request->file as $file) {
                $assets = $this->api->attach(['file' => $file])->post('api/assets');                
                $proSubCat->assets()->save($assets);

            }
        } else if ($request->has('url')) {
            $assets = $this->api->post('api/assets', ['url' => $request->url]);
            // $proSubCat = $this->model->create($request->all());
            $proSubCat->assets()->save($assets);

        } else if ($request->has('uuid')) {
            $a = Asset::byUuid($request->uuid)->get();
            $assets = Asset::findOrFail($a[0]->id);
            // $proSubCat = $this->model->create($request->all());
            $proSubCat->assets()->save($assets);

        } 
        return $this->response->created(url('api/prodSubCat/' . $proSubCat->id));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Entities\Config\ProdSubCat  $prodSubCat
     * @return \Illuminate\Http\Response
     */
    public function show(ProdSubCat $prodSubCat)
    {
        return $this->response->item($prodSubCat, new ProdSubCatTransformer());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Entities\Config\ProdSubCat  $prodSubCat
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ProdSubCat $prodSubCat)
    {
        $request['updated_by'] = $request->user()->id;
        $rules = [
            'category_id' => 'required|exists:prod_cats,id',
            'sub_category_short_code' => 'required|string|min:3|max:20|unique:prod_sub_cats,sub_category_short_code,' . $prodSubCat->id,
            'sub_category_desc' => 'required|string|min:5|max:300',
            'status_id' => 'required|integer|exists:conf_statuses,id',
        ];
        if ($request->method() == 'PATCH') {
            $rules = [
                'category_id' => 'sometimes|required|exists:prod_cats,id',
                'sub_category_short_code' => 'sometimes|required|string|min:3|max:20|unique:prod_sub_cats,sub_category_short_code,' . $prodSubCat->id,
                'sub_category_desc' => 'sometimes|required|string|min:5|max:300',
                'status_id' => 'sometimes|required|integer|exists:conf_statuses,id',
            ];
        }
        $this->validate($request, $rules);
        $prodSubCat->update($request->except('created_by'));
        if ($request->has('file')) {
            foreach ($request->file as $file) {
                $assets = $this->api->attach(['file' => $file])->post('api/assets');
                $prodSubCat->assets()->save($assets);
            }
        }
        return $this->response->item($prodSubCat->fresh(), new ProdSubCatTransformer());
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Entities\Config\ProdSubCat  $prodSubCat
     * @return \Illuminate\Http\Response
     */
    public function destroy(ProdSubCat $prodSubCat)
    {
        $record = $this->model->findOrFail($prodSubCat->id);
        $record->delete();
        return $this->response->noContent();
    }
}
