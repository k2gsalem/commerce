<?php

use Illuminate\Database\Seeder;

class ProdSubCatSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(\App\Entities\Config\ProdSubCat::class,100)->create();
        //
    }
}