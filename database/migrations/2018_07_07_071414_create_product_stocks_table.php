<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductStocksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_stocks', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('available_qty')->default(0);
            $table->integer('minimum_order_qty')->default(1);
            $table->decimal('price', 15, 2)->default(0.0);
            $table->enum('stock_status', ['outOfStock', 'inStock', 'pre-order'])->default('inStock');
            $table->tinyInteger('subtract_stock')->default(0);
            $table->timestamps();

            $table->unsignedBigInteger('product_id');
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product_stocks');
    }
}
