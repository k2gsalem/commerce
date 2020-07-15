<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Entities\Assets\Asset;
use App\Entities\Catalogue\Item;
use App\Entities\Catalogue\ItemVariant;
use App\Entities\Config\ProdCat;
use App\Entities\Config\ProdSubCat;
use App\Entities\Vendor\Supplier;
use App\Entities\Vendor\Vendor;
use Faker\Generator as Faker;
use Illuminate\Support\Facades\Storage;

//public static function image($dir = null, $width = 640, $height = 480, $category = null, $fullPath = true, $randomize = true, $word = null);

$factory->define(Asset::class, function (Faker $faker) {
    $imageable = [
        ProdCat::class,
        ProdSubCat::class,
        Supplier::class,
        Vendor::class,
        // Item::class,
        // ItemVariant::class,

    ]; // Add new noteables here as we make them
    $imageableType = $faker->randomElement($imageable);
    $imageable = factory($imageableType)->create();

    // $fp = storage_path('app/');
    $files = Storage::files('');
    $randomFile = $files[rand(0, count($files) - 1)];
    return [
        'user_id' => 1,
        'uuid' => $faker->uuid,
        'type' => 'image',
        // 'path'=>$faker->image($fp,200,200),
        'path' => $randomFile,
        // 'path'=>$faker->image($filepath,400, 300),
        'mime' => 'jpg',
        'imageable_type' => $imageableType,
        'imageable_id' => $imageable->id,

    ];

});
// function random_pic()
// {

//     foreach (\Illuminate\Support\Facades\Storage::files() as $filename) {
//         $files = \Illuminate\Support\Facades\Storage::get($filename);
//         // do whatever with $file;
//     }
//     $file = array_rand($files);
//     return $files[$file];
// }
