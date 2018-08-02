<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAccountKitsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('account_kits', function (Blueprint $table) {
            $table->increments('id');
            $table->string('account_kit_user_id')->nullable();
            $table->longText('access_token')->nullable();
            $table->integer('token_refresh_interval_sec')->nullable();
            $table->string('number')->unique()->index();
            $table->string('country_prefix')->nullable();
            $table->string('national_number')->nullable();
            $table->timestamps();

            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('account_kits');
    }
}
