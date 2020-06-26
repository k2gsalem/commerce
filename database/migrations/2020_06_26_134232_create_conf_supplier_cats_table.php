<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateConfSupplierCatsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('conf_supplier_cats', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->mediumText('supplier_cat_desc');
            // $table->bigInteger('status_id')->unsigned();
            $table->integer('status_id')->default(1);
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
        Schema::dropIfExists('conf_supplier_cats');
    }
}
