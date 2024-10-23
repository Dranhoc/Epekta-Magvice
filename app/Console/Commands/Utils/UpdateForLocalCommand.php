<?php

declare(strict_types=1);

namespace App\Console\Commands\Utils;

use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UpdateForLocalCommand extends Command
{
    protected $signature = 'app:utils:local';

    protected $description = 'Update for local';

    public function handle(): void
    {
        throw_if(app()->environment('local') === false, new Exception('Only for local env !'));

        // Update password by azerty
        $this->updateUserPassword('azerty');
    }

    protected function updateUserPassword(string $password): void
    {
        DB::table('users')->update([
            'password' => Hash::make($password),
        ]);

        $this->info('Passwords updated');
    }
}
