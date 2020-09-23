<?php

namespace App\Entities\CartManager;

use App\Entities\Assets\Asset;
use App\Entities\Catalogue\Item;
use App\Entities\Catalogue\ItemVariantGroup;
use App\Entities\Config\ConfStatus;
use App\Entities\Vendor\VendorStore;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Auditable as AuditingAuditable;
use OwenIt\Auditing\Contracts\Auditable;

class CartItem extends Model implements Auditable
{
    //
    use AuditingAuditable, SoftDeletes;
    protected $fillable = [
        'cart_id',
        'item_id',
        'variant_group_id',
        'item_selling_price',
        'item_discount_percentage',
        'item_discount_amount',
        'item_quantity',
        'vendor_store_id',
        // 'status_id',
        'created_by',
        'updated_by',
    ];
    // public function conStatus()
    // {
    //     return $this->hasOne(ConfStatus::class, 'id', 'status_id');
    // }
    // public function confStatus()
    // {
    //     return $this->belongsTo('App\Entities\Config\ConfStatus','status_id');
    // }
    public function cart()
    {
        return $this->belongsTo(Cart::class, 'cart_id', 'id');
    }
    public function item()
    {
        return $this->belongsTo(Item::class, 'item_id', 'id');
    }
    public function variantGroup()
    {
        return $this->belongsTo(ItemVariantGroup::class, 'variant_group_id', 'id');
    }

    public function vendorStore()
    {
        return $this->belongsTo(VendorStore::class, 'vendor_store_id', 'id');
    }
    public function cartItemVariants()
    {
        return $this->hasMany(CartItemVariant::class, 'cart_item_id');
    }
    public function assets()
    {
        return $this->morphMany(Asset::class, 'imageable');
    }
}
