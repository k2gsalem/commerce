<?php

namespace App\Entities\Catalogue;

use App\Entities\CartManager\CartItem;
use App\Entities\CartManager\CartItemVariant;
use App\Entities\Config\ConfStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Auditable as AuditingAuditable;
use OwenIt\Auditing\Contracts\Auditable;

class ItemVariantGroup extends Model implements Auditable
{
    use SoftDeletes, AuditingAuditable;
    protected $fillable = [
        'item_id',
        'item_group_desc',
        'title',
        'default',
        'status_id',
        'created_by',
        'updated_by',
    ];
    public function item()
    {
        return $this->belongsTo(Item::class);
    }
    // public function conStatus()
    // {
    //     return $this->hasOne(ConfStatus::class, 'id', 'status_id');
    // }

    public function confStatus()
    {
        return $this->belongsTo('App\Entities\Config\ConfStatus');
    }
    
    public function itemVariants()
    {
        return $this->hasMany(ItemVariant::class, 'variant_group_id');
    }
    public function cartItems()
    {
        return $this->hasMany(CartItem::class, 'variant_group_id');
    }
    public function cartItemVariants()
    {
        return $this->hasMany(CartItemVariant::class, 'variant_group_id');
    }
    //
}
