<?php

use Illuminate\Database\Seeder;

class ConfSupplierCatSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(\App\Entities\Config\ConfSupplierCat::class,40)->create();
        //
    }
}
