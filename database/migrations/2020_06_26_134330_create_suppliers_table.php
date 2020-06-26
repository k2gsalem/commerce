<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSuppliersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('suppliers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('supplier_name',1000);
            $table->string('supplier_logo',1000)->nullable();
            $table->bigInteger('supplier_category_id')->unsigned();
            $table->foreign('supplier_category_id')->references('id')->on('config_supplier_cats');
            $table->mediumText('supplier_desc')->nullable();
            $table->mediumText('supplier_address')->nullable();
            $table->mediumText('supplier_contact')->nullable();
            $table->mediumText('supplier_email')->nullable();
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
        Schema::dropIfExists('suppliers');
    }
}
