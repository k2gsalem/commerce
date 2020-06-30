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
            $table->foreign('supplier_category_id')->references('id')->on('conf_supplier_cats');
            $table->mediumText('supplier_desc')->nullable();
            $table->mediumText('supplier_address')->nullable();
            $table->mediumText('supplier_contact')->nullable();
            $table->mediumText('supplier_email')->nullable();
            $table->unsignedBigInteger('status_id');
            $table->foreign('status_id')->references('id')->on('conf_statuses');
            $table->unsignedBigInteger('created_by');
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
        Schema::dropIfExists('suppliers');
    }
}
