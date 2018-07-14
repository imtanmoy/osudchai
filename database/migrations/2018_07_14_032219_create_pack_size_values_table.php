<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePackSizeValuesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pack_size_values', function (Blueprint $table) {
            $table->increments('id');
            $table->string('value');
            $table->unsignedInteger('pack_size_id');
            $table->foreign('pack_size_id')->references('id')->on('pack_sizes')->onDelete('cascade');
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
        Schema::dropIfExists('pack_size_values');
    }
}
