<?php

namespace App\Entities\Vendor;

use App\Entities\Assets\Asset;
use App\Entities\Stock\StockTracker;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Auditable as AuditingAuditable;
use OwenIt\Auditing\Contracts\Auditable;

class Supplier extends Model implements Auditable
{
    use SoftDeletes,AuditingAuditable;
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
    public function assets()
    {
        return $this->morphMany(Asset::class,'imageable');
    }
    public function stockTrackers(){
        return $this->hasMany(StockTracker::class,'supplier_id');
    }
    //
}