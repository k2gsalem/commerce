<?php

use Illuminate\Database\Seeder;

class ConfVendorCatSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(\App\Entities\Config\ConfVendorCat::class,10)->create();
        //
    }
}
