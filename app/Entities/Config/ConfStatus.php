<?php

namespace App\Entities\Config;

use App\Entities\Catalogue\Item;
use App\Entities\Catalogue\ItemVariant;
use App\Entities\Stock\StockMaster;
use App\Entities\Vendor\Supplier;
use App\Entities\Vendor\Vendor;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Auditable as AuditingAuditable;
use OwenIt\Auditing\Contracts\Auditable;

class ConfStatus extends Model implements Auditable
{
    use AuditingAuditable;
    protected $fillable = [
        'status_desc', 'created_by', 'updated_by'
    ];

    public function confSupplierCat()
    {
        return $this->belongsToMany(ConfSupplierCat::class, 'status_id','id');
    }
    public function confVendorCat()
    {
        return $this->belongsToMany(ConfVendorCat::class, 'status_id','id');
    }
    public function prodCat()
    {
        return $this->belongsToMany(ProdCat::class,'status_id','id');
    }
    public function prodSubCat()
    {
        return $this->belongsToMany(ProdSubCat::class, 'status_id','id');
    }
    public function vendor()
    {
        return $this->belongsToMany(Vendor::class, 'status_id','id');
    }
    public function supplier()
    {
        return $this->belongsToMany(Supplier::class, 'status_id','id');
    }
    public function item()
    {
        return $this->belongsToMany(Item::class, 'status_id','id');
    }
    public function itemVariant()
    {
        return $this->belongsToMany(ItemVariant::class, 'status_id','id');
    }
    public function stock()
    {
        return $this->belongsToMany(StockMaster::class, 'status_id','id');
    }

}
