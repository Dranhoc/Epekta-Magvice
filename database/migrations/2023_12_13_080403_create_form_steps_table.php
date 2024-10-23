<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('form_steps', function (Blueprint $table) {
            $table->id();
            $table->json('name');

            $table->unsignedBigInteger('form_id')->nullable();
            $table->foreign('form_id')->references('id')->on('forms');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('form_steps');
    }
};
