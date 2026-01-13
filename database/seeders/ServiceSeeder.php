<?php

namespace Database\Seeders;

use App\Models\Service;
use Illuminate\Database\Seeder;

class ServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $services = [
            [
                'name' => 'General Consultation',
                'description' => 'Comprehensive medical consultation for general health concerns, routine check-ups, and preventive care. Our experienced doctors will assess your health status and provide personalized recommendations.',
                'short_description' => 'General health check-up and consultation',
                'price' => 100.00,
                'duration' => 30,
                'icon' => 'fas fa-stethoscope',
                'is_active' => true,
                'order' => 1,
            ],
            [
                'name' => 'Cardiology Consultation',
                'description' => 'Specialized consultation for heart-related conditions including hypertension, arrhythmia, and cardiovascular disease. Includes ECG and blood pressure monitoring.',
                'short_description' => 'Heart and cardiovascular health consultation',
                'price' => 200.00,
                'duration' => 45,
                'icon' => 'fas fa-heartbeat',
                'is_active' => true,
                'order' => 2,
            ],
            [
                'name' => 'Dental Check-up',
                'description' => 'Complete oral health examination including teeth cleaning, cavity detection, and gum health assessment. Preventive care and treatment recommendations provided.',
                'short_description' => 'Comprehensive dental examination and cleaning',
                'price' => 80.00,
                'duration' => 40,
                'icon' => 'fas fa-tooth',
                'is_active' => true,
                'order' => 3,
            ],
            [
                'name' => 'Pediatric Care',
                'description' => 'Specialized medical care for infants, children, and adolescents. Includes growth monitoring, vaccinations, developmental assessments, and treatment of childhood illnesses.',
                'short_description' => 'Medical care for children and adolescents',
                'price' => 120.00,
                'duration' => 35,
                'icon' => 'fas fa-baby',
                'is_active' => true,
                'order' => 4,
            ],
            [
                'name' => 'Dermatology Consultation',
                'description' => 'Expert consultation for skin, hair, and nail conditions. Treatment for acne, eczema, psoriasis, skin infections, and cosmetic dermatology services.',
                'short_description' => 'Skin, hair, and nail health consultation',
                'price' => 150.00,
                'duration' => 30,
                'icon' => 'fas fa-hand-sparkles',
                'is_active' => true,
                'order' => 5,
            ],
            [
                'name' => 'Orthopedic Consultation',
                'description' => 'Specialized care for bone, joint, and muscle conditions. Treatment for fractures, arthritis, sports injuries, and musculoskeletal disorders.',
                'short_description' => 'Bone, joint, and muscle health consultation',
                'price' => 180.00,
                'duration' => 40,
                'icon' => 'fas fa-bone',
                'is_active' => true,
                'order' => 6,
            ],
            [
                'name' => 'Eye Examination',
                'description' => 'Comprehensive eye health check including vision testing, eye pressure measurement, retinal examination, and prescription for glasses or contact lenses.',
                'short_description' => 'Complete eye health and vision examination',
                'price' => 90.00,
                'duration' => 30,
                'icon' => 'fas fa-eye',
                'is_active' => true,
                'order' => 7,
            ],
            [
                'name' => 'Mental Health Counseling',
                'description' => 'Professional psychological counseling for stress, anxiety, depression, and other mental health concerns. Confidential sessions with licensed therapists.',
                'short_description' => 'Psychological counseling and mental health support',
                'price' => 130.00,
                'duration' => 60,
                'icon' => 'fas fa-brain',
                'is_active' => true,
                'order' => 8,
            ],
            [
                'name' => 'Laboratory Tests',
                'description' => 'Comprehensive laboratory testing services including blood tests, urine analysis, cholesterol screening, diabetes testing, and other diagnostic tests.',
                'short_description' => 'Medical laboratory testing and diagnostics',
                'price' => 60.00,
                'duration' => 15,
                'icon' => 'fas fa-vial',
                'is_active' => true,
                'order' => 9,
            ],
            [
                'name' => 'Vaccination Services',
                'description' => 'Complete vaccination services for children and adults including flu shots, COVID-19 vaccines, travel vaccines, and routine immunizations.',
                'short_description' => 'Immunization and vaccination services',
                'price' => 50.00,
                'duration' => 20,
                'icon' => 'fas fa-syringe',
                'is_active' => true,
                'order' => 10,
            ],
            [
                'name' => 'Physical Therapy',
                'description' => 'Rehabilitation and physical therapy services for injury recovery, post-surgery rehabilitation, chronic pain management, and mobility improvement.',
                'short_description' => 'Rehabilitation and physical therapy sessions',
                'price' => 110.00,
                'duration' => 50,
                'icon' => 'fas fa-walking',
                'is_active' => true,
                'order' => 11,
            ],
            [
                'name' => 'Nutrition Counseling',
                'description' => 'Professional dietary consultation and personalized nutrition plans for weight management, diabetes, heart health, and overall wellness.',
                'short_description' => 'Dietary consultation and nutrition planning',
                'price' => 95.00,
                'duration' => 40,
                'icon' => 'fas fa-apple-alt',
                'is_active' => true,
                'order' => 12,
            ],
        ];

        foreach ($services as $service) {
            Service::create($service);
        }

        $this->command->info('✅ 12 services created successfully!');
    }
}
