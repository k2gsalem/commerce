<?php

use App\Entities\Config\ConfOrderType;
use Illuminate\Database\Seeder;

class ConfOrderTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ConfOrderType::create(['order_type_desc'=>'Inward','title'=>'Inward','created_by'=>1,'updated_by'=>1]);
        ConfOrderType::create(['order_type_desc'=>'Outward','title'=>'Outward','created_by'=>1,'updated_by'=>1]);
    }
}
