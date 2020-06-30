<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVendorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vendors', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('vendor_name',1000);
            $table->string('vendor_logo',1000)->nullable();
            $table->bigInteger('vendor_category_id')->unsigned();
            $table->foreign('vendor_category_id')->references('id')->on('conf_vendor_cats');
            $table->mediumText('vendor_desc')->nullable();
            $table->mediumText('vendor_address')->nullable();
            $table->mediumText('vendor_contact')->nullable();
            $table->mediumText('vendor_email')->nullable();
            $table->unsignedBigInteger('status_id');
            $table->foreign('status_id')->references('id')->on('conf_statuses');
            $table->foreign('created_by')->references('id')->on('users');
            $table->unsignedBigInteger('updated_by');
            $table->foreign('updated_by')->references('id')->on('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('vendors');
    }
}
