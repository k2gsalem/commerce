<?php

use App\Entities\Config\ConfStatus;
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
        // factory(\App\Entities\Config\ConfStatus::class,20)->create();
        ConfStatus::create(['status_desc'=>'Active','title'=>'Active','created_by'=>1,'updated_by'=>1]);
        ConfStatus::create(['status_desc'=>'InActive','title'=>'Active','created_by'=>1,'updated_by'=>1]);
        // ConfStatus::create(['status_desc'=>'Processing','created_by'=>1,'updated_by'=>1]);
        // ConfStatus::create(['status_desc'=>'Hold','created_by'=>1,'updated_by'=>1]);
        //
    }
}
