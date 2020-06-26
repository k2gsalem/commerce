<?php

use Illuminate\Database\Seeder;

class StockMasterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(\App\Entities\Stock\StockMaster::class,300)->create();
        //
    }
}
