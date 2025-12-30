# Doctor Appointment API - Setup Guide

## Quick Start

### 1. Database Setup

Make sure MySQL is running, then create the database:

```bash
# Using MySQL command line
mysql -u root -p

# In MySQL prompt
CREATE DATABASE doctor_appointment_db;
exit;
```

Or if you're using XAMPP/WAMP, you can create the database through phpMyAdmin.

### 2. Environment Configuration

The `.env` file is already configured with MySQL settings:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=doctor_appointment_db
DB_USERNAME=root
DB_PASSWORD=
```

**Update the password if your MySQL root user has a password.**

### 3. Run Migrations

```bash
cd doctor-appointment-api
php artisan migrate
```

This will create the default Laravel tables (users, cache, jobs, etc.).

### 4. Start the Server

```bash
php artisan serve
```

The API will be available at: `http://localhost:8000`

### 5. Test the API

Open your browser or use curl:

```bash
curl http://localhost:8000/api/health
```

Expected response:
```json
{
    "status": "success",
    "message": "Doctor Appointment API is running",
    "timestamp": "2024-01-01 12:00:00"
}
```

## Project Structure

```
doctor-appointment-api/
├── app/
│   ├── Http/
│   │   └── Controllers/
│   │       └── Api/
│   │           └── ApiController.php    # Base controller with response helpers
│   ├── Models/                          # Eloquent models (to be created)
│   └── Providers/
├── config/
│   └── api.php                          # API-specific configuration
├── database/
│   ├── migrations/                      # Database migrations
│   └── seeders/                         # Database seeders
├── routes/
│   ├── api.php                          # API routes (configured)
│   └── web.php                          # Web routes (minimal usage)
├── .env                                 # Environment config (MySQL configured)
└── README.md                            # Full documentation
```

## What's Configured

✅ **Laravel 12 Project** - Latest version installed
✅ **MySQL Database** - Configured in .env
✅ **API Routes** - Registered in bootstrap/app.php with `/api` prefix
✅ **Base API Controller** - With standardized response methods
✅ **Health Check Endpoint** - `/api/health` for monitoring
✅ **API Configuration** - Custom config file for API settings
✅ **No Blade Views** - Pure API-only setup

## Next Development Steps

### 1. Install Laravel Sanctum (for API authentication)

```bash
php artisan install:api
```

This will:
- Install Sanctum package
- Publish Sanctum configuration
- Run Sanctum migrations

### 2. Create Models and Migrations

```bash
# Doctor model
php artisan make:model Doctor -m

# Patient model
php artisan make:model Patient -m

# Appointment model
php artisan make:model Appointment -m

# Specialization model
php artisan make:model Specialization -m
```

### 3. Create Controllers

```bash
# Auth controller
php artisan make:controller Api/AuthController

# Doctor controller
php artisan make:controller Api/DoctorController --api

# Patient controller
php artisan make:controller Api/PatientController --api

# Appointment controller
php artisan make:controller Api/AppointmentController --api

# Specialization controller
php artisan make:controller Api/SpecializationController --api
```

### 4. Create Request Validators

```bash
php artisan make:request RegisterRequest
php artisan make:request LoginRequest
php artisan make:request DoctorRequest
php artisan make:request PatientRequest
php artisan make:request AppointmentRequest
```

### 5. Create API Resources (for response transformation)

```bash
php artisan make:resource DoctorResource
php artisan make:resource PatientResource
php artisan make:resource AppointmentResource
php artisan make:resource UserResource
```

## Database Schema Suggestions

### Doctors Table
- id
- user_id (foreign key to users)
- specialization_id (foreign key)
- license_number
- years_of_experience
- consultation_fee
- bio
- timestamps

### Patients Table
- id
- user_id (foreign key to users)
- date_of_birth
- blood_group
- address
- emergency_contact
- timestamps

### Appointments Table
- id
- doctor_id (foreign key)
- patient_id (foreign key)
- appointment_date
- appointment_time
- status (pending, confirmed, completed, cancelled)
- reason
- notes
- timestamps

### Specializations Table
- id
- name
- description
- timestamps

## API Endpoints to Implement

### Authentication
- POST `/api/v1/register` - Register user
- POST `/api/v1/login` - Login user
- POST `/api/v1/logout` - Logout user

### Doctors
- GET `/api/v1/doctors` - List all doctors
- GET `/api/v1/doctors/{id}` - Get doctor details
- POST `/api/v1/doctors` - Create doctor (admin)
- PUT `/api/v1/doctors/{id}` - Update doctor
- DELETE `/api/v1/doctors/{id}` - Delete doctor (admin)

### Patients
- GET `/api/v1/patients` - List all patients (admin)
- GET `/api/v1/patients/{id}` - Get patient details
- POST `/api/v1/patients` - Create patient
- PUT `/api/v1/patients/{id}` - Update patient
- DELETE `/api/v1/patients/{id}` - Delete patient

### Appointments
- GET `/api/v1/appointments` - List appointments
- GET `/api/v1/appointments/{id}` - Get appointment details
- POST `/api/v1/appointments` - Book appointment
- PUT `/api/v1/appointments/{id}` - Update appointment
- DELETE `/api/v1/appointments/{id}` - Cancel appointment
- GET `/api/v1/appointments/doctor/{id}` - Get doctor's appointments
- GET `/api/v1/appointments/patient/{id}` - Get patient's appointments

## Useful Commands

```bash
# View all routes
php artisan route:list

# Clear cache
php artisan cache:clear
php artisan config:clear
php artisan route:clear

# Run migrations
php artisan migrate

# Rollback migrations
php artisan migrate:rollback

# Seed database
php artisan db:seed

# Create migration
php artisan make:migration create_table_name

# Run tests
php artisan test
```

## Environment Variables Reference

```env
# Application
APP_NAME="Doctor Appointment API"
APP_ENV=local
APP_DEBUG=true
APP_URL=http://localhost:8000

# Database
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=doctor_appointment_db
DB_USERNAME=root
DB_PASSWORD=

# Cache
CACHE_STORE=file

# Queue
QUEUE_CONNECTION=database

# Session
SESSION_DRIVER=database
```

## Troubleshooting

### Database Connection Error
- Ensure MySQL is running
- Check database credentials in `.env`
- Verify database exists: `SHOW DATABASES;` in MySQL

### Port Already in Use
```bash
# Use different port
php artisan serve --port=8001
```

### Permission Issues (Linux/Mac)
```bash
chmod -R 775 storage bootstrap/cache
```

## Additional Resources

- [Laravel Documentation](https://laravel.com/docs)
- [Laravel API Resources](https://laravel.com/docs/eloquent-resources)
- [Laravel Sanctum](https://laravel.com/docs/sanctum)
- [RESTful API Best Practices](https://restfulapi.net/)
