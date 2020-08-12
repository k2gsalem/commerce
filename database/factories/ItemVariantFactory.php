<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Entities\Catalogue\Item;
use App\Entities\Catalogue\ItemVariant;
use App\Entities\Config\ConfStatus;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

$factory->define(ItemVariant::class, function (Faker $faker) {
    return [
        'item_id' => Item::all()->unique()->random()->id,
        'variant_code' => Str::upper(Str::random(5)),
        'variant_desc' => $faker->sentence(),
        'variant_group_id'=>1,
        'MRP'=>100.00,
        'selling_price'=>99.99,
       // 'default'=>true,
        // 'variant_image' => $faker->imageUrl(),
        'status_id' =>ConfStatus::all()->random()->id,
        'created_by' => 1,
        'updated_by' => 1,
        //
    ];
});
