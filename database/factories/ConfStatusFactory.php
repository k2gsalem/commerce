<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Entities\Config\ConfStatus;
use Faker\Generator as Faker;

$factory->define(ConfStatus::class, function (Faker $faker) {
    return [             
            'status_desc'=>$faker->numerify('status ##'),
            'created_by'=>1,
            'updated_by'=>1                     //     
    ];
});
