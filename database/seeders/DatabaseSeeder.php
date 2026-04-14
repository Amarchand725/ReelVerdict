<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Auth;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Auth::loginUsingId(1);

        $this->call([
            StatusSeeder::class,
            RolesAndPermissionsSeeder::class,
            UserSeeder::class,
        ]);
    }
}
