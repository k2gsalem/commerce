<?php

namespace App\Entities\Config;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Auditable as AuditingAuditable;
use OwenIt\Auditing\Contracts\Auditable;

class ConfOrderType extends Model implements Auditable
{
    use AuditingAuditable,SoftDeletes;
   

    protected $fillable = [
        'order_type_desc','title', 'created_by', 'updated_by'
    ];

   
    public function stockTracker()
    {
        return $this->belongsToMany(StockTracker::class, 'order_type_id','id');
    }

}
