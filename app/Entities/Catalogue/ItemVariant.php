<?php

namespace App\Entities\Catalogue;

use App\Entities\Assets\Asset;
use App\Entities\Config\ConfStatus;
use App\Entities\Stock\StockMaster;
use App\Entities\Stock\StockTracker;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Auditable as AuditingAuditable;
use OwenIt\Auditing\Contracts\Auditable;

class ItemVariant extends Model implements Auditable
{
    use SoftDeletes, AuditingAuditable;
    protected $fillable = [
        'item_id',
        'variant_code',
        'variant_group_id',
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
        return $this->hasOne(ConfStatus::class, 'id', 'status_id');
    }
    public function stock()
    {
        return $this->hasMany(StockMaster::class, 'variant_id');
    }
    public function assets()
    {
        return $this->morphMany(Asset::class, 'imageable');
    }
    public function variantGroup()
    {
        return $this->belongsTo(ItemVariantGroup::class);
    }
    public function stockTrackers()
    {
        return $this->hasMany(StockTracker::class, 'variant_id');
    }
    //
}
