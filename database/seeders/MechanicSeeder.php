<?php

namespace Database\Seeders;

use App\Models\Mechanic;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MechanicSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $mechanics = [
            [
                'name' => 'Shafin',
                'specialty' => 'Engine Repair',
                'bio' => 'Shafin specializes in diagnosing and repairing complex engine issues. With 8 years of experience, he has worked on various car makes and models.',
                'phone' => '555-123-4567',
                'email' => 'shafin@carservice.com',
                'max_appointments_per_day' => 5,
                'is_available' => true
            ],
            [
                'name' => 'Arif',
                'specialty' => 'Brake Systems',
                'bio' => 'Arif is our brake system expert with over a decade of experience. He ensures your vehicle\'s braking system is in perfect condition for maximum safety.',
                'phone' => '555-234-5678',
                'email' => 'arif@carservice.com',
                'max_appointments_per_day' => 5,
                'is_available' => true
            ],
            [
                'name' => 'Nilima',
                'specialty' => 'Electrical Systems',
                'bio' => 'Nilima excels in diagnosing and fixing electrical issues in modern vehicles. She stays up-to-date with the latest automotive electronics technology.',
                'phone' => '555-345-6789',
                'email' => 'nilima@carservice.com',
                'max_appointments_per_day' => 5,
                'is_available' => true
            ],
            [
                'name' => 'Fatema',
                'specialty' => 'General Maintenance',
                'bio' => 'Fatema handles all aspects of routine maintenance and ensures your vehicle runs smoothly. She has comprehensive knowledge of preventative care.',
                'phone' => '555-456-7890',
                'email' => 'fatema@carservice.com',
                'max_appointments_per_day' => 5,
                'is_available' => true
            ]
        ];

        foreach ($mechanics as $mechanicData) {
            Mechanic::create($mechanicData);
        }
    }
}
