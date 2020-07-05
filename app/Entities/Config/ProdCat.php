<?php

namespace App\Entities\Config;

use App\Entities\Assets\Asset;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Auditable as AuditingAuditable;
use OwenIt\Auditing\Contracts\Auditable;

class ProdCat extends Model implements Auditable
{
    //

    use AuditingAuditable;

    protected $fillable = [
        'category_short_code', 'category_desc', 'category_image', 'status_id', 'created_by', 'updated_by'
    ];
    public function confStatus()
    {
        return $this->hasOne(ConfStatus::class,'id','status_id');
    }
    public function subCategory()
    {
        return $this->hasMany(ProdSubCat::class, 'category_id','id');
    }
    public function assets()
    {
        return $this->morphMany(Asset::class,'imageable');
    }
}
