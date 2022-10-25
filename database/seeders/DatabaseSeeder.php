<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        if (User::all()->count() === 0) {
            User::factory()->create([
                'name' => 'creasi',
                'email' => 'admin@creasi.dev',
            ]);
        }
    }
}
