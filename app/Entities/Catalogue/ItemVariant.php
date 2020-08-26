<?php

namespace App\Entities\Catalogue;

use App\Entities\Assets\Asset;
use App\Entities\Config\ConfStatus;
use App\Entities\Stock\StockMaster;
use App\Entities\Stock\StockTracker;
use App\Entities\Vendor\Supplier;
use App\Entities\Vendor\Vendor;
use App\Entities\Vendor\VendorStore;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Auditable as AuditingAuditable;
use OwenIt\Auditing\Contracts\Auditable;

class ItemVariant extends Model implements Auditable
{
    use SoftDeletes, AuditingAuditable;
    protected $fillable = [
        'item_id',
        'variant_code',
        'variant_group_id',
        'variant_desc',
        'min_order_quantity',
        'min_order_amount',  
        'max_order_quantity',
        'max_order_amount',
        'discount_percentage',
        'discount_amount',
        'quantity',
        'threshold',
        'supplier_id',
        // 'item_image',
        'vendor_id',
        'vendor_store_id',
        'MRP',
        'selling_price',
        'default',
        'status_id',
        'created_by',
        'updated_by',
    ];
    public function item()
    {
        return $this->belongsTo(Item::class);
    }
    public function conStatus()
    {
        return $this->hasOne(ConfStatus::class, 'id', 'status_id');
    }
    public function vendorStore()
    {
        return $this->belongsTo(VendorStore::class, 'vendor_store_id');
    }
    public function vendor()
    {
        return $this->belongsTo(Vendor::class, 'vendor_id');
    }
    public function Supplier()
    {
        return $this->belongsTo(Supplier::class,'supplier_id');
    }
    public function stock()
    {
        return $this->hasMany(StockMaster::class, 'variant_id');
    }
    public function assets()
    {
        return $this->morphMany(Asset::class, 'imageable');
    }
    public function variantGroup()
    {
        return $this->belongsTo(ItemVariantGroup::class);
    }
    public function stockTrackers()
    {
        return $this->hasMany(StockTracker::class, 'variant_id');
    }
    //
}
