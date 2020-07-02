<?php

namespace App\Entities\Stock;

use Illuminate\Database\Eloquent\Model;

class StockMaster extends Model
{
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
        return $this->hasOne('App\Entities\Config\ConfStatus','id','status_id');
    }
    public function item()
    {
        return $this->belongsTo('App\Entities\Catalogue\Item','id','item_id');
    }
    public function variant()
    {
        return $this->belongsTo('App\Entities\Catalogue\ItemVariant');
    }
    public function vendor()
    {
        return $this->belongsTo('App\Entities\Vendor\Vendor');
    }
}
