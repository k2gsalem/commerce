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
        return $this->belongsToMany(Vendor::class,'status_id','id');
    }

    public function vendorStore()
    {
        return $this->belongsToMany(VendorStore::class, 'status_id','id');
    }

    public function supplier()
    {
        return $this->belongsToMany(Supplier::class, 'status_id','id');
    }
    public function item()
    {
        return $this->hasMany(Item::class,'status_id');
    }
    public function itemVariant()
    {
        return $this->belongsToMany(ItemVariant::class, 'status_id','id');
    }
    public function itemVariantGroup()
    {
        return $this->belongsToMany(ItemVariantGroup::class, 'status_id','id');
    }
    public function stock()
    {
        return $this->belongsToMany(StockMaster::class, 'status_id','id');
    }
    public function stockTracker()
    {
        return $this->belongsToMany(StockTracker::class, 'status_id','id');
    }
    public function carts()
    {
        return $this->belongsToMany(Cart::class, 'status_id','id');
    }
    public function cartItems()
    {
        return $this->belongsToMany(CartItem::class, 'status_id','id');
    }
    public function cartItemVariants()
    {
        return $this->belongsToMany(CartItemVariant::class, 'status_id','id');
    }

}
