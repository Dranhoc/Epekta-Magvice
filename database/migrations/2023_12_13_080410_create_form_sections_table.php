<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('form_sections', function (Blueprint $table) {
            $table->id();
            $table->json('name');

            $table->unsignedBigInteger('form_step_id')->nullable();
            $table->foreign('form_step_id')->references('id')->on('form_steps');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('form_sections');
    }
};
