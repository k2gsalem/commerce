<?php

namespace App\Entities\Catalogue;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Auditable as AuditingAuditable;
use OwenIt\Auditing\Contracts\Auditable;

class Item extends Model implements Auditable
{
    use AuditingAuditable;
    protected $fillable=[
        'sub_category_id',
        'item_code',
        'item_desc',
        'item_image',
        'vendor_store_id',
        'status_id',
        'created_by',
        'updated_by',
    ];
    
}
