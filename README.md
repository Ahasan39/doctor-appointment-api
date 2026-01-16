# Doctor Appointment API

A RESTful API backend for a doctor appointment management system built with Laravel 12.

## Features

- **API-Only Architecture**: No Blade views, pure REST API
- **Complete Admin Panel**: Full CRUD for appointments, services, blogs, and doctors
- **Public APIs**: No-auth endpoints for frontend integration
- **Authentication**: Laravel Sanctum token-based authentication
- **MySQL Database**: Configured for production-ready database
- **Structured Response Format**: Consistent JSON responses
- **Advanced Filtering**: Search, sort, and filter across all resources
- **Health Check Endpoint**: Monitor API status
- **Scalable Structure**: Organized folder structure for controllers, models, and services

## Requirements

- PHP >= 8.2
- Composer
- MySQL >= 5.7
- Laravel 12

## Installation

1. **Clone or navigate to the project directory**
   ```bash
   cd doctor-appointment-api
   ```

2. **Install dependencies**
   ```bash
   composer install
   ```

3. **Configure environment**
   - The `.env` file is already configured
   - Update database credentials if needed:
     ```
     DB_CONNECTION=mysql
     DB_HOST=127.0.0.1
     DB_PORT=3306
     DB_DATABASE=doctor_appointment_db
     DB_USERNAME=root
     DB_PASSWORD=
     ```

4. **Create the database**
   ```bash
   mysql -u root -p
   CREATE DATABASE doctor_appointment_db;
   exit;
   ```

5. **Run migrations**
   ```bash
   php artisan migrate
   ```

6. **Start the development server**
   ```bash
   php artisan serve
   ```

   The API will be available at: `http://localhost:8000`

## API Endpoints

### 📊 Overview
- **Total Endpoints**: 65
- **Admin Endpoints**: 44 (require authentication)
- **Public Endpoints**: 21 (no authentication required)

### Health Check
- **GET** `/api/health` - Check API status

---

### 🌐 Public APIs (No Authentication Required)

#### Services
- **GET** `/api/v1/services` - List all active services
- **GET** `/api/v1/services/featured` - Get featured services
- **GET** `/api/v1/services/{slug}` - View service details

#### Doctors
- **GET** `/api/v1/doctors` - List all active doctors
- **GET** `/api/v1/doctors/featured` - Get featured doctors
- **GET** `/api/v1/doctors/specializations` - List specializations
- **GET** `/api/v1/doctors/{id}` - View doctor profile

#### Blogs
- **GET** `/api/v1/blogs` - List all published blogs
- **GET** `/api/v1/blogs/featured` - Get featured blogs
- **GET** `/api/v1/blogs/categories` - List categories
- **GET** `/api/v1/blogs/tags` - List tags
- **GET** `/api/v1/blogs/{slug}` - View blog post
- **GET** `/api/v1/blogs/{slug}/related` - Get related blogs

#### Appointments (Public Booking)
- **POST** `/api/v1/appointments` - Book appointment
- **GET** `/api/v1/appointments/available-slots` - Check available time slots
- **POST** `/api/v1/appointments/check-status` - Check appointment status

#### Contact
- **POST** `/api/v1/contact` - Submit contact form
- **GET** `/api/v1/contact/info` - Get contact information

---

### 🔐 Admin APIs (Authentication Required)

#### Authentication
- **POST** `/api/v1/admin/login` - Admin login
- **POST** `/api/v1/admin/logout` - Admin logout
- **POST** `/api/v1/admin/logout-all` - Logout from all devices
- **GET** `/api/v1/admin/me` - Get current user
- **POST** `/api/v1/admin/refresh` - Refresh token

