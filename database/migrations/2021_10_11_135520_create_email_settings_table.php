<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmailSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('email_settings', function (Blueprint $table) {
            $table->id();

            $table->string('mail_domain');
            $table->string('mail_host')->nullable();
            $table->string('ssl');
            $table->string('username');
            $table->string('password')->nullable();
            $table->string('mail_port');
            $table->string('from_address')->nullable();
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
        Schema::dropIfExists('email_settings');
    }
}
