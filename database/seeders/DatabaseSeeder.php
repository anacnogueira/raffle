<?php

namespace Database\Seeders;


use App\Models\Raffle;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
       Raffle::factory(30)->create();

       User::factory()->create([
            'name' => 'Joe Doe',
            'email' => 'joe@doe.com',
            'admin' => true
       ]);

        User::factory()->create([
            'name' => 'Wandinha',
            'email' => 'wandinha@email.com',
            'admin' => false
       ]);
    }
}
