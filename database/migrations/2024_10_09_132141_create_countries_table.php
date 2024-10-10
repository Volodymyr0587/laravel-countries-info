<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('countries', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('alpha2');
            $table->string('alpha3');
            $table->string('country_code');
            $table->string('iso2_code');
            $table->string('is_ilo_member')->nullable();
            $table->string('official_lang_code')->nullable();
            $table->string('is_receiving_quest')->nullable();
            $table->json('geo_point_2d')->nullable();
            $table->string('phone_code')->nullable();
            $table->json('languages')->nullable();
            $table->json('currencies')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('countries');
    }
};
