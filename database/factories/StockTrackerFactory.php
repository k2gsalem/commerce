<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Entities\Catalogue\Item;
use App\Entities\Catalogue\ItemVariant;
use App\Entities\Stock\StockTracker;
use App\Entities\Vendor\Supplier;
use Faker\Generator as Faker;

$factory->define(StockTracker::class, function (Faker $faker) {
    return [
        'item_id'=>Item::all()->unique()->random()->id,
        'variant_id'=>ItemVariant::all()->unique()->random()->id,
        'supplier_id'=>Supplier::all()->random()->id,
        'purchase_order_ref'=>$faker->word(),
        'purchase_order_date'=>$faker->date(),
        'purchase_price'=>99.99,
        'stock_quantity'=>1,
        'comments'=>1,
        'status_id'=>1,
        'created_by'=>1,
        'updated_by'=>1,
        //
    ];
});
