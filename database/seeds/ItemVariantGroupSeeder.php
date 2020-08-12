<?php

use Illuminate\Database\Seeder;

class ItemVariantGroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(\App\Entities\Catalogue\ItemVariantGroup::class,2)->create();
        //
    }
}
