<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('response_answers', function (Blueprint $table) {
            $table->id();

            $table->string('value')->nullable();
            $table->string('locale');
            $table->integer('price')->nullable();

            $table->foreignIdFor(App\Models\FormResponse::class)->nullable()->constrained()->cascadeOnDelete();
            $table->foreignIdFor(App\Models\FormField::class)->nullable()->constrained()->cascadeOnDelete();
            $table->foreignIdFor(App\Models\FieldOption::class)->nullable()->constrained()->cascadeOnDelete();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('response_answers');
    }
};
