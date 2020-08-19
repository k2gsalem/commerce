<?php

namespace App\Http\Controllers\Api\Audit;

use App\Http\Controllers\Controller;
use Dingo\Api\Routing\Helpers;
use Illuminate\Http\Request;

class AuditController extends Controller
{
    use Helpers;
    protected $model;
    protected $id;
    
   
    public function __construct(Request $request)
    {
        $this->model=$request->model;
        $this->id=$request->id;
    }
    public function show()
    {
    //     $m = $this->model::find($this->id);
    //     $audit = $m->audits()->latest()->first();

    //    return $audit->getMetadata();
        return $this->model::find($this->id)->audits()->with('user')->get();      
    }

   

}
