# Sprint 1: Database & Models - Summary

## ✅ Completed Successfully!

### 📊 Database Tables Created

All migrations have been successfully created and executed.

---

## 🗄️ Database Schema

### 1. **Users Table** (Enhanced for Doctors)
**File:** `database/migrations/0001_01_01_000000_create_users_table.php`

| Column | Type | Description |
|--------|------|-------------|
| id | bigint | Primary key |
| name | string | User's full name |
| email | string | Unique email address |
| email_verified_at | timestamp | Email verification timestamp |
| password | string | Hashed password |
| **role** | enum | 'admin', 'doctor', 'patient' (default: 'patient') |
| **phone** | string | Contact phone number |
| **address** | text | User's address |
| **specialization** | string | Doctor's specialization |
| **bio** | text | Doctor's biography |
| **license_number** | string | Doctor's license number |
| **years_of_experience** | integer | Years of experience (for doctors) |
| **consultation_fee** | decimal(8,2) | Consultation fee (for doctors) |
| **profile_image** | string | Profile image path |
| **is_active** | boolean | Account active status (default: true) |
| remember_token | string | Remember me token |
| created_at | timestamp | Creation timestamp |
| updated_at | timestamp | Last update timestamp |

**Additional Tables:**
- `password_reset_tokens` - For password reset functionality
- `sessions` - For session management

---

### 2. **Services Table**
**File:** `database/migrations/2025_12_30_065013_create_services_table.php`

| Column | Type | Description |
|--------|------|-------------|
| id | bigint | Primary key |
| name | string | Service name |
| slug | string | Unique URL-friendly identifier |
| description | text | Full service description |
| short_description | text | Brief service description |
| price | decimal(10,2) | Service price |
| duration | integer | Duration in minutes |
| icon | string | Icon class or image path |
| image | string | Service image path |
| is_active | boolean | Service active status (default: true) |
| order | integer | Display order (default: 0) |
| created_at | timestamp | Creation timestamp |
| updated_at | timestamp | Last update timestamp |

---

### 3. **Appointments Table**
**File:** `database/migrations/2025_12_30_065020_create_appointments_table.php`

| Column | Type | Description |
|--------|------|-------------|
| id | bigint | Primary key |
| doctor_id | bigint | Foreign key to users table (nullable) |
| service_id | bigint | Foreign key to services table (nullable) |
| **name** | string | Patient/Visitor name |
| **phone** | string | Contact phone number |
| **message** | text | Appointment message/notes |
| **preferred_date** | date | Preferred appointment date |
| preferred_time | time | Preferred appointment time |
| **status** | enum | 'pending', 'confirmed', 'completed', 'cancelled', 'rejected' (default: 'pending') |
| admin_notes | text | Admin/Doctor notes |
| confirmed_at | timestamp | Confirmation timestamp |
| created_at | timestamp | Creation timestamp |
| updated_at | timestamp | Last update timestamp |

**Foreign Keys:**
- `doctor_id` → `users.id` (cascade on delete)
- `service_id` → `services.id` (set null on delete)

---

### 4. **Blogs Table**
**File:** `database/migrations/2025_12_30_065019_create_blogs_table.php`

| Column | Type | Description |
|--------|------|-------------|
| id | bigint | Primary key |
| author_id | bigint | Foreign key to users table |
| title | string | Blog post title |
| slug | string | Unique URL-friendly identifier |
| excerpt | text | Short excerpt/summary |
| content | longtext | Full blog content |
| featured_image | string | Featured image path |
| category | string | Blog category |
| tags | json | Array of tags |
| status | enum | 'draft', 'published', 'archived' (default: 'draft') |
| views | integer | View count (default: 0) |
| published_at | timestamp | Publication timestamp |
| created_at | timestamp | Creation timestamp |
| updated_at | timestamp | Last update timestamp |

**Foreign Keys:**
- `author_id` → `users.id` (cascade on delete)

---

## 📦 Models Created

### 1. **User Model**
**File:** `app/Models/User.php`

**Features:**
- Extended with doctor-specific fields
- Role-based helper methods:
  - `isDoctor()` - Check if user is a doctor
  - `isAdmin()` - Check if user is an admin
  - `isPatient()` - Check if user is a patient
- Relationships:
  - `doctorAppointments()` - Get appointments for doctor
  - `blogs()` - Get blogs authored by user
- Mass assignable fields for all user attributes
- Proper casting for boolean and decimal fields

---

### 2. **Appointment Model**
**File:** `app/Models/Appointment.php`

**Features:**
- Mass assignable fields: name, phone, message, preferred_date, status, etc.
- Relationships:
  - `doctor()` - Get associated doctor
  - `service()` - Get associated service
- Query Scopes:
  - `pending()` - Filter pending appointments
  - `confirmed()` - Filter confirmed appointments
  - `completed()` - Filter completed appointments
  - `cancelled()` - Filter cancelled appointments
- Status Helper Methods:
  - `isPending()` - Check if pending
  - `isConfirmed()` - Check if confirmed
  - `isCompleted()` - Check if completed
  - `isCancelled()` - Check if cancelled
- Proper date/time casting

---

### 3. **Service Model**
**File:** `app/Models/Service.php`

**Features:**
- Auto-generates slug from name
- Mass assignable fields for all service attributes
- Relationships:
  - `appointments()` - Get appointments for this service
