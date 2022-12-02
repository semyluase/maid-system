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
        Schema::create('email_sendings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('maid_id');
            $table->string('email');
            $table->string('file_attachment');
            $table->string('mail_fragment');
            $table->boolean('is_send')->default(false);
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
        Schema::dropIfExists('email_sendings');
    }
};
