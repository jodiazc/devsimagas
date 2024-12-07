<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // jdiaz@simagas.com.mx

        $adminUsers = [
            [
                'name' => 'Jorge Díaz',
                'email' => 'jodiazc@gmail.com',
                'password' => bcrypt('36168055'),
            ],
            [
                'name' => 'Jesus Díaz',
                'email' => 'jdiaz@simagas.com.mx',
                'password' => bcrypt('jesus1974'),
            ],
        ];

        foreach ($adminUsers as $adminUser) {
            User::firstOrCreate(
                ['email' => $adminUser['email']], // Condición para encontrar el usuario
                [
                    'name' => $adminUser['name'],
                    'password' => $adminUser['password'],
                ]
            )->assignRole('Administrador'); // Asignar el rol
        }


        /*User::create([
            'name' => 'Jorge Díaz',
            'email' => 'jodiazc@gmail.com',
            'password' => bcrypt('36168055'),
        ])->assignRole('Administrador');*/

        //User::factory(50)->create();
    }
}
