<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('sku')->unique();
            $table->string('slug')->unique();
            $table->string('description', 1000)->nullable();
            $table->decimal('price', 15, 2);
            $table->tinyInteger('is_active')->default(1);
            $table->timestamps();


            $table->index(['sku', 'slug']);

            $table->unsignedBigInteger('manufacturer_id')->nullable();
            $table->foreign('manufacturer_id')
                ->references('id')->on('manufacturers');

            $table->unsignedInteger('category_id')->nullable();
            $table->foreign('category_id')
                ->references('id')->on('categories');

            $table->unsignedInteger('product_type_id')->nullable();
            $table->foreign('product_type_id')
                ->references('id')->on('product_types');

            $table->unsignedBigInteger('strength_id')->nullable();
            $table->foreign('strength_id')
                ->references('id')->on('strengths');

            $table->unsignedBigInteger('generic_name_id')->nullable();
            $table->foreign('generic_name_id')
                ->references('id')->on('generic_names');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
}
