<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProdCatsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('prod_cats', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('category_short_code',200)->unique();
            $table->mediumText('category_desc');
            $table->string('title',1000);
            // $table->string('category_image',1000)->nullable();
            // $table->unsignedBigInteger('asset_id')->nullable();
            // $table->foreign('asset_id')->references('id')->on('assets')->onDelete('cascade');
            // $table->uuid('asset_uuid')->index()->unique()->nullable();
            // $table->foreign('asset_uuid')->references('uuid')->on('assets');
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
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('prod_cats');
    }
}
