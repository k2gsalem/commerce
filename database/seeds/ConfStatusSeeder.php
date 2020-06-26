<?php

use Illuminate\Database\Seeder;

class ConfStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(\App\Entities\Config\ConfStatus::class,20)->create();
        //
    }
}
