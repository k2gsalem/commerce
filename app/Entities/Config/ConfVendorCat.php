<?php

namespace App\Entities\Config;

use App\Entities\Vendor\Vendor;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Auditable as AuditingAuditable;
use OwenIt\Auditing\Contracts\Auditable;

class ConfVendorCat extends Model implements Auditable
{
    
    use AuditingAuditable,SoftDeletes;

    protected $fillable = [
        'vendor_cat_desc','title','status_id', 'created_by', 'updated_by',
    ];
    // public function confStatus()
    // {
    //     return $this->hasOne(ConfStatus::class,'id','status_id');
    //     # code...
    // }

    public function confStatus()
    {
        return $this->belongsTo('App\Entities\Config\ConfStatus');
    }
    
    public function vendor()
    {
        return $this->hasMany(Vendor::class,'vendor_category_id');
    }
}
