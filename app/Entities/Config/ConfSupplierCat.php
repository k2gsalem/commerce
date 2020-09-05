<?php

namespace App\Entities\Config;

use App\Entities\Vendor\Supplier;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Auditable as AuditingAuditable;
use OwenIt\Auditing\Contracts\Auditable;

class ConfSupplierCat extends Model implements Auditable
{
    //

    use AuditingAuditable,SoftDeletes;

    protected $fillable = [
        'supplier_cat_desc','title', 'status_id', 'created_by', 'updated_by',
    ];
    // public function confStatus()
    // {
    //     return $this->hasOne(ConfStatus::class,'id','status_id');
    //     # code...n
    // }

    public function confStatus()
    {
        return $this->belongsTo('App\Entities\Config\ConfStatus','status_id');
    }

    public function supplier()
    {
        return $this->hasMany(Supplier::class,'supplier_category_id');
    }
   

}
