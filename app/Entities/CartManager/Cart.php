<?php

namespace App\Entities\CartManager;

use App\Entities\Config\ConfStatus;
use App\Entities\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Auditable as AuditingAuditable;
use OwenIt\Auditing\Contracts\Auditable;

class Cart extends Model implements Auditable
{
    //
    use AuditingAuditable, SoftDeletes;
    protected $fillable = [
        'user_id',
        'status_id',
        'created_by',
        'updated_by',
    ];
    public function conStatus()
    {
        return $this->hasOne(ConfStatus::class, 'id', 'status_id');
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function cartItem()
    {
        return $this->hasMany(CartItem::class, 'cart_id');
    }

}
