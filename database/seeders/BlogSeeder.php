<?php

namespace Database\Seeders;

use App\Models\Blog;
use App\Models\User;
use Illuminate\Database\Seeder;

class BlogSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get admin user as author
        $admin = User::where('email', 'admin@doctorappoint.com')->first();

        if (!$admin) {
            $this->command->error('Admin user not found. Please run AdminUserSeeder first.');
            return;
        }

        $blogs = [
            [
                'title' => '10 Essential Tips for Maintaining Heart Health',
                'excerpt' => 'Learn the most important lifestyle changes and habits that can help you maintain a healthy heart and prevent cardiovascular diseases.',
                'content' => '<h2>Introduction</h2><p>Heart health is crucial for overall well-being. Cardiovascular diseases remain one of the leading causes of death worldwide, but many heart conditions can be prevented through lifestyle modifications.</p><h2>1. Regular Exercise</h2><p>Engage in at least 150 minutes of moderate-intensity aerobic activity or 75 minutes of vigorous-intensity activity per week. Regular exercise strengthens your heart muscle and improves circulation.</p><h2>2. Healthy Diet</h2><p>Focus on a diet rich in fruits, vegetables, whole grains, lean proteins, and healthy fats. Limit saturated fats, trans fats, sodium, and added sugars.</p><h2>3. Maintain Healthy Weight</h2><p>Being overweight or obese increases your risk of heart disease. Work with your healthcare provider to achieve and maintain a healthy weight.</p><h2>4. Quit Smoking</h2><p>Smoking is a major risk factor for heart disease. Quitting smoking is one of the best things you can do for your heart health.</p><h2>5. Manage Stress</h2><p>Chronic stress can contribute to heart disease. Practice stress-reduction techniques like meditation, yoga, or deep breathing exercises.</p><h2>Conclusion</h2><p>Taking care of your heart is a lifelong commitment. By following these tips and working closely with your healthcare provider, you can significantly reduce your risk of heart disease.</p>',
                'author_id' => $admin->id,
                'featured_image' => '/images/blogs/heart-health.jpg',
                'category' => 'Cardiology',
                'tags' => ['heart health', 'cardiovascular', 'prevention', 'lifestyle'],
                'status' => 'published',
                'published_at' => now()->subDays(10),
                'views' => 245,
            ],
            [
                'title' => 'Understanding Diabetes: Types, Symptoms, and Management',
                'excerpt' => 'A comprehensive guide to understanding diabetes, its different types, warning signs, and effective management strategies.',
                'content' => '<h2>What is Diabetes?</h2><p>Diabetes is a chronic condition that affects how your body processes blood sugar (glucose). Understanding diabetes is the first step toward effective management.</p><h2>Types of Diabetes</h2><h3>Type 1 Diabetes</h3><p>An autoimmune condition where the body does not produce insulin. Usually diagnosed in children and young adults.</p><h3>Type 2 Diabetes</h3><p>The most common form, where the body does not use insulin properly. Often related to lifestyle factors and can be prevented or delayed.</p><h3>Gestational Diabetes</h3><p>Develops during pregnancy and usually resolves after delivery, but increases risk of Type 2 diabetes later.</p><h2>Common Symptoms</h2><ul><li>Increased thirst and frequent urination</li><li>Extreme hunger</li><li>Unexplained weight loss</li><li>Fatigue</li><li>Blurred vision</li><li>Slow-healing sores</li></ul><h2>Management Strategies</h2><p>Effective diabetes management includes blood sugar monitoring, healthy eating, regular exercise, and medication as prescribed by your healthcare provider.</p>',
                'author_id' => $admin->id,
                'featured_image' => '/images/blogs/diabetes-guide.jpg',
                'category' => 'Endocrinology',
                'tags' => ['diabetes', 'blood sugar', 'chronic disease', 'health management'],
                'status' => 'published',
                'published_at' => now()->subDays(8),
                'views' => 189,
            ],
            [
                'title' => 'The Importance of Regular Health Check-ups',
                'excerpt' => 'Discover why regular health screenings and check-ups are essential for early detection and prevention of diseases.',
                'content' => '<h2>Why Regular Check-ups Matter</h2><p>Regular health check-ups are crucial for maintaining good health and catching potential problems early when they are most treatable.</p><h2>Recommended Screenings by Age</h2><h3>In Your 20s and 30s</h3><ul><li>Blood pressure check</li><li>Cholesterol screening</li><li>Diabetes screening (if at risk)</li><li>Skin cancer screening</li></ul><h3>In Your 40s and 50s</h3><ul><li>All of the above, plus:</li><li>Mammograms for women</li><li>Colonoscopy screening</li><li>Prostate screening for men</li></ul><h3>60 and Beyond</h3><ul><li>More frequent screenings</li><li>Bone density tests</li><li>Vision and hearing tests</li></ul><h2>Benefits of Preventive Care</h2><p>Early detection saves lives and reduces healthcare costs. Many serious conditions can be prevented or treated more effectively when caught early.</p>',
                'author_id' => $admin->id,
                'featured_image' => '/images/blogs/health-checkup.jpg',
                'category' => 'Preventive Care',
                'tags' => ['preventive care', 'health screening', 'check-up', 'early detection'],
                'status' => 'published',
                'published_at' => now()->subDays(6),
                'views' => 156,
            ],
            [
                'title' => 'Mental Health Matters: Breaking the Stigma',
                'excerpt' => 'Understanding mental health, recognizing the signs of mental illness, and knowing when to seek help.',
                'content' => '<h2>Mental Health is Health</h2><p>Mental health is just as important as physical health. Yet, stigma and misconceptions often prevent people from seeking the help they need.</p><h2>Common Mental Health Conditions</h2><h3>Depression</h3><p>More than just feeling sad, depression is a serious medical condition that affects how you feel, think, and handle daily activities.</p><h3>Anxiety Disorders</h3><p>Characterized by excessive worry, fear, or nervousness that interferes with daily life.</p><h3>Stress</h3><p>While stress is a normal part of life, chronic stress can lead to serious health problems.</p><h2>Warning Signs</h2><ul><li>Persistent sadness or anxiety</li><li>Changes in sleep or appetite</li><li>Loss of interest in activities</li><li>Difficulty concentrating</li><li>Physical symptoms without clear cause</li></ul><h2>Seeking Help</h2><p>If you are experiencing mental health challenges, reach out to a mental health professional. Treatment is effective, and recovery is possible.</p>',
                'author_id' => $admin->id,
                'featured_image' => '/images/blogs/mental-health.jpg',
                'category' => 'Mental Health',
                'tags' => ['mental health', 'depression', 'anxiety', 'wellness'],
                'status' => 'published',
                'published_at' => now()->subDays(4),
                'views' => 312,
            ],
            [
                'title' => 'Nutrition Guide: Eating for Optimal Health',
                'excerpt' => 'A practical guide to healthy eating, understanding nutrients, and making better food choices for your health.',
                'content' => '<h2>The Foundation of Good Health</h2><p>Proper nutrition is the cornerstone of good health. What you eat directly impacts your energy levels, immune system, and risk of chronic diseases.</p><h2>Essential Nutrients</h2><h3>Macronutrients</h3><ul><li><strong>Proteins:</strong> Building blocks for muscles and tissues</li><li><strong>Carbohydrates:</strong> Primary energy source</li><li><strong>Fats:</strong> Essential for hormone production and nutrient absorption</li></ul><h3>Micronutrients</h3><p>Vitamins and minerals are crucial for various body functions, from bone health to immune function.</p><h2>Building a Healthy Plate</h2><ul><li>Fill half your plate with fruits and vegetables</li><li>One quarter with lean protein</li><li>One quarter with whole grains</li><li>Include healthy fats in moderation</li></ul><h2>Hydration</h2><p>Drink plenty of water throughout the day. Aim for 8-10 glasses daily, more if you are active or in hot weather.</p>',
                'author_id' => $admin->id,
                'featured_image' => '/images/blogs/nutrition-guide.jpg',
                'category' => 'Nutrition',
                'tags' => ['nutrition', 'healthy eating', 'diet', 'wellness'],
                'status' => 'published',
                'published_at' => now()->subDays(2),
                'views' => 198,
            ],
            [
                'title' => 'Sleep Hygiene: The Key to Better Rest',
                'excerpt' => 'Learn how to improve your sleep quality with proven sleep hygiene practices and understand why sleep is crucial for health.',
                'content' => '<h2>Why Sleep Matters</h2><p>Quality sleep is essential for physical health, mental well-being, and overall quality of life. During sleep, your body repairs itself and consolidates memories.</p><h2>How Much Sleep Do You Need?</h2><ul><li>Adults: 7-9 hours per night</li><li>Teenagers: 8-10 hours</li><li>Children: 9-12 hours</li></ul><h2>Sleep Hygiene Tips</h2><h3>Create a Sleep Schedule</h3><p>Go to bed and wake up at the same time every day, even on weekends.</p><h3>Optimize Your Environment</h3><ul><li>Keep your bedroom cool, dark, and quiet</li><li>Invest in a comfortable mattress and pillows</li><li>Remove electronic devices</li></ul><h3>Develop a Bedtime Routine</h3><p>Wind down with relaxing activities like reading, gentle stretching, or meditation.</p><h3>Watch What You Consume</h3><ul><li>Avoid caffeine after 2 PM</li><li>Limit alcohol consumption</li><li>Do not eat heavy meals close to bedtime</li></ul>',
                'author_id' => $admin->id,
                'featured_image' => '/images/blogs/sleep-hygiene.jpg',
                'category' => 'Wellness',
                'tags' => ['sleep', 'rest', 'sleep hygiene', 'health'],
                'status' => 'published',
                'published_at' => now()->subDay(),
                'views' => 134,
            ],
            [
                'title' => 'Pediatric Care: Common Childhood Illnesses and When to See a Doctor',
                'excerpt' => 'A parent\'s guide to recognizing common childhood illnesses and knowing when medical attention is necessary.',
                'content' => '<h2>Common Childhood Illnesses</h2><p>Children frequently experience various illnesses as their immune systems develop. Understanding common conditions helps parents provide appropriate care.</p><h2>Respiratory Infections</h2><h3>Common Cold</h3><p>Symptoms include runny nose, cough, and mild fever. Usually resolves on its own within 7-10 days.</p><h3>Flu</h3><p>More severe than a cold, with high fever, body aches, and fatigue. Vaccination is recommended.</p><h2>Gastrointestinal Issues</h2><p>Stomach bugs are common in children. Ensure proper hydration and watch for signs of dehydration.</p><h2>When to See a Doctor</h2><ul><li>High fever (over 102°F in children under 3 months)</li><li>Difficulty breathing</li><li>Persistent vomiting or diarrhea</li><li>Signs of dehydration</li><li>Unusual lethargy or irritability</li><li>Rash with fever</li></ul><h2>Prevention</h2><p>Regular handwashing, up-to-date vaccinations, and healthy lifestyle habits help prevent many childhood illnesses.</p>',
                'author_id' => $admin->id,
                'featured_image' => '/images/blogs/pediatric-care.jpg',
                'category' => 'Pediatrics',
                'tags' => ['pediatrics', 'children health', 'parenting', 'illness'],
                'status' => 'published',
                'published_at' => now()->subHours(12),
                'views' => 87,
            ],
            [
                'title' => 'Understanding Allergies: Types, Triggers, and Treatment',
                'excerpt' => 'Learn about different types of allergies, how to identify triggers, and effective treatment options.',
                'content' => '<h2>What Are Allergies?</h2><p>Allergies occur when your immune system reacts to a foreign substance that does not cause a reaction in most people.</p><h2>Common Types of Allergies</h2><h3>Seasonal Allergies</h3><p>Also known as hay fever, caused by pollen from trees, grasses, and weeds.</p><h3>Food Allergies</h3><p>Common food allergens include peanuts, tree nuts, milk, eggs, wheat, soy, fish, and shellfish.</p><h3>Drug Allergies</h3><p>Some people are allergic to certain medications, particularly antibiotics.</p><h3>Insect Allergies</h3><p>Bee stings and other insect bites can cause allergic reactions in some people.</p><h2>Symptoms</h2><ul><li>Sneezing and runny nose</li><li>Itchy, watery eyes</li><li>Skin rashes or hives</li><li>Swelling</li><li>Difficulty breathing (in severe cases)</li></ul><h2>Treatment Options</h2><p>Treatment may include antihistamines, decongestants, nasal sprays, or immunotherapy. Severe allergies may require an epinephrine auto-injector.</p>',
                'author_id' => $admin->id,
                'featured_image' => '/images/blogs/allergies.jpg',
                'category' => 'Immunology',
                'tags' => ['allergies', 'immune system', 'treatment', 'health'],
                'status' => 'draft',
                'published_at' => null,
                'views' => 0,
            ],
            [
                'title' => 'Orthopedic Health: Preventing and Managing Joint Pain',
                'excerpt' => 'Expert advice on maintaining joint health, preventing injuries, and managing arthritis and other joint conditions.',
                'content' => '<h2>Understanding Joint Health</h2><p>Joints are where two bones meet, allowing movement and flexibility. Maintaining joint health is crucial for mobility and quality of life.</p><h2>Common Joint Problems</h2><h3>Arthritis</h3><p>Inflammation of one or more joints, causing pain and stiffness. The most common types are osteoarthritis and rheumatoid arthritis.</p><h3>Sports Injuries</h3><p>Sprains, strains, and tears can occur during physical activity.</p><h3>Bursitis</h3><p>Inflammation of the fluid-filled sacs that cushion joints.</p><h2>Prevention Strategies</h2><ul><li>Maintain a healthy weight</li><li>Exercise regularly to strengthen muscles</li><li>Use proper form during activities</li><li>Warm up before exercise</li><li>Wear appropriate protective gear</li></ul><h2>Treatment Options</h2><p>Treatment depends on the condition but may include physical therapy, medications, injections, or in some cases, surgery.</p>',
                'author_id' => $admin->id,
                'featured_image' => '/images/blogs/joint-health.jpg',
                'category' => 'Orthopedics',
                'tags' => ['orthopedics', 'joint health', 'arthritis', 'pain management'],
                'status' => 'draft',
                'published_at' => null,
                'views' => 0,
            ],
            [
                'title' => 'Eye Care Essentials: Protecting Your Vision',
                'excerpt' => 'Important tips for maintaining eye health and preventing vision problems as you age.',
                'content' => '<h2>The Importance of Eye Health</h2><p>Your eyes are precious. Taking care of them now can help prevent vision problems later in life.</p><h2>Common Eye Conditions</h2><h3>Refractive Errors</h3><p>Nearsightedness, farsightedness, and astigmatism are common and easily corrected with glasses or contact lenses.</p><h3>Age-Related Conditions</h3><ul><li>Cataracts: Clouding of the eye lens</li><li>Glaucoma: Damage to the optic nerve</li><li>Macular degeneration: Deterioration of central vision</li></ul><h2>Eye Care Tips</h2><ul><li>Get regular eye exams</li><li>Wear sunglasses with UV protection</li><li>Take breaks from screens (20-20-20 rule)</li><li>Eat a diet rich in omega-3 fatty acids and vitamins</li><li>Do not smoke</li><li>Maintain healthy blood pressure and blood sugar</li></ul><h2>When to See an Eye Doctor</h2><p>Schedule an appointment if you experience sudden vision changes, eye pain, flashes of light, or increased floaters.</p>',
                'author_id' => $admin->id,
                'featured_image' => '/images/blogs/eye-care.jpg',
                'category' => 'Ophthalmology',
                'tags' => ['eye health', 'vision', 'eye care', 'prevention'],
                'status' => 'draft',
                'published_at' => null,
                'views' => 0,
            ],
        ];

        foreach ($blogs as $blog) {
            Blog::create($blog);
        }

        $this->command->info('✅ 10 blog posts created successfully!');
        $this->command->info('   - 7 Published blogs');
        $this->command->info('   - 3 Draft blogs');
    }
}
