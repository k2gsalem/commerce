<?php

namespace App\Entities\Assets;

use App\Support\UuidScopeTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Auditable as AuditingAuditable;
use OwenIt\Auditing\Contracts\Auditable;

/**
 * Class Asset.
 */
class Asset extends Model implements Auditable
{
    use UuidScopeTrait,AuditingAuditable,SoftDeletes;

    /**
     * @var array
     */
    protected $guarded = ['id'];
    
    public function imageable()
    {
        return $this->morphTo();
    }
}
