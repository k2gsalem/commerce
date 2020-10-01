<?php

namespace App\Entities\Vendor;

use App\Entities\Assets\Asset;
use App\Entities\CartManager\CartItem;
use App\Entities\CartManager\CartItemVariant;
use App\Entities\Catalogue\Item;
use App\Entities\Order\UserOrder;
use App\Entities\Order\UserOrderItem;
use App\Entities\Stock\StockMaster;
use App\Entities\Stock\StockTracker;
use App\Entities\Vendor\Vendor;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Auditable as AuditingAuditable;
use OwenIt\Auditing\Contracts\Auditable;

class VendorStore extends Model implements Auditable
{

    use SoftDeletes, AuditingAuditable;
    protected $fillable = [
        'vendor_id',
        // 'vendor_logo',
        'vendor_store_name',
        'vendor_store_location',
        'vendor_store_address',
        'vendor_store_contact',
        'latitude',
        'longitude',
        'status_id',
        'created_by',
        'updated_by',
    ];
    // public function confStatus()
    // {
    //     return $this->hasOne('App\Entities\Config\ConfStatus', 'id', 'status_id');
    // }
    public function confStatus()
    {
        return $this->belongsTo('App\Entities\Config\ConfStatus','status_id');
    }
    public function Vendor()
    {
        return $this->belongsTo(Vendor::class, 'vendor_id');
    }
    public function items()
    {
        return $this->hasMany(Item::class, 'vendor_store_id');
    }
    public function itemVariants()
    {
        return $this->hasMany(ItemVariant::class, 'vendor_store_id');
    }
    public function stockMaster()
    {
        return $this->hasOne('App\Entities\Stock\stockMaster', 'id', 'vendor_store_id');
    }
    public function stockTrackers()
    {
        return $this->hasMany(StockTracker::class, 'item_id');
    }
    public function assets()
    {
        return $this->morphMany(Asset::class, 'imageable');
    }
    public function cartItems()
    {
        return $this->hasMany(CartItem::class, 'vendor_store_id');
    }
    public function cartItemVariants()
    {
        return $this->hasMany(CartItemVariant::class, 'vendor_store_id');
    }
    public function userOrders()
    {
        return $this->hasMany(UserOrder::class, 'vendor_store_id');
    }
    public function userOrderItems()
    {
        return $this->hasMany(UserOrderItem::class, 'vendor_store_id');
    }

}
