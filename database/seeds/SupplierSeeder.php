<?php

use App\Entities\Vendor\Supplier;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class SupplierSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(\App\Entities\Vendor\Supplier::class,1)->create()->each(function ($proCat) {
            $files = Storage::files('');
            $randomFile = $files[rand(0, count($files) - 1)];  
            $faker = Faker\Factory::create();

            \App\Entities\Assets\Asset::insert([
                'user_id' => 1,
                'uuid' => $faker->uuid(),
                'type' => 'image',               
                'path' => $randomFile,                
                'mime' => 'jpg',
                'imageable_type' => Supplier::class,
                'imageable_id' => $proCat->id,
                'created_at'=>\Illuminate\Support\Carbon::now(),
                'updated_at'=>\Illuminate\Support\Carbon::now(),
            ]);
        });
    }
}
