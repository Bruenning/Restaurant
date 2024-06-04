<?php

namespace Database\Seeders;


use Illuminate\Database\Seeder;
use App\Models\User;


class UserSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        //usuário admin
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'teste@teste.com',
            'password' => hash('sha256', 'admin', false),
            'is_admin' => true,
        ]);

        //usuário para testar criação de reservas
        User::factory()->create([
            'name' => 'Test 2 User',
            'email' => 'teste2@teste2.com',
            'password' => hash('sha256', 'admin', false),
            'is_admin' => false,
        ]);

        User::factory()->count(10)->create();
    }
}