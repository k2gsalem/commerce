<?php

use Illuminate\Database\Seeder;

class StockTrackerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(\App\Entities\Stock\StockTracker::class,1)->create();
        //
    }
}
