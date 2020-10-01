<?php

namespace App\Entities\Profile;

use App\Entities\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Auditable as AuditingAuditable;
use OwenIt\Auditing\Contracts\Auditable;

class UserAddress extends Model implements Auditable
{
    use AuditingAuditable, SoftDeletes;
    //
    protected $fillable = [
        'user_id',
        'user_name',
        'user_contact',
        'address_st1',
        'address_st2',
        'landmark',
        'area',
        'city_town',
        'state',
        'pincode',
        'created_at',
        'updated_at', 'created_by',
        'updated_by',

    ];
    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }
    public function userOrders(){
        return $this->hasMany(UserAddress::class,'user_address_id');
    }
}
