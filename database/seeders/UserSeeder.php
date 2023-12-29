<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory()->create([
            'first_name' => 'André',
            'last_name' => 'Copetti',
            'email' => 'andrecopetti@gmail.com',
            'password' => bcrypt('123123')
        ]);

        User::factory(5)->create();
    }
}
