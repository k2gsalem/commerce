<?php

namespace App\Entities\Stock;

use App\Entities\Catalogue\Item;
use App\Entities\Catalogue\ItemVariant;
use App\Entities\Config\ConfStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Auditable as AuditingAuditable;
use OwenIt\Auditing\Contracts\Auditable;

class StockMaster extends Model implements Auditable
{
    use SoftDeletes,AuditingAuditable;
    protected $fillable=[
        'item_id',
        'variant_id',
        'vendor_id',
        'stock_quantity',
        'stock_threshold',
        'status_id',
        'created_by',
        'updated_by',
        'created_at',
    ];
    public function confStatus()
    {
        return $this->hasOne(ConfStatus::class,'id','status_id');
    }
    public function item()
    {
        return $this->belongsTo(Item::class,'id','item_id');
    }
    public function variant()
    {
        return $this->belongsTo(ItemVariant::class);
    }
    public function vendor()
    {
        return $this->belongsTo('App\Entities\Vendor\Vendor');
    }
}
