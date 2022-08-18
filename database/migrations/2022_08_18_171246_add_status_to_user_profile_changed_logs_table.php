<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddStatusToUserProfileChangedLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('user_profile_changed_logs', function (Blueprint $table) {
            $table->text('message')->after('old_value')->nullable();
            $table->enum('status', ['pending', 'accepted', 'rejected', 'discarded'])->default('accepted')->after('message');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('user_profile_changed_logs', function (Blueprint $table) {
            $table->dropColumn('status');
        });
    }
}
