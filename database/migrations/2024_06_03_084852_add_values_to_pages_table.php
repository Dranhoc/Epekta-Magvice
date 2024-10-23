<?php

use App\Models\Page;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Page::insert([
            [
                'id' => 1,
                'title' => json_encode([
                    'fr' => 'Accueil',
                    'en' => 'Home',
                ], JSON_THROW_ON_ERROR),
                'slug' => json_encode([
                    'fr' => 'home',
                    'en' => 'home',
                ], JSON_THROW_ON_ERROR),
            ],
            [
                'id' => 2,
                'title' => json_encode([
                    'fr' => 'Merci',
                    'en' => 'Thank you',
                ], JSON_THROW_ON_ERROR),
                'slug' => json_encode([
                    'fr' => 'merci',
                    'en' => 'thank-you',
                ], JSON_THROW_ON_ERROR),
            ],
        ]);
    }

    public function down(): void
    {
        Schema::table('pages', function (Blueprint $table) {
            //
        });
    }
};
