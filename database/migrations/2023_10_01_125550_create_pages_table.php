<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pages', function (Blueprint $table) {
            $table->id();

            $table->json('title');
            $table->json('slug');
            $table->json('content')->nullable();
            $table->string('template')->nullable();
            $table->string('method')->nullable();
            $table->string('model')->nullable();
            $table->string('route_name')->nullable();
            $table->json('seo_title')->nullable();
            $table->json('seo_description')->nullable();
            $table->string('seo_type')->nullable();

            $table->foreignIdFor(\App\Models\Form::class)->nullable()->constrained()->cascadeOnDelete();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pages');
    }
};