- Query Scopes:
  - `active()` - Filter active services
  - `ordered()` - Order by display order
- Proper casting for price and boolean fields
- Automatic slug generation on create/update

---

### 4. **Blog Model**
**File:** `app/Models/Blog.php`

**Features:**
- Auto-generates slug from title
- Mass assignable fields for all blog attributes
- Relationships:
  - `author()` - Get blog author
- Query Scopes:
  - `published()` - Filter published blogs
  - `draft()` - Filter draft blogs
  - `category($category)` - Filter by category
  - `popular()` - Order by views
  - `latest()` - Order by publication date
- Helper Methods:
  - `incrementViews()` - Increment view count
  - `isPublished()` - Check if published
  - `isDraft()` - Check if draft
- Proper casting for tags (JSON) and dates
- Automatic slug generation on create/update

---

## 🔗 Relationships Summary

```
User (Doctor)
  ├── hasMany → Appointments (as doctor)
  └── hasMany → Blogs (as author)

Service
  └── hasMany → Appointments

Appointment
  ├── belongsTo → User (doctor)
  └── belongsTo → Service

Blog
  └── belongsTo → User (author)
```

---

## ✨ Key Features Implemented

### Appointments
✅ Name field for patient/visitor  
✅ Phone field for contact  
✅ Message field for notes  
✅ Preferred date field  
✅ Status field with multiple states  
✅ Doctor assignment (optional)  
✅ Service assignment (optional)  
✅ Admin notes capability  
✅ Confirmation tracking  

### Users (Doctors)
✅ Role-based system (admin, doctor, patient)  
✅ Doctor-specific fields (specialization, license, etc.)  
✅ Consultation fee tracking  
✅ Profile image support  
✅ Active/inactive status  

### Services
✅ Service management  
✅ Pricing and duration  
✅ Active/inactive status  
✅ Display ordering  
✅ Auto-slug generation  

### Blogs
✅ Author tracking  
✅ Draft/Published status  
✅ Category and tags  
✅ View counting  
✅ Featured images  
✅ Auto-slug generation  

---

## 🎯 Database Status

```bash
✅ All migrations created
✅ All migrations executed successfully
✅ All models created with relationships
✅ All models have proper casting
✅ All models have helper methods
✅ Foreign keys properly configured
```

---

## 📝 Migration Files

1. `0001_01_01_000000_create_users_table.php` ✅
2. `0001_01_01_000001_create_cache_table.php` ✅
3. `0001_01_01_000002_create_jobs_table.php` ✅
4. `2025_12_30_065013_create_services_table.php` ✅
5. `2025_12_30_065019_create_blogs_table.php` ✅
6. `2025_12_30_065020_create_appointments_table.php` ✅

---

## 📝 Model Files

1. `app/Models/User.php` ✅
2. `app/Models/Appointment.php` ✅
3. `app/Models/Service.php` ✅
4. `app/Models/Blog.php` ✅

---

## 🔧 Useful Commands

### View Database Tables
```bash
php artisan db:show
```

### View Specific Table Structure
```bash
php artisan db:table users
php artisan db:table appointments
php artisan db:table services
php artisan db:table blogs
```

### Rollback Migrations
```bash
php artisan migrate:rollback
```

### Fresh Migration (Drop all tables and re-run)
```bash
php artisan migrate:fresh
```

### Create Seeders
```bash
php artisan make:seeder UserSeeder
php artisan make:seeder ServiceSeeder
php artisan make:seeder AppointmentSeeder
php artisan make:seeder BlogSeeder
```

---

## 📊 Example Usage

### Create a Doctor
```php
$doctor = User::create([
    'name' => 'Dr. John Smith',
    'email' => 'dr.smith@example.com',
    'password' => bcrypt('password'),
    'role' => 'doctor',
    'specialization' => 'Cardiology',
    'license_number' => 'LIC123456',
    'years_of_experience' => 15,
    'consultation_fee' => 150.00,
    'is_active' => true,
]);
```

### Create an Appointment
```php
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
```

### Create a Service
```php
$service = Service::create([
    'name' => 'General Consultation',
    'description' => 'General health checkup and consultation',
    'price' => 100.00,
    'duration' => 30,
    'is_active' => true,
]);
```

### Create a Blog Post
```php
$blog = Blog::create([
    'author_id' => 1,
    'title' => 'Heart Health Tips',
    'content' => 'Content here...',
    'category' => 'Health Tips',
    'tags' => ['heart', 'health', 'tips'],
    'status' => 'published',
    'published_at' => now(),
]);
```

### Query Examples
```php
// Get all pending appointments
$pending = Appointment::pending()->get();

// Get all active services
$services = Service::active()->ordered()->get();

// Get published blogs
$blogs = Blog::published()->latest()->get();

// Get all doctors
$doctors = User::where('role', 'doctor')->where('is_active', true)->get();

// Get doctor's appointments
$doctor = User::find(1);
$appointments = $doctor->doctorAppointments()->confirmed()->get();
```

---

## 🎉 Sprint 1 Complete!

All database migrations and models have been successfully created and tested.

**Next Steps:**
- Sprint 2: Create API Controllers
- Sprint 3: Implement Authentication
- Sprint 4: Add Request Validation
- Sprint 5: Create API Resources

---

**Created:** 2025-12-30  
**Status:** ✅ Complete  
**Database:** MySQL  
**Framework:** Laravel 12
