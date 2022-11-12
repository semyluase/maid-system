<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('history_taken_maids', function (Blueprint $table) {
            $table->id();
            $table->foreignId('maid_id');
            $table->timestamp('date_action')->useCurrent();
            $table->string('type_action');
            $table->foreignId('user_action');
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
        Schema::dropIfExists('history_taken_maids');
    }
};
