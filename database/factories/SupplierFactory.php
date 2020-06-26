<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Entities\Config\ConfSupplierCat;
use App\Entities\Vendor\Supplier;
use Faker\Generator as Faker;

$factory->define(Supplier::class, function (Faker $faker) {
    return [
        
        'supplier_name' => $faker->name(),
        'supplier_logo' => $faker->imageUrl($width = 640, $height = 480),
        'supplier_category_id' => ConfSupplierCat::all()->random()->id,
        'supplier_desc' => $faker->paragraph(),
        'supplier_address' => $faker->address,
        'supplier_contact' => $faker->e164PhoneNumber,
        'supplier_email' => $faker->companyEmail,
        'status_id' => $faker->boolean(),
        'created_by' => 1,
        'updated_by' => 1,
        //
    ];
});
