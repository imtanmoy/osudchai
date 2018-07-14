<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePacksizeValueProductPacksizeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('packsize_value_product_packsize', function (Blueprint $table) {
            $table->unsignedInteger('pack_size_value_id');
            $table->foreign('pack_size_value_id')->references('id')->on('pack_size_values');
            $table->unsignedInteger('product_pack_size_id');
            $table->foreign('product_pack_size_id')->references('id')->on('product_pack_sizes');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('packsize_value_product_packsize');
    }
}
