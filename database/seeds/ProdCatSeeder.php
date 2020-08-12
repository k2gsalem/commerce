<?php

use App\Entities\Config\ProdCat;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;


class ProdCatSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(\App\Entities\Config\ProdCat::class, 2)->create()->each(function ($proCat) {
            $files = Storage::files('');
            $randomFile = $files[rand(0, count($files) - 1)];  
            $faker = Faker\Factory::create();

            \App\Entities\Assets\Asset::insert([
                'user_id' => 1,
                'uuid' => $faker->uuid(),
                'type' => 'image',               
                'path' => $randomFile,                
                'mime' => 'jpg',
                'imageable_type' => ProdCat::class,
                'imageable_id' => $proCat->id,
                'created_at'=>\Illuminate\Support\Carbon::now(),
                'updated_at'=>\Illuminate\Support\Carbon::now(),
            ]);
        });
        //
    }
}
