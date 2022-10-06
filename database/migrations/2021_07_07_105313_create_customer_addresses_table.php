<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomerAddressesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customer_addresses', function (Blueprint $table) {
            $table->id();
            $table->integer('customer_id');
            $table->string('first_name');
            $table->string('last_name');
            $table->string('phone_no');
            $table->string('phone_no_code');
            $table->string('title');
            $table->mediumText('address');
            $table->string('city');
            $table->mediumText('company_name');
            $table->string('zip_code');
            $table->string('country');
            $table->string('state');
            $table->string('shipping_billing');
            $table->tinyInteger('save_check')->default(0);
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
        Schema::dropIfExists('customer_addresses');
    }
}
