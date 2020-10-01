<?php

namespace App\Entities\Order;

use App\Entities\Config\ConfOrderStatus;
use App\Entities\Profile\UserAddress;
use App\Entities\User;
use App\Entities\Vendor\VendorStore;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Auditable as AuditingAuditable;
use OwenIt\Auditing\Contracts\Auditable;

class UserOrder extends Model implements Auditable
{
    use AuditingAuditable, SoftDeletes;
    protected $fillable = [
        'user_id',
        'vendor_store_id',
        'order_status_id',
        'order_type',
        'user_address_id',
        'order_amount',
        'order_date',
        'created_by',
        'updated_by',
    ];
    //
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function orderStatus()
    {
        return $this->belongsTo(ConfOrderStatus::class, 'order_status_id');
    }
    public function vendorStore()
    {
        return $this->belongsTo(VendorStore::class, 'vendor_store_id');
    }
    public function userAddress()
    {
        return $this->belongsTo(UserAddress::class, 'user_address_id');
    }
    public function userOrderItems()
    {
        return $this->hasMany(UserOrderItem::class, 'order_id');
    }
}
