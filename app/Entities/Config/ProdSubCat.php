<?php

namespace App\Entities\Config;

use Illuminate\Database\Eloquent\Model;

use OwenIt\Auditing\Auditable as AuditingAuditable;
use OwenIt\Auditing\Contracts\Auditable;

class ProdSubCat extends Model implements Auditable
{
    //

    use AuditingAuditable;

    protected $fillable = [
        'category_id,sub_category_short_code','sub_category_desc','sub_category_image','status_id', 'created_by', 'updated_by',
    ];
}
