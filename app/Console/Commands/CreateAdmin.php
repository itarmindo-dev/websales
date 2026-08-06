<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Str;

class CreateAdmin extends Command
{
    protected $signature = 'admin:create {email? : Alamat email admin}';

    protected $description = 'Membuat akun admin atau memberikan akses admin kepada akun yang sudah ada';

    public function handle(): int
    {
        $email = Str::lower(trim((string) ($this->argument('email') ?: $this->ask('Email admin'))));

        if (! filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->error('Alamat email tidak valid.');

            return self::FAILURE;
        }

        $existingUser = User::query()->where('email', $email)->first();

        if ($existingUser) {
            if ($existingUser->is_admin) {
                $this->info('Akun tersebut sudah memiliki akses admin.');

                return self::SUCCESS;
            }

            if (! $this->confirm("Berikan akses admin kepada {$existingUser->name}?")) {
                return self::FAILURE;
            }

            $existingUser->forceFill(['is_admin' => true])->save();
            $this->info('Akses admin berhasil diberikan.');

            return self::SUCCESS;
        }

        $name = trim((string) $this->ask('Nama admin'));
        $password = (string) $this->secret('Password admin (minimal 12 karakter)');
        $passwordConfirmation = (string) $this->secret('Ulangi password admin');

        if ($name === '') {
            $this->error('Nama admin wajib diisi.');

            return self::FAILURE;
        }

        if (mb_strlen($password) < 12) {
            $this->error('Password harus memiliki minimal 12 karakter.');

            return self::FAILURE;
        }

        if ($password !== $passwordConfirmation) {
            $this->error('Konfirmasi password tidak sama.');

            return self::FAILURE;
        }

        $user = new User([
            'name' => $name,
            'email' => $email,
            'password' => $password,
        ]);
        $user->forceFill([
            'is_admin' => true,
            'email_verified_at' => now(),
        ])->save();

        $this->info('Akun admin berhasil dibuat. Login melalui /login.');

        return self::SUCCESS;
    }
}
