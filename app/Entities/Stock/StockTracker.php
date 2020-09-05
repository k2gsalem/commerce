<?php

namespace App\Entities\Stock;

use App\Entities\Catalogue\Item;
use App\Entities\Catalogue\ItemVariant;
use App\Entities\Config\ConfStatus;
use App\Entities\Config\ConfOrderType;
use App\Entities\Config\ConfPaymentStatus;
use App\Entities\Vendor\Supplier;
use App\Entities\Vendor\Vendor;
use App\Entities\Vendor\VendorStore;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Auditable as AuditingAuditable;
use OwenIt\Auditing\Contracts\Auditable;

class StockTracker extends Model implements Auditable
{
    use AuditingAuditable,SoftDeletes;
    protected $fillable=[
        'item_id',
        'variant_id',
        'supplier_id',
        'vendor_id',
        'vendor_store_id',
        // 'purchase_order_ref',
        // 'purchase_order_date',
        'order_ref',
        'order_date',
        'order_type_id',
        'MRP',
        'purchase_price',
        'selling_price',
        'stock_quantity',
        'total_amount',
        'payment_status_id',
        'payment_date',
        'comments',
        'status_id',
        'created_by',
        'updated_by'
    ];
    // public function confStatus()
    // {
    //     return $this->hasOne(ConfStatus::class,'id','status_id');
    // }

    public function confStatus()
    {
        return $this->belongsTo('App\Entities\Config\ConfStatus','status_id');
    }
    
    public function confOrderType()
    {
        return $this->hasOne(ConfOrderType::class,'id','order_type_id');
    }
    public function confPaymentStatus()
    {
        return $this->hasOne(confPaymentStatus::class,'id','payment_status_id');
    }
    public function item()
    {
        return $this->belongsTo(Item::class);
    }
    public function variant()
    {
        return $this->belongsTo(ItemVariant::class);
    }
    public function vendor()
    {
        return $this->belongsTo(Vendor::class, 'vendor_id');
    }
    public function vendorStore()
    {
        return $this->belongsTo(VendorStore::class, 'vendor_store_id');
    }
    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }
    //
}
