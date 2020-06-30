<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Entities\Config\ConfStatus;
use App\Entities\Config\ConfVendorCat;
use App\Entities\Vendor\Vendor;
use Faker\Generator as Faker;

$factory->define(Vendor::class, function (Faker $faker) {
    return [
        'vendor_name' => $faker->name(),
        'vendor_logo' => $faker->imageUrl($width = 640, $height = 480),
        'vendor_category_id' => ConfVendorCat::all()->random()->id,
        'vendor_desc' => $faker->paragraph(),
        'vendor_address' => $faker->address,
        'vendor_contact' => $faker->e164PhoneNumber,
        'vendor_email' => $faker->companyEmail,
        'status_id' => ConfStatus::all()->random()->id,
        'created_by' => 1,
        'updated_by' => 1,
        //
    ];
});
