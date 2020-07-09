<?php

use Illuminate\Database\Seeder;

class AssetsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(\App\Entities\Assets\Asset::class,1)->create();
    }
}
