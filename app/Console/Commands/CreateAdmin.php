<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\Validator;

use function Laravel\Prompts\password as promptPassword;
use function Laravel\Prompts\text;

/**
 * Creates (or promotes) the single admin who can reach /admin.
 *
 * Run by hand on a first deploy. Deliberately not part of the pipeline: the
 * panel has no public registration, so an admin should only ever appear because
 * a human asked for one.
 */
final class CreateAdmin extends Command
{
    protected $signature = 'app:create-admin
                            {--name= : The admin display name}
                            {--email= : The admin email address}
                            {--password= : The admin password (prompted if omitted)}';

    protected $description = 'Create or promote an administrator for the Filament panel';

    public function handle(): int
    {
        $name  = $this->option('name') ?: text('Name', required: true);
        $email = $this->option('email') ?: text('Email address', required: true);

        $password = $this->option('password')
            ?: promptPassword('Password', required: true);

        $validator = Validator::make(
            ['name' => $name, 'email' => $email, 'password' => $password],
            [
                'name'     => ['required', 'string', 'max:120'],
                'email'    => ['required', 'email:rfc', 'max:190'],
                'password' => ['required', Password::min(12)],
            ],
        );

        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                $this->error($error);
            }

            return self::FAILURE;
        }

        $user = User::query()->updateOrCreate(
            ['email' => $email],
            [
                'name'     => $name,
                'password' => Hash::make($password),
                'is_admin' => true,
            ],
        );

        $this->info("{$user->email} can now sign in at /admin.");

        return self::SUCCESS;
    }
}
