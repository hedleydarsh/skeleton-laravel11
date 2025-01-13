<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::updateOrCreate(
            ['email' => 'adm@skeleton.com'],
            [
                'external_id' =>  Str::uuid()->toString(),
                'name' => 'administrador',
                'password' => bcrypt('adm@skeleton'),
                'phone' => '99999999999',
                'cpf' => '99999999999',
                'birth_date' => '1990-01-02',
                'active_role' => 'super_admin',
            ]
        );

        // Atribuindo roles ao usuário
        $user->assignRole(['super_admin']);
    }
}
