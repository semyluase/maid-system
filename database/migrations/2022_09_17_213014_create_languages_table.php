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
        Schema::create('languages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('maid_id');
            $table->foreignId('question_id');
            $table->boolean('answer')->default(false);
            $table->string('note')->nullable();
            $table->integer('rate')->default(0);
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
        Schema::dropIfExists('languages');
    }
};
