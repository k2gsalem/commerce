<?php

namespace App\Entities\Vendor;

use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    protected $fillable = [
        'supplier_name',
        'supplier_logo',
        'supplier_category_id',
        'supplier_desc',
        'supplier_address',
        'supplier_contact',
        'supplier_email',
        'status_id',
        'created_by',
        'updated_by',            
    ];
    

    public function confStatus()
    {
        return $this->hasOne('App\Entities\Config\ConfStatus','id','status_id');        
    }
    public function supplierCategory()
    {
        return $this->hasOne('App\Entities\Config\ConfSupplierCat','id','supplier_category_id');
       
    }
    //
}