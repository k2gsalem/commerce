<?php

namespace App\Entities\Catalogue;

use App\Entities\Assets\Asset;
use App\Entities\CartManager\CartItem;
use App\Entities\Config\ConfStatus;
use App\Entities\Config\ProdCat;
use App\Entities\Config\ProdSubCat;
use App\Entities\Stock\StockMaster;
use App\Entities\Stock\StockTracker;
use App\Entities\Vendor\Supplier;
use App\Entities\Vendor\Vendor;
use App\Entities\Vendor\VendorStore;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Auditable as AuditingAuditable;
use OwenIt\Auditing\Contracts\Auditable;
use Spatie\Searchable\Searchable;
use Spatie\Searchable\SearchResult;
use App\Transformers\Catalogue\ItemTransfomer;
use Dingo\Api\Routing\Helpers;

class Item extends Model implements Auditable,Searchable
{
    use AuditingAuditable, SoftDeletes,Helpers;

  
    protected $fillable = [
        'category_id',
        'sub_category_id',
        'item_code',
        'item_desc',
        'title',
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
        'status_id',
        'created_by',
        'updated_by',
    ];

    public function getSearchResult(): SearchResult
    {
        $url = route('item.show', $this->id);

        return new SearchResult(
            $this,
            $this->title,
            $this->item_desc,
            $url
         );

        // return $this->response->item($this->id, new ItemTransfomer());
    }

    public function Category()
    {
        return $this->belongsTo(ProdCat::class, 'category_id');
    }
    public function subCategory()
    {
        return $this->belongsTo(ProdSubCat::class, 'sub_category_id');
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
        return $this->belongsTo(Supplier::class, 'supplier_id');
    }
    public function confStatus()
    {
        return $this->belongsTo('App\Entities\Config\ConfStatus','status_id');
    }

    // public function confStatus()
    // {
    //     return $this->hasOne('App\Entities\Config\ConfStatus', 'id', 'status_id');
    // }
    public function itemVariants()
    {
        return $this->hasMany(ItemVariant::class, 'item_id');
    }
    public function itemVariantGroups()
    {
        return $this->hasMany(ItemVariantGroup::class, 'item_id');
    }
    public function stock()
    {
        return $this->hasMany(StockMaster::class, 'item_id');
    }
    public function stockTrackers()
    {
        return $this->hasMany(StockTracker::class, 'item_id');
    }
    public function assets()
    {
        return $this->morphMany(Asset::class, 'imageable');
    }
    public function cartItem()
    {
        return $this->hasMany(CartItem::class, 'item_id');
    }
}
