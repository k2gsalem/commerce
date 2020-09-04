<?php

namespace App\Http\Controllers\Api\Vendor;

use App\Entities\Assets\Asset;
use App\Entities\Vendor\Supplier;
use App\Http\Controllers\Controller;
use App\Transformers\Vendor\SupplierTransformer;
use Dingo\Api\Routing\Helpers;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    use Helpers;
    protected $model;
    public function __construct(Supplier $model)
    {
        $this->model = $model;
        $this->middleware('permission:List supplier')->only('index');
        $this->middleware('permission:List supplier')->only('show');
        $this->middleware('permission:Create supplier')->only('store');
        $this->middleware('permission:Update supplier')->only('update');
        $this->middleware('permission:Delete supplier')->only('destroy');
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

        return $this->response->paginator($paginator, new SupplierTransformer());
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
            'supplier_name' => 'required|string',
            'file' => 'array',
            'file.*' => 'image|mimes:jpeg,jpg,png|max:1024',
            'supplier_category_id' => 'required|exists:conf_supplier_cats,id',
            'supplier_desc' => 'required|string|min:5|max:300',
            'supplier_address' => 'required|string|max:200',
            'supplier_contact' => 'required|numeric|min:10|unique:suppliers,supplier_contact',
            'supplier_email' => 'required|email|unique:suppliers,supplier_email',
            'status_id' => 'required|integer|exists:conf_statuses,id',
        ];
        $this->validate($request, $rules);
        $supplier = $this->model->create($request->all());

        if ($request->has('file')) {
            foreach ($request->file as $file) {
                $assets = $this->api->attach(['file' => $file])->post('api/assets');
                // $supplier = $this->model->create($request->all());
                $supplier->assets()->save($assets);
            }
        } else if ($request->has('url')) {
            $assets = $this->api->post('api/assets', ['url' => $request->url]);
            // $supplier = $this->model->create($request->all());
            $supplier->assets()->save($assets);
        } else if ($request->has('uuid')) {
            $a = Asset::byUuid($request->uuid)->get();
            $assets = Asset::findOrFail($a[0]->id);
            // $supplier = $this->model->create($request->all());
            $supplier->assets()->save($assets);

        }
        return $this->response->created(url('api/suppliers/' . $supplier->id));
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Entities\Vendor\Supplier  $supplier
     * @return \Illuminate\Http\Response
     */
    public function show(Supplier $supplier)
    {
        return $this->response->item($supplier, new SupplierTransformer());
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Entities\Vendor\Supplier  $supplier
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Supplier $supplier)
    {
        $request['updated_by'] = $request->user()->id;
        $rules = [
            'supplier_name' => 'required|string',
            'file' => 'array',
            'file.*' => 'image|mimes:jpeg,jpg,png|max:1024',
            'supplier_category_id' => 'required|exists:conf_supplier_cats,id',
            'supplier_desc' => 'required|string|min:5|max:300',
            'supplier_address' => 'required|string|max:200',
            'supplier_contact' => 'required|numeric|min:10|unique:suppliers,supplier_contact,'.$supplier->id,
            'supplier_email' => 'required|email|unique:suppliers,supplier_email,'.$supplier->id,
            'status_id' => 'required|integer|exists:conf_statuses,id',
        ];
        if ($request->method() == 'PATCH') {
            $rules = [
                'supplier_name' => 'sometimes|required|string',
                'file' => 'array',
                'file.*' => 'sometimes|image|mimes:jpeg,jpg,png|max:1024',
                'supplier_category_id' => 'sometimes|required|exists:conf_supplier_cats,id',
                'supplier_desc' => 'sometimes|required|string|min:5|max:300',
                'supplier_address' => 'sometimes|required|string|max:200',
                'supplier_contact' => 'sometimes|required|numeric|min:10|unique:suppliers,supplier_contact,'.$supplier->id,
                'supplier_email' => 'sometimes|required|email|unique:suppliers,supplier_email,'.$supplier->id,
                'status_id' => 'sometimes|required|integer|exists:conf_statuses,id',
            ];

        }
        $this->validate($request, $rules);
        $supplier->update($request->except('created_by'));
        if ($request->has('file')) {
            foreach ($request->file as $file) {
                $assets = $this->api->attach(['file' => $file])->post('api/assets');
                $supplier->assets()->save($assets);
            }
        }
        return $this->response->item($supplier->fresh(), new SupplierTransformer());
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Entities\Vendor\Supplier  $supplier
     * @return \Illuminate\Http\Response
     */
    public function destroy(Supplier $supplier)
    {
        $supplier->assets()->delete();

        
        if ($supplier->stockTrackers()->count()) {
            $response = array(
                'message' => 'Cannot delete: This supplier has stock tracker!'
            );
            return response()->json($response, 403);

            // return $this->response('Cannot delete: this project has transactions');
        }

        if ($supplier->items()->count()) {
            $response = array(
                'message' => 'Cannot delete: This supplier has items!'
            );
            return response()->json($response, 403);

            // return $this->response('Cannot delete: this project has transactions');
        }

        if ($supplier->variant()->count()) {
            $response = array(
                'message' => 'Cannot delete: This supplier has item variants!'
            );
            return response()->json($response, 403);

            // return $this->response('Cannot delete: this project has transactions');
        }
        
        $supplier->delete();
        // $record = $this->model->findOrFail($supplier->id);
        // $record->delete();
        return $this->response->noContent();
    }
}
