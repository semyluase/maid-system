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
        Schema::create('skills', function (Blueprint $table) {
            $table->id();
            $table->foreignId('maid_id');
            $table->foreignId('question_id');
            $table->text('note')->nullable();
            $table->boolean('is_willingness')->default(false);
            $table->boolean('is_experience')->default(false);
            $table->text('note_experience')->nullable();
            $table->integer('rate')->default(0);
            $table->text('note_observation')->nullable();
            $table->boolean('is_hongkong')->default(false);
            $table->boolean('is_singapore')->default(false);
            $table->boolean('is_taiwan')->default(false);
            $table->boolean('is_malaysia')->default(false);
            $table->boolean('is_brunei')->default(false);
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
        Schema::dropIfExists('skills');
    }
};
