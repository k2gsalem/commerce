<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStockTrackersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stock_trackers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('item_id');
            $table->foreign('item_id')->references('id')->on('items')->onDelete('cascade');
            $table->unsignedBigInteger('variant_id');
            $table->foreign('variant_id')->references('id')->on('item_variants')->onDelete('cascade');
            $table->unsignedBigInteger('supplier_id');
            $table->foreign('supplier_id')->references('id')->on('suppliers')->onDelete('cascade');
            $table->unsignedBigInteger('vendor_id');
            $table->foreign('vendor_id')->references('id')->on('vendors')->onDelete('cascade');
            $table->unsignedBigInteger('vendor_store_id');
            $table->foreign('vendor_store_id')->references('id')->on('vendor_stores')->onDelete('cascade');
            $table->string('order_ref')->nullable();
            $table->date('order_date')->nullable();
            $table->unsignedBigInteger('order_type_id');
            $table->foreign('order_type_id')->references('id')->on('order_types')->onDelete('cascade');
            $table->decimal('MRP',10,2)->nullable();
            $table->decimal('purchase_price',10,2)->nullable();
            $table->decimal('selling_price',10,2)->nullable();
            $table->integer('stock_quantity');
            $table->decimal('total_amount',10,2);
            $table->unsignedBigInteger('payment_status_id');
            $table->foreign('payment_status_id')->references('id')->on('conf_statuses')->onDelete('cascade');
            $table->date('payment_date')->nullable();
            $table->longText('comments')->nullable();
            $table->unsignedBigInteger('status_id');
            $table->foreign('status_id')->references('id')->on('conf_statuses')->onDelete('cascade');
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
        Schema::dropIfExists('stock_trackers');
    }
}
