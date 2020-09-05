<?php

namespace App\Entities\Config;

use App\Entities\CartManager\Cart;
use App\Entities\CartManager\CartItem;
use App\Entities\CartManager\CartItemVariant;
use App\Entities\Catalogue\Item;
use App\Entities\Catalogue\ItemVariant;
use App\Entities\Catalogue\ItemVariantGroup;
use App\Entities\Stock\StockMaster;
use App\Entities\Stock\StockTracker;
use App\Entities\Vendor\Supplier;
use App\Entities\Vendor\Vendor;
use App\Entities\Vendor\VendorStore;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Auditable as AuditingAuditable;
use OwenIt\Auditing\Contracts\Auditable;

class ConfStatus extends Model implements Auditable
{
    use AuditingAuditable,SoftDeletes;
   

    protected $fillable = [
        'status_desc','title', 'created_by', 'updated_by'
    ];

    public function confSupplierCat()
    {
        return $this->hasMany(ConfSupplierCat::class, 'status_id');
    }
    public function confVendorCat()
    {
        return $this->hasMany(ConfVendorCat::class, 'status_id');
    }
    public function prodCat()
    {
        return $this->hasMany(ProdCat::class,'status_id');
    }
    public function prodSubCat()
    {
        return $this->hasMany(ProdSubCat::class, 'status_id');
    }
    public function vendor()
    {
        return $this->hasMany(Vendor::class,'status_id');
    }

    public function vendorStore()
    {
        return $this->hasMany(VendorStore::class, 'status_id');
    }

    public function supplier()
    {
        return $this->hasMany(Supplier::class, 'status_id');
    }
    public function item()
    {
        return $this->hasMany(Item::class,'status_id');
    }
    public function itemVariant()
    {
        return $this->hasMany(ItemVariant::class, 'status_id');
    }
    public function itemVariantGroup()
    {
        return $this->hasMany(ItemVariantGroup::class, 'status_id');
    }
    public function stock()
    {
        return $this->hasMany(StockMaster::class, 'status_id');
    }
    public function stockTracker()
    {
        return $this->hasMany(StockTracker::class, 'status_id');
    }
    public function carts()
    {
        return $this->hasMany(Cart::class, 'status_id');
    }
    public function cartItems()
    {
        return $this->hasMany(CartItem::class, 'status_id');
    }
    public function cartItemVariants()
    {
        return $this->hasMany(CartItemVariant::class, 'status_id');
    }

}
