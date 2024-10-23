<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('form_fields', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->json('label');
            $table->json('placeholder');
            $table->json('tooltip');
            $table->integer('type')->default(1);
            $table->integer('column')->default(2);

            $table->boolean('is_required')->default(false);
            $table->boolean('has_multiple_choices')->default(false);
            $table->boolean('is_and')->default(false);
            $table->boolean('is_shown')->default(false);
            $table->boolean('with_label')->default(false);
            $table->string('prefix')->nullable();
            $table->string('suffix')->nullable();
            $table->integer('order_column')->default(1);
            $table->string('filetype')->nullable();
            $table->string('model_reference')->nullable();

            $table->unsignedBigInteger('form_section_id')->nullable();
            $table->foreign('form_section_id')->references('id')->on('form_sections');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('form_fields');
    }
};
