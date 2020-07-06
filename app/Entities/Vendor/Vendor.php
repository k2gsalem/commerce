<?php

namespace App\Entities\Vendor;

use App\Entities\Catalogue\Item;
use App\Entities\Stock\StockMaster;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Auditable as AuditingAuditable;
use OwenIt\Auditing\Contracts\Auditable;

class Vendor extends Model implements Auditable
{
    use SoftDeletes,AuditingAuditable;
    protected $fillable = [
        'vendor_name',
        'vendor_logo',
        'vendor_category_id',
        'vendor_desc',
        'vendor_address',
        'vendor_contact',
        'vendor_email',
        'status_id',
        'created_by',
        'updated_by',
    ];
    public function confStatus()
    {
        return $this->hasOne('App\Entities\Config\ConfStatus','id','status_id');        
    }
    public function vendorCategory()
    {
        return $this->hasOne('App\Entities\Config\ConfVendorCat','id','vendor_category_id');
       
    }
    public function items()
    {
        return $this->hasMany(Item::class,'vendor_store_id');
    }
    public function stock()
    {
        return $this->hasMany(StockMaster::class,'vendor_id');
    }
    //
}
