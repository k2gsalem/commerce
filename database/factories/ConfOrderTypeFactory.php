<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Entities\Config\ConfOrderType;
use Faker\Generator as Faker;

$factory->define(ConfOrderType::class, function (Faker $faker) {
    return [
        // 'order_type_desc'=>$faker->numerify('order_type ##'),
        // 'created_by'=>1,
        // 'updated_by'=>1      

    ];
});
