<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOptionValueProductOptionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('option_value_product_option', function (Blueprint $table) {
            $table->unsignedInteger('option_value_id');
            $table->foreign('option_value_id')->references('id')->on('option_values');
            $table->unsignedInteger('product_option_id');
            $table->foreign('product_option_id')->references('id')->on('product_options');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('option_value_product_option');
    }
}
