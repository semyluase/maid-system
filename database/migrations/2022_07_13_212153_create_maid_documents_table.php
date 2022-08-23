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
        Schema::create('maid_documents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('maid_id');
            $table->string('document_number')->nullable();
            $table->date('expired_date')->nullable();
            $table->boolean('is_identity')->default(false);
            $table->boolean('is_passport')->default(false);
            $table->boolean('is_mcu')->default(false);
            $table->boolean('is_npwp')->default(false);
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
        Schema::dropIfExists('maid_documents');
    }
};
