<?php

use App\Entities\Config\ConfSupplierCat;
use App\Entities\Config\ConfVendorCat;
use App\Entities\Config\ProdCat;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(RoleTableSeeder::class);
        $this->call(UsersTableSeeder::class);
        $this->call(ConfStatusSeeder::class);
        $this->call(ConfSupplierCatSeeder::class);
        $this->call(ConfVendorCatSeeder::class);
        $this->call(ProdCatSeeder::class);
        $this->call(ProdSubCatSeeder::class);

        $this->call(VendorSeeder::class);
        $this->call(SupplierSeeder::class);

        $this->call(ItemSeeder::class);
        $this->call(ItemVariantSeeder::class);

        $this->call(StockMasterSeeder::class);
    }
}
