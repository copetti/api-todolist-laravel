<?php

namespace Database\Seeders;

use App\Models\Todo;
use App\Models\TodoTask;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TodoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::all()->each(function ($user) {
            $user->todos()->saveMany(Todo::factory(10)->make())->each(function ($todo){
                $todo->tasks()->saveMany(TodoTask::factory(10)->make());
            });
        });
    }
}
