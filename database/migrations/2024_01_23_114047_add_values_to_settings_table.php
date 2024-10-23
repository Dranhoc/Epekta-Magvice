<?php

use App\Models\Setting;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Setting::insert([
            ['key' => 'facebook_url'],
            ['key' => 'pinterest_url'],
            ['key' => 'instagram_url'],
            ['key' => 'linkedin_url'],
            ['key' => 'email'],
            ['key' => 'phone'],
            ['key' => 'address'],
        ]);
    }

    public function down(): void
    {
        Schema::table('settings', function (Blueprint $table) {
            //
        });
    }
};
