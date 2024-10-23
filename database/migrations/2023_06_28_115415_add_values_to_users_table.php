<?php

use App\Enums\UserRoleEnum;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    public function up()
    {
        User::insert([
            [
                'name' => 'Admin Epekta',
                'email' => 'admin@epekta.com',
                'password' => bcrypt('azerty'),
                'role' => UserRoleEnum::ROOT,
            ],
        ]);
    }

    public function down() {}
};
