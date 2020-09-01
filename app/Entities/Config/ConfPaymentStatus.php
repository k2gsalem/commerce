<?php

namespace App\Entities\Config;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Auditable as AuditingAuditable;
use OwenIt\Auditing\Contracts\Auditable;

class ConfPaymentStatus extends Model implements Auditable
{
    use AuditingAuditable,SoftDeletes;
   

    protected $fillable = [
        'payment_status_desc','title', 'created_by', 'updated_by'
    ];

    public function stockTracker()
    {
        return $this->belongsToMany(StockTracker::class, 'payment_status_id','id');
    }
}
