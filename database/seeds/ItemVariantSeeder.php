<?php

use Illuminate\Database\Seeder;

class ItemVariantSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(\App\Entities\Catalogue\ItemVariant::class,300)->create();
        //
    }
}
