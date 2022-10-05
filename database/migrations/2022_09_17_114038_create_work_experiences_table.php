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
        Schema::create('work_experiences', function (Blueprint $table) {
            $table->id();
            $table->foreignId('maid_id');
            $table->string('month_start')->nullable();
            $table->string('year_start')->nullable();
            $table->string('month_end')->nullable();
            $table->string('year_end')->nullable();
            $table->string('country')->nullable();
            $table->string('employeer')->nullable();
            $table->text('description')->nullable();
            $table->string('remarks')->nullable();
            $table->string('employeer_singapore')->nullable();
            $table->string('employeer_singapore_feedback')->nullable();
            $table->boolean('work_singapore')->default(false);
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
        Schema::dropIfExists('work_experiences');
    }
};
