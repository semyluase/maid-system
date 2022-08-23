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
            $table->string('first_name');
            $table->string('last_name');
            $table->string('place_of_birth');
            $table->date('date_of_birth');
            $table->foreignId('religion_id')->nullable();
            $table->foreignId('country_id')->nullable();
            $table->foreignId('education_id')->nullable();
            $table->foreignId('blood_type_id')->nullable();
            $table->string('province')->nullable();
            $table->string('regency')->nullable();
            $table->string('district')->nullable();
            $table->string('village')->nullable();
            $table->integer('height')->nullable();
            $table->integer('weight')->nullable();
            $table->string('contact')->nullable();
            $table->text('address')->nullable();
            $table->string('port_airport_name')->nullable();
            $table->integer('brother')->nullable();
            $table->integer('sister')->nullable();
            $table->integer('number_in_family')->nullable();
            $table->text('picture_location')->nullable();
            $table->binary('picture_base64')->nullable();
            $table->string('picture_name')->nullable();
            $table->string('youtube_link')->nullable();
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
