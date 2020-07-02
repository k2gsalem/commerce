<?php

namespace App\Entities\Catalogue;

use App\Entities\Stock\StockMaster;
use Illuminate\Database\Eloquent\Model;

class ItemVariant extends Model
{
    protected $fillable = [
        'item_id',
        'variant_code',
        'variant_desc',
        'variant_image',
        'status_id',
        'created_by',
        'updated_by',
    ];
    public function item()
    {
        return $this->belongsTo(Item::class);
    }
    public function conStatus()
    {
       return $this->hasOne('App\Entities\Config\ConfStatus','id','status_id');
    }
    public function stock()
    {
        return $this->hasMany(StockMaster::class,'variant_id','id');
    }
    //
}
