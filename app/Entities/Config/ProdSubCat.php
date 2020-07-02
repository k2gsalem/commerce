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
        'category_id',
        'sub_category_short_code',
        'sub_category_desc',
        'sub_category_image',
        'status_id',
        'created_by',
        'updated_by',
    ];
    public function confStatus()
    {
        return $this->hasOne('App\Entities\Config\ConfStatus','id','status_id');
       
    }

    public function item()
    {
        return $this->belongsTo('App\Entities\Catalogue\Item','sub_category_id','id');
    }
    public function category()
    {
        return $this->belongsTo(ProdCat::class,'category_id','id');
    }
}
