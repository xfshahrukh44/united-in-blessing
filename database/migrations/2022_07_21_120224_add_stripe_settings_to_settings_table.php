<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddStripeSettingsToSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('settings', function (Blueprint $table) {
            $table->string('stripe_testing_publishable_key')->nullable()->after('stripe_secret_key');
            $table->string('stripe_testing_secret_key')->nullable()->after('stripe_testing_publishable_key');
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
            $table->dropColumn('stripe_testing_publishable_key');
            $table->dropColumn('stripe_testing_secret_key');
        });
    }
}
