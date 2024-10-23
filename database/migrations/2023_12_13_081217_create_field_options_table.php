<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('field_options', function (Blueprint $table) {
            $table->id();
            $table->json('label');
            $table->integer('price')->nullable();
            $table->integer('order_column')->default(1);
            $table->integer('amount')->default(0);

            $table->unsignedBigInteger('form_field_id')->nullable();
            $table->foreign('form_field_id')->references('id')->on('form_fields');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('field_options');
    }
};
