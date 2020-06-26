<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Entities\Config\ConfStatus;
use App\Entities\Config\ConfSupplierCat;
use Faker\Generator as Faker;

$factory->define(ConfSupplierCat::class, function (Faker $faker) {
    return [
        'supplier_cat_desc'=>$faker->lexify('Supplier ???'),
        'status_id'=>$faker->boolean(),
        'created_by'=>1,
        'updated_by'=>1

        //
    ];
});
