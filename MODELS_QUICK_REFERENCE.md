# Models Quick Reference Guide

## 🚀 Quick Usage Examples

### User Model

```php
use App\Models\User;

// Create a doctor
$doctor = User::create([
    'name' => 'Dr. John Smith',
    'email' => 'dr.smith@example.com',
    'password' => bcrypt('password'),
    'role' => 'doctor',
    'phone' => '+1234567890',
    'specialization' => 'Cardiology',
    'license_number' => 'LIC123456',
    'years_of_experience' => 15,
    'consultation_fee' => 150.00,
    'bio' => 'Experienced cardiologist...',
    'is_active' => true,
]);

// Check user role
if ($user->isDoctor()) {
    // Doctor-specific logic
}

// Get doctor's appointments
$appointments = $doctor->doctorAppointments()->get();

// Get doctor's blogs
$blogs = $doctor->blogs()->get();

// Find all active doctors
$doctors = User::where('role', 'doctor')
               ->where('is_active', true)
               ->get();
```

---

### Appointment Model

```php
use App\Models\Appointment;

// Create an appointment
$appointment = Appointment::create([
    'doctor_id' => 1,
    'service_id' => 1,
    'name' => 'Jane Doe',
    'phone' => '+1234567890',
    'message' => 'Need consultation for chest pain',
    'preferred_date' => '2025-01-15',
    'preferred_time' => '10:00:00',
    'status' => 'pending',
]);

// Query appointments by status
$pending = Appointment::pending()->get();
$confirmed = Appointment::confirmed()->get();
$completed = Appointment::completed()->get();
$cancelled = Appointment::cancelled()->get();

// Check appointment status
if ($appointment->isPending()) {
    // Send confirmation email
}

// Get appointment with relationships
$appointment = Appointment::with(['doctor', 'service'])->find(1);
echo $appointment->doctor->name;
echo $appointment->service->name;

// Update appointment status
$appointment->update([
    'status' => 'confirmed',
    'confirmed_at' => now(),
]);

// Get appointments for a specific doctor
$doctorAppointments = Appointment::where('doctor_id', 1)
                                 ->confirmed()
                                 ->get();

// Get appointments for a specific date
$todayAppointments = Appointment::whereDate('preferred_date', today())
                                ->confirmed()
                                ->get();
```

---

### Service Model

```php
use App\Models\Service;

// Create a service
$service = Service::create([
    'name' => 'General Consultation',
    'description' => 'General health checkup and consultation',
    'short_description' => 'Basic health checkup',
    'price' => 100.00,
    'duration' => 30,
    'icon' => 'fa-stethoscope',
    'is_active' => true,
    'order' => 1,
]);
// Slug is auto-generated: 'general-consultation'

// Get all active services
$services = Service::active()->ordered()->get();

// Get service with appointments
$service = Service::with('appointments')->find(1);
$appointmentCount = $service->appointments->count();

// Find service by slug
$service = Service::where('slug', 'general-consultation')->first();

// Update service
$service->update([
    'price' => 120.00,
    'duration' => 45,
]);

// Deactivate service
$service->update(['is_active' => false]);

// Get services ordered by display order
$orderedServices = Service::ordered()->get();
```

---

### Blog Model

```php
use App\Models\Blog;

// Create a blog post
$blog = Blog::create([
    'author_id' => 1,
    'title' => '10 Tips for Heart Health',
    'excerpt' => 'Learn how to keep your heart healthy...',
    'content' => 'Full blog content here...',
    'featured_image' => 'images/heart-health.jpg',
    'category' => 'Health Tips',
    'tags' => ['heart', 'health', 'tips', 'cardiology'],
    'status' => 'published',
    'published_at' => now(),
]);
// Slug is auto-generated: '10-tips-for-heart-health'

// Get published blogs
$blogs = Blog::published()->latest()->get();

// Get draft blogs
$drafts = Blog::draft()->get();

// Get blogs by category
$healthTips = Blog::published()->category('Health Tips')->get();

// Get popular blogs
$popular = Blog::published()->popular()->take(5)->get();

// Get blog with author
$blog = Blog::with('author')->find(1);
echo $blog->author->name;

// Increment views
$blog->incrementViews();

// Check blog status
if ($blog->isPublished()) {
    // Display blog
}

// Find blog by slug
$blog = Blog::where('slug', '10-tips-for-heart-health')->first();

// Get latest blogs
$latestBlogs = Blog::published()->latest()->take(10)->get();

// Search blogs by title or content
$results = Blog::published()
              ->where(function($query) use ($searchTerm) {
                  $query->where('title', 'like', "%{$searchTerm}%")
                        ->orWhere('content', 'like', "%{$searchTerm}%");
              })
              ->get();
```

---

## 🔗 Relationship Examples

### Get Doctor's Appointments
```php
$doctor = User::find(1);
$appointments = $doctor->doctorAppointments()
                      ->where('status', 'confirmed')
                      ->whereDate('preferred_date', '>=', today())
                      ->get();
```

