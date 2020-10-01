<?php

namespace App\Entities\Config;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Auditable as AuditingAuditable;
use OwenIt\Auditing\Contracts\Auditable;

class ConfOrderStatus extends Model implements Auditable
{
    use AuditingAuditable,SoftDeletes;
    //
    protected $fillable = ['status_desc', 'created_by', 'updated_by'];


}