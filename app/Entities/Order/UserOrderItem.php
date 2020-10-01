<?php

namespace App\Entities\Order;

use App\Entities\Catalogue\Item;
use App\Entities\Vendor\VendorStore;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Auditable as AuditingAuditable;
use OwenIt\Auditing\Contracts\Auditable;

class UserOrderItem extends Model implements Auditable
{
    use AuditingAuditable, SoftDeletes;
    protected $fillable = [
        'order_id',
        'item_id',
        'vendor_store_id',
        'item_quantity',
        'item_selling_price',
        'item_discount_amount',
        'item_discount_percentage',
        'created_by',
        'updated_by',
    ];
    //
    public function userOrder()
    {
        return $this->belongsTo(UserOrder::class, 'order_id');
    }
    public function item()
    {
        return $this->belongsTo(Item::class, 'item_id');
    }
    public function vendorStore()
    {
        return $this->belongsTo(VendorStore::class, 'vendor_store_id');
    }
}
