<?php

namespace App\Http\Controllers\Api\Config;

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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Entities\Config\ProdSubCat  $prodSubCat
     * @return \Illuminate\Http\Response
     */
    public function show(ProdSubCat $prodSubCat)
    {
        //
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
        //
    }
}
