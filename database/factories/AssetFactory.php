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
//public static function image($dir = null, $width = 640, $height = 480, $category = null, $fullPath = true, $randomize = true, $word = null);
$factory->define(Asset::class, function (Faker $faker) {
    $imageable = [
        ProdCat::class,
        ProdSubCat::class,
        Supplier::class,
        Vendor::class,
        Item::class,
        ItemVariant::class,
       
            
       
        
    ]; // Add new noteables here as we make them
    $imageableType = $faker->randomElement($imageable);
    $imageable = factory($imageableType)->create();

   
    return [
        'user_id'=>1,
        'uuid'=>$faker->uuid,
        'type'=>'image',
        'path'=>$faker->image(storage_path('app/'),200,200, null, false),
        // 'path'=>$faker->image($filepath,400, 300),
        'mime'=>'jpg',
        'imageable_type'=>$imageableType,
        'imageable_id'=>$imageable->id    
     
    ];
});
