<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductOptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_options', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('quantity')->default(0);
            $table->decimal('price', 15, 2)->nullable();
            $table->enum('stock_status', ['outOfStock', 'inStock', 'pre-order'])->default('inStock');
            $table->unsignedBigInteger('product_id');
            $table->foreign('product_id')->references('id')->on('products');
            $table->timestamps();


            $table->unsignedInteger('option_id');
            $table->foreign('option_id')->references('id')->on('options')->onDelete('cascade');

            $table->unsignedInteger('option_value_id');
            $table->foreign('option_value_id')->references('id')->on('option_values');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product_options');
    }
}
