<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use RuntimeException;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        $email = config('plogee.admin_email');
        $password = config('plogee.admin_password');
        if (!$email && !$password) {
            return;
        }
        if (!filter_var($email, FILTER_VALIDATE_EMAIL) || strlen((string) $password) < 12) {
            throw new RuntimeException('Isi email admin dan kata sandi minimal 12 karakter di .env.');
        }

        $admin = User::firstOrNew(['email' => $email]);
        if ($admin->exists) {
            if ($admin->role !== 'admin') {
                throw new RuntimeException('Email admin telah digunakan peserta. Gunakan email lain.');
            }
            return;
        }
        $admin->name = 'Admin Plogee';
        $admin->role = 'admin';
        $admin->password = $password;
        $admin->save();
    }
}
