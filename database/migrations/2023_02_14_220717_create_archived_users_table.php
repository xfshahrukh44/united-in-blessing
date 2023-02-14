<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateArchivedUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('archived_users', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('invited_by');
            $table->string('username')->unique();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('email');
            $table->string('phone');
            $table->enum('role', ['admin', 'user'])->default('user');
            $table->enum('timezone', ['EST', 'CST', 'MST', 'PST'])->nullable();
            $table->enum('is_blocked', ['yes', 'no'])->default('yes');
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('user_image')->nullable();
            $table->uuid('replaced_by');
            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('archived_users');
    }
}
