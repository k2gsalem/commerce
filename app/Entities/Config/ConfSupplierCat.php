<?php

namespace App\Entities\Config;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Auditable as AuditingAuditable;
use OwenIt\Auditing\Contracts\Auditable;

class ConfSupplierCat extends Model implements Auditable
{
    //

    use AuditingAuditable;

    protected $fillable = [
        'supplier_cat_desc', 'status_id', 'created_by', 'updated_by',
    ];
    public function confStatus()
    {
        return $this->hasOne(ConfStatus::class,'id','status_id');
        # code...n
    }
    public function supplier()
    {
        return $this->belongsTo('App\Entities\Vendor\Supplier','supplier_category_id','id');
    }
   

}
