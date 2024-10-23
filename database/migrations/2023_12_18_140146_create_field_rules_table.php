<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('field_rules', function (Blueprint $table) {
            $table->id();
            $table->string('operator');

            $table->unsignedBigInteger('form_field_id')->nullable();
            $table->foreign('form_field_id')->references('id')->on('form_fields');

            $table->unsignedBigInteger('field_option_id')->nullable();
            $table->foreign('field_option_id')->references('id')->on('field_options');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('field_rules');
    }
};
