<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        User::truncate();
        Schema::enableForeignKeyConstraints();
        User::upsert(
            [
                [
                    'name' => 'admin', 'email' => 'admin@email.com',
                    'password' => Hash::make('12345678'), 'role_id' => 1, 'language_id' => null,
                    'first_name' => 'Administrator', 'last_name' => 'Strony'
                ],
                [
                    'name' => 'bob', 'email' => 'bob@email.com', 'password' => Hash::make('1234'),
                    'role_id' => 3, 'language_id' => 1, 'first_name' => 'Robert', 'last_name' => 'Smith'
                ],
                [
                    'name' => 'ewa', 'email' => 'ewa@email.com', 'password' => Hash::make('1234'),
                    'role_id' => 3, 'language_id' => 2, 'first_name' => 'Ewa', 'last_name' => 'Kowalska'
                ],
                [
                    'name' => 'hans', 'email' => 'hans@email.com', 'password' => Hash::make('1234'),
                    'role_id' => 3, 'language_id' => 3, 'first_name' => 'Hans', 'last_name' => 'Gruber'
                ],
                [
                    'name' => 'roberto', 'email' => 'roberto@email.com', 'password' => Hash::make('1234'),
                    'role_id' => 3, 'language_id' => 4, 'first_name' => 'Roberto', 'last_name' => 'Garcia'
                ],
                [
                    'name' => 'jean', 'email' => 'jean@email.com', 'password' => Hash::make('1234'),
                    'role_id' => 3, 'language_id' => 5, 'first_name' => 'Jean', 'last_name' => 'Martin'
                ],
                [
                    'name' => 'jan', 'email' => 'jan@email.com', 'password' => Hash::make('1234'),
                    'role_id' => 2, 'language_id' => null, 'first_name' => 'Jan', 'last_name' => 'Kowalski'
                ]
            ],
            'name'
        );
    }
}
