<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        \App\Models\category::factory()->create([
            'name' => 'clothing'
        ]);

        \App\Models\category::factory()->create([
            'name' => 'footwear'
        ]);

        \App\Models\category::factory()->create([
            'name' => 'electronics'
        ]);
        
        \App\Models\category::factory()->create([
            'name' => 'watches'
        ]);
        
        \App\Models\category::factory()->create([
            'name' => 'smartphone'
        ]);
        
        \App\Models\category::factory()->create([
            'name' => 'earphones'
        ]);

        \App\Models\User::factory()->create([
            'username' => 'rishal',
            'name' => 'rishal',
            'email' => 'ris@m.m',
            'password' => 'rishal12',
            'roles' => 'admin'
        ]);
    }
}
