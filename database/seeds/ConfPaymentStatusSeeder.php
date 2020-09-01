<?php

use App\Entities\Config\ConfPaymentStatus;
use Illuminate\Database\Seeder;

class ConfPaymentStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         ConfPaymentStatus::create(['payment_status_desc'=>'Payment Settled','title'=>'Payment Settled','created_by'=>1,'updated_by'=>1]);
         ConfPaymentStatus::create(['payment_status_desc'=>'Partially Settled','title'=>'Partially Settled','created_by'=>1,'updated_by'=>1]);
         ConfPaymentStatus::create(['payment_status_desc'=>'Not Settled','title'=>'Not Settled','created_by'=>1,'updated_by'=>1]);
    }
}
