<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCartItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cart_items', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('cart_id');
            $table->foreign('cart_id')->references('id')->on('carts')->onDelete('cascade');
            $table->unsignedBigInteger('item_id');
            $table->foreign('item_id')->references('id')->on('items')->onDelete('cascade');
            $table->unsignedBigInteger('variant_group_id')->nullable();
            $table->foreign('variant_group_id')->references('id')->on('item_variant_groups')->onDelete('cascade');
            $table->decimal('item_selling_price',10,2);
            $table->decimal('item_discount_percentage',10,2);
            $table->decimal('item_discount_amount',10,2);
            $table->integer('item_quantity');
            $table->unsignedBigInteger('vendor_store_id');
            $table->foreign('vendor_store_id')->references('id')->on('vendor_stores')->onDelete('cascade');
            // $table->unsignedBigInteger('status_id');
            // $table->foreign('status_id')->references('id')->on('conf_statuses')->onDelete('cascade');
            $table->unsignedBigInteger('created_by');
            $table->foreign('created_by')->references('id')->on('users')->onDelete('cascade');
            $table->unsignedBigInteger('updated_by');
            $table->foreign('updated_by')->references('id')->on('users')->onDelete('cascade');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cart_items');
    }
}
