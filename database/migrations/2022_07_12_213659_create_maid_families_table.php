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
        Schema::create('maid_families', function (Blueprint $table) {
            $table->id();
            $table->foreignId('maid_id');
            $table->foreignId('relation_id');
            $table->string('name');
            $table->date('date_of_birth');
            $table->boolean('is_passed_away')->default(false);
            $table->boolean('is_active')->default(true);
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
        Schema::dropIfExists('maid_families');
    }
};