### Get Appointment with Doctor and Service
```php
$appointment = Appointment::with(['doctor', 'service'])->find(1);

echo "Patient: " . $appointment->name;
echo "Doctor: " . $appointment->doctor->name;
echo "Service: " . $appointment->service->name;
echo "Fee: $" . $appointment->service->price;
```

### Get Service with All Appointments
```php
$service = Service::with('appointments')->find(1);

echo "Service: " . $service->name;
echo "Total Appointments: " . $service->appointments->count();
echo "Pending: " . $service->appointments->where('status', 'pending')->count();
```

### Get Blog with Author Details
```php
$blog = Blog::with('author')->find(1);

echo "Title: " . $blog->title;
echo "Author: " . $blog->author->name;
echo "Specialization: " . $blog->author->specialization;
```

### Get User's Blogs
```php
$user = User::find(1);
$blogs = $user->blogs()->published()->latest()->get();

foreach ($blogs as $blog) {
    echo $blog->title . " - " . $blog->views . " views\n";
}
```

---

## 📊 Advanced Queries

### Dashboard Statistics
```php
// Total appointments by status
$stats = [
    'pending' => Appointment::pending()->count(),
    'confirmed' => Appointment::confirmed()->count(),
    'completed' => Appointment::completed()->count(),
    'cancelled' => Appointment::cancelled()->count(),
];

// Today's appointments
$todayAppointments = Appointment::whereDate('preferred_date', today())
                                ->confirmed()
                                ->count();

// Active doctors count
$activeDoctors = User::where('role', 'doctor')
                    ->where('is_active', true)
                    ->count();

// Published blogs count
$publishedBlogs = Blog::published()->count();

// Active services count
$activeServices = Service::active()->count();
```

### Monthly Appointment Report
```php
$monthlyAppointments = Appointment::whereYear('preferred_date', date('Y'))
                                 ->whereMonth('preferred_date', date('m'))
                                 ->get()
                                 ->groupBy('status');
```

### Top Doctors by Appointments
```php
$topDoctors = User::where('role', 'doctor')
                 ->withCount(['doctorAppointments' => function($query) {
                     $query->where('status', 'completed');
                 }])
                 ->orderBy('doctor_appointments_count', 'desc')
                 ->take(10)
                 ->get();
```

### Most Popular Services
```php
$popularServices = Service::withCount('appointments')
                         ->orderBy('appointments_count', 'desc')
                         ->take(5)
                         ->get();
```

### Most Viewed Blogs
```php
$popularBlogs = Blog::published()
                   ->popular()
                   ->take(10)
                   ->get();
```

---

## 🎯 Validation Examples

### Appointment Validation
```php
$validated = $request->validate([
    'doctor_id' => 'nullable|exists:users,id',
    'service_id' => 'nullable|exists:services,id',
    'name' => 'required|string|max:255',
    'phone' => 'required|string|max:20',
    'message' => 'nullable|string',
    'preferred_date' => 'required|date|after:today',
    'preferred_time' => 'nullable|date_format:H:i:s',
    'status' => 'in:pending,confirmed,completed,cancelled,rejected',
]);
```

### Service Validation
```php
$validated = $request->validate([
    'name' => 'required|string|max:255',
    'slug' => 'nullable|string|unique:services,slug',
    'description' => 'nullable|string',
    'price' => 'nullable|numeric|min:0',
    'duration' => 'nullable|integer|min:1',
    'is_active' => 'boolean',
]);
```

### Blog Validation
```php
$validated = $request->validate([
    'title' => 'required|string|max:255',
    'slug' => 'nullable|string|unique:blogs,slug',
    'content' => 'required|string',
    'category' => 'nullable|string|max:100',
    'tags' => 'nullable|array',
    'status' => 'in:draft,published,archived',
    'published_at' => 'nullable|date',
]);
```

---

## 💡 Tips & Best Practices

1. **Always use relationships** instead of manual joins
2. **Use scopes** for common queries (e.g., `->published()`, `->active()`)
3. **Eager load relationships** to avoid N+1 queries: `->with(['doctor', 'service'])`
4. **Use mass assignment** with `$fillable` property
5. **Cast attributes** properly for type safety
6. **Use helper methods** for status checks (e.g., `->isPending()`)
7. **Auto-generate slugs** in model boot method
8. **Use transactions** for complex operations

---

## 🔧 Common Patterns

### Pagination
```php
$appointments = Appointment::with(['doctor', 'service'])
                          ->latest()
                          ->paginate(15);
```

### Search
```php
$results = Appointment::where('name', 'like', "%{$search}%")
                     ->orWhere('phone', 'like', "%{$search}%")
                     ->get();
```

### Soft Deletes (if needed)
```php
// Add to migration
$table->softDeletes();

// Add to model
use SoftDeletes;

// Query
$appointments = Appointment::withTrashed()->get();
$deleted = Appointment::onlyTrashed()->get();
```

---

**Created:** 2025-12-30  
**Framework:** Laravel 12  
**Database:** MySQL
