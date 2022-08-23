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
        Schema::create('maid_answers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('maid_id');
            $table->foreignId('question_id');
            $table->boolean('answer')->default(false);
            $table->text('note')->default(false);
            $table->foreignId('user_created');
            $table->foreignId('user_updated')->nullable();
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
        Schema::dropIfExists('maid_answers');
    }
};
