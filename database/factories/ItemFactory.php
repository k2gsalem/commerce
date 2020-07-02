<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Entities\Catalogue\Item;
use App\Entities\Config\ConfStatus;
use App\Entities\Config\ProdSubCat;
use App\Entities\Vendor\Vendor;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

$factory->define(Item::class, function (Faker $faker) {
    return [
        'sub_category_id' => ProdSubCat::all()->random()->id,
        'item_code' => Str::upper(Str::random(5)),
        'item_desc' => $faker->sentence(),
        'item_image' => $faker->imageUrl(),
        'vendor_store_id' => Vendor::all()->random()->id,
        'status_id' => ConfStatus::all()->random()->id,
        'created_by' => 1,
        'updated_by' => 1,
        //
    ];
});
