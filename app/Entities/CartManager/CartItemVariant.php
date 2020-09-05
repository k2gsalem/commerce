<?php

namespace App\Entities\CartManager;

use App\Entities\Catalogue\ItemVariant;
use App\Entities\Catalogue\ItemVariantGroup;
use App\Entities\Config\ConfStatus;
use App\Entities\Vendor\VendorStore;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Auditable as AuditingAuditable;
use OwenIt\Auditing\Contracts\Auditable;

class CartItemVariant extends Model implements Auditable
{
    //
    use AuditingAuditable, SoftDeletes;
    protected $fillable = [
        'cart_item_id',
        'item_variant_id',
        'variant_group_id',
        'item_selling_price',
        'item_discount_percentage',
        'item_discount_amount',
        'item_quantity',
        'vendor_store_id',
        'status_id',
        'created_by',
        'updated_by',
    ];
    // public function conStatus()
    // {
    //     return $this->hasOne(ConfStatus::class, 'id', 'status_id');
    // }
    public function confStatus()
    {
        return $this->belongsTo('App\Entities\Config\ConfStatus');
    }
    public function cartItem()
    {
        return $this->belongsTo(CartItem::class, 'cart_item_id', 'id');
    }
    public function itemVariant()
    {
        return $this->belongsTo(ItemVariant::class, 'item_id', 'id');
    }
    public function variantGroup()
    {
        return $this->belongsTo(ItemVariantGroup::class, 'variant_group_id', 'id');
    }

    public function vendorStore()
    {
        return $this->belongsTo(VendorStore::class, 'vendor_store_id', 'id');
    }
}
