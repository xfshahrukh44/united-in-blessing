<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

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
            $table->id();
            $table->string('order_no');
            $table->integer('customer_id')->nullable();
            $table->string('customer_name');
            $table->string('customer_email');
            $table->string('sub_total');
            $table->string('tax');
            $table->string('total_amount');
            $table->enum('order_status', ['', 'paid', 'pending', 'cancelled', 'unpaid', 'completed', 'shipped']);
            $table->tinyInteger('status')->default('1');
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
        Schema::dropIfExists('orders');
    }
}
