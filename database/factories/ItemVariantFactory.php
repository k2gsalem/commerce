<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Entities\Catalogue\Item;
use App\Entities\Catalogue\ItemVariant;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

$factory->define(ItemVariant::class, function (Faker $faker) {
    return [
        'item_id' => Item::all()->unique()->random()->id,
        'variant_code' => Str::upper(Str::random(5)),
        'variant_desc' => $faker->sentence(),
        'variant_image' => $faker->imageUrl(),
        'status_id' => $faker->boolean(),
        'created_by' => 1,
        'updated_by' => 1,
        //
    ];
});
