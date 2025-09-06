<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\Company;
use App\Models\CompanyVerification;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // Company::factory()->has(CompanyVerification::factory(), "verification")->count(5)->create();

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        
        
        Admin::create([
            'email' => 'admin@recreeti.com',
            'password' => Hash::make('admin12345')
        ]);
    }
}
