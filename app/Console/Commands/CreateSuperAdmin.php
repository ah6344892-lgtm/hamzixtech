<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;

class CreateSuperAdmin extends Command
{
    protected $signature = 'hamzixtech:super-admin';
    protected $description = 'Create the first Super Admin or safely grant the role to an existing account';

    public function handle(): int
    {
        $name = trim((string) $this->ask('Name'));
        $email = strtolower(trim((string) $this->ask('Email')));

        if ($name === '' || ! filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->error('A name and valid email address are required.');
            return self::FAILURE;
        }

        $user = User::query()->where('email', $email)->first();
        $password = null;
        if (! $user) {
            $password = $this->secret('Password (minimum 12 characters)');
            if (! is_string($password) || strlen($password) < 12) {
                $this->error('Use a password with at least 12 characters.');
                return self::FAILURE;
            }
        }

        $role = Role::findByName('Super Admin', 'web');
        DB::transaction(function () use (&$user, $name, $email, $password, $role): void {
            if (! $user) {
                $user = User::query()->create([
                    'name' => $name,
                    'email' => $email,
                    'password' => Hash::make((string) $password),
                    'is_active' => true,
                    'email_verified_at' => now(),
                ]);
            }

            $user->forceFill(['is_active' => true])->save();
            $user->syncRoles([$role]);
        });

        $this->info("Super Admin access is ready for {$email}. Existing passwords are never reset by this command.");
        return self::SUCCESS;
    }
}
