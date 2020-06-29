<?php

namespace App\Entities\Config;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Auditable as AuditingAuditable;
use OwenIt\Auditing\Contracts\Auditable;

class ConfStatus extends Model implements Auditable
{
    use AuditingAuditable;
    protected $fillable = [
        'status_desc', 'created_by', 'updated_by',
    ];
       

    // protected $hidden = [
    //     'updated_at','created_by'
    //     ];

    //
}
