<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAuthorizeColumnsInPaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('payments', function (Blueprint $table) {
           
            $table->string('name_on_card')->nullable();            
            $table->string('response_code')->nullable();            
            $table->string('transaction_id')->nullable();            
            $table->string('auth_id')->nullable();            
            $table->string('message_code')->nullable();            
            $table->integer('quantity')->nullable();
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('payments', function (Blueprint $table) {
            $table->dropColumn('name_on_card');            
            $table->dropColumn('response_code');            
            $table->dropColumn('transaction_id');            
            $table->dropColumn('auth_id');            
            $table->dropColumn('message_code');            
            $table->dropColumn('quantity');
        });
    }
}
