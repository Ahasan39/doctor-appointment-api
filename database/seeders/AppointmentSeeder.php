<?php

namespace Database\Seeders;

use App\Models\Appointment;
use Illuminate\Database\Seeder;

class AppointmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $appointments = [
            [
                'name' => 'John Doe',
                'phone' => '+1234567890',
                'message' => 'Need consultation for chest pain',
                'preferred_date' => now()->addDays(2)->format('Y-m-d'),
                'preferred_time' => '10:00:00',
                'status' => 'pending',
            ],
            [
                'name' => 'Jane Smith',
                'phone' => '+1234567891',
                'message' => 'Regular checkup',
                'preferred_date' => now()->addDays(3)->format('Y-m-d'),
                'preferred_time' => '14:00:00',
                'status' => 'confirmed',
                'confirmed_at' => now(),
            ],
            [
                'name' => 'Bob Johnson',
                'phone' => '+1234567892',
                'message' => 'Follow-up appointment',
                'preferred_date' => now()->addDays(1)->format('Y-m-d'),
                'preferred_time' => '09:00:00',
                'status' => 'pending',
            ],
            [
                'name' => 'Alice Williams',
                'phone' => '+1234567893',
                'message' => 'Dental checkup',
                'preferred_date' => now()->addDays(5)->format('Y-m-d'),
                'preferred_time' => '11:00:00',
                'status' => 'confirmed',
                'confirmed_at' => now(),
            ],
            [
                'name' => 'Charlie Brown',
                'phone' => '+1234567894',
                'message' => 'Eye examination',
                'preferred_date' => now()->subDays(2)->format('Y-m-d'),
                'preferred_time' => '15:00:00',
                'status' => 'completed',
                'confirmed_at' => now()->subDays(3),
            ],
            [
                'name' => 'Diana Prince',
                'phone' => '+1234567895',
                'message' => 'Vaccination',
                'preferred_date' => now()->addDays(4)->format('Y-m-d'),
                'preferred_time' => '13:00:00',
                'status' => 'cancelled',
            ],
            [
                'name' => 'Edward Norton',
                'phone' => '+1234567896',
                'message' => 'Blood test',
                'preferred_date' => now()->addDays(6)->format('Y-m-d'),
                'preferred_time' => '08:00:00',
                'status' => 'rejected',
                'admin_notes' => 'Doctor not available on this date',
            ],
            [
                'name' => 'Fiona Green',
                'phone' => '+1234567897',
                'message' => 'Skin consultation',
                'preferred_date' => now()->addDays(7)->format('Y-m-d'),
                'preferred_time' => '16:00:00',
                'status' => 'pending',
            ],
        ];

        foreach ($appointments as $appointment) {
            Appointment::create($appointment);
        }

        $this->command->info('Sample appointments created successfully!');
        $this->command->info('Total appointments: ' . count($appointments));
    }
}
