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

    public function confSupplierCat()
    {
        return $this->belongsToMany('App\Entities\Config\ConfSupplierCat','status_id');
        # code...
    }
    public function confVendorCat()
    {
        return $this->belongsToMany('App\Entities\Config\ConfVendorCat','status_id');
        # code...
    }
    public function prodCat()
    {
        return $this->belongsToMany('App\Entities\Config\ProdCat','status_id');
        
    }
    public function prodSubCat()
    {
        return $this->belongsToMany('App\Entities\Config\ProdSubCat','status_id');      
    }
    public function vendor()
    {
        return $this->belongsToMany('App\Entities\Vendor\Vendor','status_id');      
    }
    public function supplier()
    {
        return $this->belongsToMany('App\Entities\Vendor\Supplier','status_id');      
    }
   
}
