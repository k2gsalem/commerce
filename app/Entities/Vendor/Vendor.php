<?php

namespace App\Entities\Vendor;

use Illuminate\Database\Eloquent\Model;

class Vendor extends Model
{
    protected $fillable = [
        'vendor_name',
        'vendor_logo',
        'vendor_category_id',
        'vendor_desc',
        'vendor_address',
        'vendor_contact',
        'vendor_email',
        'status_id',
        'created_by',
        'updated_by',
    ];
    public function confStatus()
    {
        return $this->hasOne('App\Entities\Config\ConfStatus','id','status_id');        
    }
    public function vendorCategory()
    {
        return $this->hasOne('App\Entities\Config\ConfVendorCat','id','vendor_category_id');
       
    }
    //
}
