<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('settings', function (Blueprint $table) {
            $table->string('paypal_testing_client_id')->nullable()->after('paypal_secret_key');
            $table->string('paypal_testing_secret_key')->nullable()->after('paypal_testing_client_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('settings', function (Blueprint $table) {
            $table->dropColumn('paypal_testing_client_id');
            $table->dropColumn('paypal_testing_secret_key');
        });
    }
}