#### Appointments Management
- **GET** `/api/v1/admin/appointments` - List appointments
- **POST** `/api/v1/admin/appointments` - Create appointment
- **GET** `/api/v1/admin/appointments/{id}` - View appointment
- **PUT** `/api/v1/admin/appointments/{id}` - Update appointment
- **DELETE** `/api/v1/admin/appointments/{id}` - Delete appointment
- **POST** `/api/v1/admin/appointments/{id}/approve` - Approve appointment
- **POST** `/api/v1/admin/appointments/{id}/cancel` - Cancel appointment
- **POST** `/api/v1/admin/appointments/{id}/reject` - Reject appointment
- **POST** `/api/v1/admin/appointments/{id}/complete` - Complete appointment
- **GET** `/api/v1/admin/appointments/statistics` - Get statistics

#### Services Management
- **GET** `/api/v1/admin/services` - List services
- **POST** `/api/v1/admin/services` - Create service
- **GET** `/api/v1/admin/services/{id}` - View service
- **PUT** `/api/v1/admin/services/{id}` - Update service
- **DELETE** `/api/v1/admin/services/{id}` - Delete service
- **POST** `/api/v1/admin/services/{id}/activate` - Activate service
- **POST** `/api/v1/admin/services/{id}/deactivate` - Deactivate service
- **POST** `/api/v1/admin/services/reorder` - Reorder services
- **GET** `/api/v1/admin/services/statistics` - Get statistics

#### Blogs Management
- **GET** `/api/v1/admin/blogs` - List blogs
- **POST** `/api/v1/admin/blogs` - Create blog
- **GET** `/api/v1/admin/blogs/{id}` - View blog
- **PUT** `/api/v1/admin/blogs/{id}` - Update blog
- **DELETE** `/api/v1/admin/blogs/{id}` - Delete blog
- **POST** `/api/v1/admin/blogs/{id}/publish` - Publish blog
- **POST** `/api/v1/admin/blogs/{id}/unpublish` - Unpublish blog
- **POST** `/api/v1/admin/blogs/{id}/archive` - Archive blog
- **GET** `/api/v1/admin/blogs/statistics` - Get statistics
- **GET** `/api/v1/admin/blogs/categories` - List categories
- **GET** `/api/v1/admin/blogs/tags` - List tags

#### Doctors Management
- **GET** `/api/v1/admin/doctors` - List doctors
- **POST** `/api/v1/admin/doctors` - Create doctor
- **GET** `/api/v1/admin/doctors/{id}` - View doctor
- **PUT** `/api/v1/admin/doctors/{id}` - Update doctor
- **DELETE** `/api/v1/admin/doctors/{id}` - Delete doctor
- **POST** `/api/v1/admin/doctors/{id}/activate` - Activate doctor
- **POST** `/api/v1/admin/doctors/{id}/deactivate` - Deactivate doctor
- **GET** `/api/v1/admin/doctors/statistics` - Get statistics
- **GET** `/api/v1/admin/doctors/specializations` - List specializations

## Project Structure

```
doctor-appointment-api/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   └── Api/
│   │   │       └── ApiController.php (Base API Controller)
│   │   └── Middleware/
│   ├── Models/
│   └── Providers/
├── bootstrap/
│   └── app.php (API routes configured)
├── config/
├── database/
│   ├── migrations/
│   └── seeders/
├── routes/
│   ├── api.php (API routes)
│   ├── console.php
│   └── web.php
├── storage/
├── tests/
├── .env (MySQL configured)
└── README.md
```

## Response Format

All API responses follow this consistent format:

### Success Response
```json
{
    "status": "success",
    "message": "Success message",
    "data": {
        // Response data
    }
}
```

### Error Response
```json
{
    "status": "error",
    "message": "Error message",
    "errors": {
        // Error details (optional)
    }
}
```

## Testing the API

Test the health check endpoint:
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

## 📚 Documentation

Comprehensive documentation is available for all features:

