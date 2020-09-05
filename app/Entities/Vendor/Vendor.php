<?php

namespace App\Entities\Vendor;

use App\Entities\Assets\Asset;
use App\Entities\Catalogue\Item;
use App\Entities\Stock\StockMaster;
use App\Entities\Stock\StockTracker;
use App\Entities\Vendor\VendorStore;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Auditable as AuditingAuditable;
use OwenIt\Auditing\Contracts\Auditable;

class Vendor extends Model implements Auditable
{
    use SoftDeletes,AuditingAuditable;
    protected $fillable = [
        'vendor_name',
        // 'vendor_logo',
        'vendor_category_id',
        'vendor_desc',
        'vendor_address',
        'vendor_contact',
        'vendor_email',
        'status_id',
        'created_by',
        'updated_by',
    ];
    // public function confStatus()
    // {
    //     return $this->hasOne('App\Entities\Config\ConfStatus','id','status_id');        
    // }

    public function confStatus()
    {
        return $this->belongsTo('App\Entities\Config\ConfStatus');
    }
    public function vendorCategory()
    {
        return $this->hasOne('App\Entities\Config\ConfVendorCat','id','vendor_category_id');
       
    }
    public function vendorStores()
    {
        return $this->hasMany(VendorStore::class,'vendor_store_id');
    }
    public function items()
    {
        return $this->hasMany(Item::class,'vendor_id');
    }
    
    public function variant()
    {
        return $this->hasMany(ItemVariant::class,'vendor_id');
    }
    public function stock()
    {
        return $this->hasMany(StockMaster::class,'vendor_id');
    }
    public function stockTrackers()
    {
        return $this->hasMany(StockTracker::class, 'item_id');
    }
    public function assets()
    {
        return $this->morphMany(Asset::class,'imageable');
    }
    //
}
