<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $users = [
            ['name' => 'Lid Test',       'email' => 'lid@delinde.test',       'role' => 'lid'],
            ['name' => 'Trainer Test',   'email' => 'trainer@delinde.test',   'role' => 'trainer'],
            ['name' => 'Beheerder Test', 'email' => 'beheerder@delinde.test', 'role' => 'beheerder'],
        ];
 
        foreach ($users as $user) {
            User::updateOrCreate(
                ['email' => $user['email']],
                [
                    'name'     => $user['name'],
                    'password' => Hash::make('wachtwoord'),
                    'role'     => $user['role'],
                ]
            );
        }
    }
}