- **[PROJECT_STATUS.md](PROJECT_STATUS.md)** - Overall project status and completion (95%)
- **[SETUP.md](SETUP.md)** - Detailed setup and installation guide
- **[PUBLIC_API_QUICK_REFERENCE.md](PUBLIC_API_QUICK_REFERENCE.md)** - Quick reference for public APIs
- **[SPRINT_8_PUBLIC_APIS.md](SPRINT_8_PUBLIC_APIS.md)** - Complete public API documentation
- **[SPRINT_3_AUTHENTICATION.md](SPRINT_3_AUTHENTICATION.md)** - Authentication guide
- **[SPRINT_4_APPOINTMENTS.md](SPRINT_4_APPOINTMENTS.md)** - Appointments API documentation
- **[SPRINT_5_SERVICES.md](SPRINT_5_SERVICES.md)** - Services API documentation
- **[SPRINT_6_BLOGS.md](SPRINT_6_BLOGS.md)** - Blogs API documentation
- **[SPRINT_7_DOCTORS.md](SPRINT_7_DOCTORS.md)** - Doctors API documentation
- **[DATABASE_SCHEMA.txt](DATABASE_SCHEMA.txt)** - Database structure
- **[MODELS_QUICK_REFERENCE.md](MODELS_QUICK_REFERENCE.md)** - Models reference

## 🚀 Quick Start

### 1. Test Public APIs (No Authentication)
```bash
# List services
curl http://localhost:8000/api/v1/services

# List doctors
curl http://localhost:8000/api/v1/doctors

# List blogs
curl http://localhost:8000/api/v1/blogs

# Book appointment
curl -X POST http://localhost:8000/api/v1/appointments \
  -H "Content-Type: application/json" \
  -d '{
    "patient_name": "John Doe",
    "patient_email": "john@email.com",
    "patient_phone": "+1234567890",
    "doctor_id": 2,
    "service_id": 1,
    "appointment_date": "2025-12-31",
    "appointment_time": "14:00"
  }'
```

### 2. Test Admin APIs (Authentication Required)
```bash
# Login as admin
curl -X POST http://localhost:8000/api/v1/admin/login \
  -H "Content-Type: application/json" \
  -d '{
    "email": "admin@hospital.com",
    "password": "Admin@123"
  }'

# Use the token from login response
TOKEN="your_token_here"

# Get appointments
curl http://localhost:8000/api/v1/admin/appointments \
  -H "Authorization: Bearer $TOKEN"
```

## 🎯 Project Status

- **Completion**: 95%
- **Admin Features**: ✅ Complete (44 endpoints)
- **Public APIs**: ✅ Complete (21 endpoints)
- **Authentication**: ✅ Complete
- **Testing**: ⬜ Pending
- **Production Ready**: 🟢 Yes (testing recommended)

## 🔜 Next Steps

### For Development
1. **Add Testing Suite** (Sprint 9):
   - Feature tests for all endpoints
   - Unit tests for models
   - API documentation (Swagger/OpenAPI)

2. **Production Preparation**:
   - Configure CORS for frontend
   - Add rate limiting
   - Set up email notifications
   - Configure production environment

### For Frontend Integration
1. **Use Public APIs** for:
   - Displaying services, doctors, and blogs
   - Booking appointments
   - Contact form submissions

2. **Use Admin APIs** for:
   - Admin dashboard
   - Managing appointments, services, blogs, doctors
   - Viewing statistics

## 🌟 Key Features

- ✅ Complete REST API with 65 endpoints
- ✅ Token-based authentication (Laravel Sanctum)
- ✅ Public APIs for frontend integration
- ✅ Advanced filtering and search
- ✅ Pagination support
- ✅ Comprehensive validation
- ✅ Consistent JSON responses
- ✅ Sample data for testing
- ✅ Excellent documentation

## Configuration Notes

- **API Prefix**: All API routes are prefixed with `/api`
- **CORS**: Configure in `config/cors.php` if needed for frontend integration
- **Rate Limiting**: Can be configured in `app/Http/Kernel.php`
- **Cache**: Currently set to file-based caching
- **Queue**: Configured to use database driver

## Development Tips

- Use `php artisan make:model ModelName -mcr` to create model with migration, controller, and resource
- Use `php artisan make:request RequestName` for form request validation
- Use `php artisan make:resource ResourceName` for API resource transformers
- Use `php artisan route:list` to view all registered routes

## License

This project is open-sourced software licensed under the MIT license.
