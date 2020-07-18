<?php

namespace App\Http\Controllers\Api\Config;

use App\Entities\Config\ConfStatus;
use App\Http\Controllers\Controller;
use App\Transformers\Config\ConfStatusTransformer;
use Dingo\Api\Routing\Helpers;
use Illuminate\Http\Request;

class ConfStatusController extends Controller
{
    use Helpers;    
    protected $model;
    public function __construct(ConfStatus $model)
    {
        $this->model = $model;
        $this->middleware('permission:List config status')->only('index');
        $this->middleware('permission:List config status')->only('show');
        $this->middleware('permission:Create config status')->only('store');
        $this->middleware('permission:Update config status')->only('update');
        $this->middleware('permission:Delete config status')->only('destroy');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // $cs = $this->model::all();
        // return $cs->audits;
        $paginator = $this->model->paginate($request->get('limit', config('app.pagination_limit')));
        if ($request->has('limit')) {
            $paginator->appends('limit', $request->get('limit'));
        }      
       
        return $this->response->paginator($paginator, new ConfStatusTransformer());

        // return $this->response->Collection($this->model->all(), new ConfStatusTransformer());
        // $cs = $this->model::all();
        // return $this->response->item($cs, new ConfStatusTransformer());  
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //  return $request->user()->id;
        $request['created_by']=$request->user()->id;
        $request['updated_by']=$request->user()->id;  
       
        $rules=[
            'status_desc' => 'required|string|min:1|max:300'         
        ];  
        
        $this->validate($request,$rules);
        $confStatus = $this->model->create($request->all());
        return $this->response->created(url('api/confStatus/'.$confStatus->id));
      
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Entities\Config\ConfStatus  $confStatus
     * @return \Illuminate\Http\Response
     */
    public function show(ConfStatus $confStatus)
    {
        return $this->response->item($confStatus, new ConfStatusTransformer());
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Entities\Config\ConfStatus  $confStatus
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ConfStatus $confStatus)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Entities\Config\ConfStatus  $confStatus
     * @return \Illuminate\Http\Response
     */
    public function destroy(ConfStatus $confStatus)
    {       
        $record = $this->model->findOrFail($confStatus->id);
        $record->delete();
        return $this->response->noContent();
        //
    }
}
