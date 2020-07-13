<?php

namespace App\Entities\Config;

use App\Entities\Assets\Asset;
use App\Entities\Catalogue\Item;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Auditable as AuditingAuditable;
use OwenIt\Auditing\Contracts\Auditable;

class ProdSubCat extends Model implements Auditable
{
    //

    use AuditingAuditable,SoftDeletes;

    protected $fillable = [
        'category_id',
        'sub_category_short_code',
        'sub_category_desc',
        'sub_category_image',
        'status_id',
        'created_by',
        'updated_by'
    ];
    public function confStatus()
    {
        return $this->hasOne(ConfStatus::class,'id','status_id');
       
    }

    public function items()
    {
        return $this->hasMany(Item::class,'sub_category_id');
    }
    public function category()
    {
        return $this->belongsTo(ProdCat::class,'category_id','id');
    }
    public function assets()
    {
        return $this->morphMany(Asset::class,'imageable');
    }
}
