<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Entities\Config\ConfStatus;
use App\Entities\Config\ProdCat;
use App\Entities\Config\ProdSubCat;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

$factory->define(ProdSubCat::class, function (Faker $faker) {
    return [
        //
        'category_id' => ProdCat::all()->random()->id,
        'sub_category_short_code' =>Str::upper(Str::random(3)),
        'sub_category_desc' => $faker->word(),
        'sub_category_image' => $faker->imageUrl($width = 640, $height = 480),
        'status_id' => $faker->boolean(),
        'created_by' => 1,
        'updated_by' => 1,
    ];
});
