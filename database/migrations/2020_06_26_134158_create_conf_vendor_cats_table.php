<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateConfVendorCatsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('conf_vendor_cats', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->mediumText('vendor_cat_desc');
            $table->bigInteger('status_id')->unsigned();
            $table->foreign('status_id')->references('id')->on('config_statuses');
            $table->integer('created_by')->unsigned();
            $table->integer('updated_by')->unsigned();
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
        Schema::dropIfExists('conf_vendor_cats');
    }
}
