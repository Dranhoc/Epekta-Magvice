<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('contents', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->string('name');

            $table->text('title')->nullable();
            $table->text('sur_title')->nullable();
            $table->text('subtitle')->nullable();
            $table->text('picture_alt')->nullable();

            $table->text('content')->nullable();
            $table->unsignedTinyInteger('type')->default(1);

            $table->unsignedInteger('order_column');

            $table->nullableMorphs('contentable');

            $table->bigInteger('page_id')->unsigned()->index()->nullable();
            $table->foreign('page_id')->references('id')->on('pages')->onDelete('cascade');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('contents');
    }
};
