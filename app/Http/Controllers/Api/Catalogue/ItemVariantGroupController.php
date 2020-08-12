<?php

namespace App\Http\Controllers\Api\Catalogue;

use App\Entities\Catalogue\ItemVariantGroup;
use App\Http\Controllers\Controller;
use App\Transformers\Catalogue\ItemVariantGroupTransformer;
use Dingo\Api\Routing\Helpers;
use Illuminate\Http\Request;

class ItemVariantGroupController extends Controller
{
    use Helpers;
    protected $model;
    public function __construct(ItemVariantGroup $model)
    {
        $this->model = $model;
        // $this->middleware('permission:List item variant group')->only('index');
        // $this->middleware('permission:List item variant group')->only('show');        
        $this->middleware('permission:Create item variant group')->only('store');
        $this->middleware('permission:Update item variant group')->only('update');
        $this->middleware('permission:Delete item variant group')->only('destroy');
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
        return $this->response->paginator($paginator, new ItemVariantGroupTransformer());
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
            'item_group_desc' => 'required|string|min:1|max:50',
            'status_id' => 'required|integer|exists:conf_statuses,id',
        ];
        $this->validate($request, $rules);
        $itemVariantGroup = $this->model->create($request->all());
        return $this->response->created(url('api/itemVariantGroup/' . $itemVariantGroup->id));
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Entities\Catalogue\ItemVariantGroup  $itemVariantGroup
     * @return \Illuminate\Http\Response
     */
    public function show(ItemVariantGroup $itemVariantGroup)
    {
        return $this->response->item($itemVariantGroup, new ItemVariantGroupTransformer());
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Entities\Catalogue\ItemVariantGroup  $itemVariantGroup
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ItemVariantGroup $itemVariantGroup)
    {
        $request['updated_by'] = $request->user()->id;
        $rules = [
            'item_id' => 'required|integer|exists:items,id',
            'item_group_desc' => 'required|string|min:1|max:50',
            'status_id' => 'required|integer|exists:conf_statuses,id',
        ];
        if ($request->method() == 'PATCH') {
            $rules = [
                'item_id' => 'sometimes|required|integer|exists:items,id',
                'item_group_desc' => 'sometimes|required|string|min:1|max:50',
                'status_id' => 'sometimes|required|integer|exists:conf_statuses,id',
            ];
        }
        $this->validate($request, $rules);
        $itemVariantGroup->update($request->except('created_by'));
        return $this->response->item($itemVariantGroup->fresh(), new ItemVariantGroupTransformer());
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Entities\Catalogue\ItemVariantGroup  $itemVariantGroup
     * @return \Illuminate\Http\Response
     */
    public function destroy(ItemVariantGroup $itemVariantGroup)
    {
        $itemVariantGroup->delete();
        return $this->response->noContent();
        //
    }
}
