<?php

namespace App\Entities\Config;

use Illuminate\Database\Eloquent\Model;

class ConfStatus extends Model
{
    protected $fillable = [
        'status_desc', 'created_at', 'updated_by',
    ];
       

    protected $hidden = [
        'updated_at','created_by'
        ];

    //
}
