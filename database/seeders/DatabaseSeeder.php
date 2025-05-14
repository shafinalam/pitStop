<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
// use App\Models\Mechanic;
// use App\Models\User;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Add mechanics directly
        DB::table('mechanics')->insert([
            'name' => 'Alex Johnson',
            'specialty' => 'Engine Repair',
            'bio' => 'Alex specializes in diagnosing and repairing complex engine issues. With 8 years of experience, he has worked on various car makes and models.',
            'phone' => '555-123-4567',
            'email' => 'alex@carservice.com',
            'max_appointments_per_day' => 5,
            'is_available' => 1,
            'created_at' => now(),
            'updated_at' => now()
        ]);
        
        DB::table('mechanics')->insert([
            'name' => 'Sarah Chen',
            'specialty' => 'Brake Systems',
            'bio' => 'Sarah is our brake system expert with over a decade of experience. She ensures your vehicle\'s braking system is in perfect condition for maximum safety.',
            'phone' => '555-234-5678',
            'email' => 'sarah@carservice.com',
            'max_appointments_per_day' => 5,
            'is_available' => 1,
            'created_at' => now(),
            'updated_at' => now()
        ]);
        
        DB::table('mechanics')->insert([
            'name' => 'Miguel Rodriguez',
            'specialty' => 'Electrical Systems',
            'bio' => 'Miguel excels in diagnosing and fixing electrical issues in modern vehicles. He stays up-to-date with the latest automotive electronics technology.',
            'phone' => '555-345-6789',
            'email' => 'miguel@carservice.com',
            'max_appointments_per_day' => 5,
            'is_available' => 1,
            'created_at' => now(),
            'updated_at' => now()
        ]);
        
        DB::table('mechanics')->insert([
            'name' => 'Priya Patel',
            'specialty' => 'General Maintenance',
            'bio' => 'Priya handles all aspects of routine maintenance and ensures your vehicle runs smoothly. She has comprehensive knowledge of preventative care.',
            'phone' => '555-456-7890',
            'email' => 'priya@carservice.com',
            'max_appointments_per_day' => 5,
            'is_available' => 1,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        // Create admin user
        DB::table('users')->insert([
            'first_name' => 'Admin',
            'last_name' => 'User',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
            'remember_token' => Str::random(10),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        
        // Create regular test user
        DB::table('users')->insert([
            'first_name' => 'Test',
            'last_name' => 'User',
            'email' => 'test@example.com',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
            'remember_token' => Str::random(10),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
