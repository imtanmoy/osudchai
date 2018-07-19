<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('order_no')->unique();

            $table->timestampTz('ordered_on')->useCurrent();
            $table->timestampTz('shipped_on')->nullable();

            $table->decimal('total_amount', 15, 2)->default(0.0);
            $table->decimal('sub_total', 15, 2)->default(0.0);
            $table->decimal('discount_amount', 15, 2)->default(0.0);
            $table->decimal('shipping_cost', 15, 2)->default(0.0);
            $table->decimal('tax', 9, 2)->default(0.0);

            $table->tinyInteger('shipping_status')->default(0);
            $table->text('customer_comment')->nullable();
            $table->timestamps();


            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');

            $table->unsignedInteger('address_id');
            $table->foreign('address_id')->references('id')->on('addresses');

            $table->unsignedInteger('payment_method_id');
            $table->foreign('payment_method_id')->references('id')->on('payment_methods');

            $table->index(['order_no']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
    }
}
