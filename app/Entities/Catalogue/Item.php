<?php

namespace App\Entities\Catalogue;

use App\Entities\Vendor\Vendor;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Auditable as AuditingAuditable;
use OwenIt\Auditing\Contracts\Auditable;

class Item extends Model implements Auditable
{
    use AuditingAuditable;
    protected $fillable=[
        'sub_category_id',
        'item_code',
        'item_desc',
        'item_image',
        'vendor_store_id',
        'status_id',
        'created_by',
        'updated_by',
    ];
    public function subCategory()
    {
        return $this->hasOne('App\Entities\Config\ProdSubCat','id','sub_category_id');
    }
    public function store()
    {
       return $this->belongsTo(Vendor::class,'vendor_store_id');
    }
    public function confStatus()
    {
       return $this->hasOne('App\Entities\Config\ConfStatus','id','status_id');
    }
    public function itemVariant()
    {
        return $this->hasMany(ItemVariant::class,'item_id');
    }
    public function stock()
    {
        return $this->hasMany('App\Entities\Stock\StockMaster','item_id','id');
    }
}
