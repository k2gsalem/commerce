<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Entities\Catalogue\Item;
use App\Entities\Catalogue\ItemVariantGroup;
use Faker\Generator as Faker;

$factory->define(ItemVariantGroup::class, function (Faker $faker) {
    return [
        'item_id'=>Item::all()->unique()->random()->id,
        'item_group_desc'=>$faker->word(),
        'status_id'=>1,
        'created_by'=>1,
        'updated_by'=>1,

        //
    ];
});
