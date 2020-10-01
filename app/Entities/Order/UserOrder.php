<?php

namespace App\Entities\Order;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Auditable as AuditingAuditable;
use OwenIt\Auditing\Contracts\Auditable;

class UserOrder extends Model implements Auditable
{
    use AuditingAuditable, SoftDeletes;
    protected $fillable = [
        'user_id',
        'vendor_store_id',
        'order_status_id',
        'order_type',
        'user_address_id',
        'order_amount',
        'order_date',
        'created_by',
        'updated_by',
    ];
    //
}
