<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\Validator;

class CreateAdminUser extends Command
{
    protected $signature = 'admin:create
        {--name= : Nama lengkap admin}
        {--email= : Email admin}
        {--password= : Password admin}
        {--force : Update user jika email sudah terdaftar}';

    protected $description = 'Create an active administrator account without relying on production seeders.';

    public function handle(): int
    {
        $data = [
            'name' => $this->resolveName(),
            'email' => $this->resolveEmail(),
            'password' => $this->resolvePassword(),
        ];

        $validator = Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255'],
            'password' => ['required', Password::defaults()],
        ]);

        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                $this->error($error);
            }

            return self::FAILURE;
        }

        $email = strtolower($data['email']);
        $existingUser = User::where('email', $email)->first();

        if ($existingUser && ! $this->option('force')) {
            $this->error('Email admin sudah terdaftar. Gunakan --force jika ingin memperbarui akun tersebut.');

            return self::FAILURE;
        }

        $user = User::updateOrCreate(
            ['email' => $email],
            [
                'name' => $data['name'],
                'password' => Hash::make($data['password']),
                'role' => 'admin',
                'is_active' => true,
            ]
        );

        $this->info($existingUser ? 'Admin berhasil diperbarui.' : 'Admin berhasil dibuat.');
        $this->line("Email: {$user->email}");

        return self::SUCCESS;
    }

    protected function resolveName(): string
    {
        return $this->option('name')
            ?: env('ADMIN_ACCOUNT_NAME')
            ?: $this->ask('Nama admin');
    }

    protected function resolveEmail(): string
    {
        return $this->option('email')
            ?: env('ADMIN_ACCOUNT_EMAIL')
            ?: $this->ask('Email admin');
    }

    protected function resolvePassword(): string
    {
        return $this->option('password')
            ?: env('ADMIN_ACCOUNT_PASSWORD')
            ?: $this->secret('Password admin');
    }
}
