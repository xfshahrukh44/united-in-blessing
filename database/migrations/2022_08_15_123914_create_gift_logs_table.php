<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGiftLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gift_logs', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('sent_by');
            $table->uuid('sent_to');
            $table->uuid('board_id');
            $table->decimal('amount');
            $table->enum('status', ['not_sent', 'pending', 'accepted', 'rejected'])->default('not_sent');
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
        Schema::dropIfExists('gift_logs');
    }
}
