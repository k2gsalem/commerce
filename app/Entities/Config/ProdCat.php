<?php

namespace App\Entities\Config;

use Illuminate\Database\Eloquent\Model;

use OwenIt\Auditing\Auditable as AuditingAuditable;
use OwenIt\Auditing\Contracts\Auditable;


class ProdCat extends Model implements Auditable
{
    //

    use AuditingAuditable;

    protected $fillable = [
        'category_short_code','category_desc','category_image','status_id', 'created_by', 'updated_by',
    ];
  
}
