<?php

namespace App\Entities\Config;

use Illuminate\Database\Eloquent\Model;

use OwenIt\Auditing\Auditable as AuditingAuditable;
use OwenIt\Auditing\Contracts\Auditable;


class ConfSupplierCat extends Model implements Auditable
{
    //

    use AuditingAuditable;

    protected $fillable = [
        'supplier_cat_desc','status_id', 'created_by', 'updated_by',
    ];
   

}
