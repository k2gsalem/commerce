<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Entities\Config\ConfStatus;
use App\Entities\Config\ConfVendorCat;
use Faker\Generator as Faker;

$factory->define(ConfVendorCat::class, function (Faker $faker) {
    return [
        'vendor_cat_desc' => $faker->lexify('Vendor ???'),
        'status_id' =>ConfStatus::all()->random()->id,
        'created_by' => 1,
        'updated_by' => 1,
        //
    ];
});
