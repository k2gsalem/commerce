<?php

namespace App\Entities\Config;

use App\Entities\Assets\Asset;
use Illuminate\Database\Eloquent\Model;
use App\Entities\Catalogue\Item;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Auditable as AuditingAuditable;
use OwenIt\Auditing\Contracts\Auditable;

class ProdCat extends Model implements Auditable
{
    //

    use AuditingAuditable, SoftDeletes;

    protected $fillable = [
        'category_short_code', 'category_desc', 'title','status_id', 'created_by', 'updated_by',
    ];
    // public function confStatus()
    // {
    //     return $this->hasOne(ConfStatus::class, 'id', 'status_id');
    // }

    public function confStatus()
    {
        return $this->belongsTo('App\Entities\Config\ConfStatus');
    }
    
    public function subCategories()
    {
        return $this->hasMany(ProdSubCat::class, 'category_id');
    }
    public function items()
    {
        return $this->hasMany(Item::class,'category_id');
    }
    public function assets()
    {
        return $this->morphMany(Asset::class, 'imageable');
    }
}
