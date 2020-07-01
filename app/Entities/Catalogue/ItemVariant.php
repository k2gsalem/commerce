<?php

namespace App\Entities\Catalogue;

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

    }
    //
}
