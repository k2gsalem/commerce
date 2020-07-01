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
    //
}
