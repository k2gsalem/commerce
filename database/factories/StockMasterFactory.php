<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Entities\Catalogue\Item;
use App\Entities\Catalogue\ItemVariant;
use App\Entities\Stock\StockMaster;
use App\Entities\Vendor\Vendor;
use Faker\Generator as Faker;

$factory->define(StockMaster::class, function (Faker $faker) {
    return [
        'item_id' => Item::all()->unique()->random()->id,
        'variant_id' => ItemVariant::all()->unique()->random()->id,
        'vendor_id' => Vendor::all()->unique()->random()->id,
        'stock_quantity' => $faker->numberBetween(1, 1000),
        'stock_threshold' => $faker->numberBetween(1, 100),
        'status_id' => $faker->boolean(),
        'created_by' => 1,
        'updated_by' => 1,
        //
    ];
});
