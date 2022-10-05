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
        Schema::create('maids', function (Blueprint $table) {
            $table->id();
            $table->string('code_maid')->unique('code_maid_index');
            $table->string('full_name');
            $table->integer('sex');
            $table->string('country')->nullable();
            $table->date('start_training')->nullable();
            $table->string('place_of_birth');
            $table->date('date_of_birth');
            $table->bigInteger('religion')->nullable();
            $table->bigInteger('education')->nullable();
            $table->bigInteger('blood')->nullable();
            $table->bigInteger('marital')->nullable();
            $table->integer('height')->nullable();
            $table->integer('weight')->nullable();
            $table->string('contact')->nullable();
            $table->text('address')->nullable();
            $table->string('ethnic')->nullable();
            $table->text('hobby')->nullable();
            $table->string('port_airport_name')->nullable();
            $table->integer('brother')->nullable();
            $table->integer('sister')->nullable();
            $table->integer('number_in_family')->nullable();
            $table->integer('number_of_children')->nullable();
            $table->string('children_ages')->nullable();
            $table->string('spouse_name')->nullable();
            $table->integer('spouse_age')->nullable();
            $table->boolean('spouse_passed_away')->default(false);
            $table->string('father_name')->nullable();
            $table->integer('father_age')->nullable();
            $table->boolean('father_passed_away')->default(false);
            $table->string('mother_name')->nullable();
            $table->integer('mother_age')->nullable();
            $table->boolean('mother_passed_away')->default(false);
            $table->string('family_background')->nullable();
            $table->text('picture_location')->nullable();
            $table->binary('picture_base64')->nullable();
            $table->string('picture_name')->nullable();
            $table->string('youtube_link')->nullable();
            $table->boolean('is_hongkong')->default(false);
            $table->boolean('is_singapore')->default(false);
            $table->boolean('is_taiwan')->default(false);
            $table->boolean('is_malaysia')->default(false);
            $table->boolean('is_brunei')->default(false);
            $table->boolean('is_all')->default(false);
            $table->boolean('is_active')->default(true);
            $table->boolean('is_trash')->default(false);
            $table->boolean('is_blacklist')->default(false);
            $table->boolean('is_delete')->default(false);
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
        Schema::dropIfExists('maids');
    }
};
