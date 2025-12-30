# 🏥 Doctor Appointment API

A comprehensive REST API backend for a doctor appointment management system built with Laravel 12.

[![Laravel](https://img.shields.io/badge/Laravel-12.x-red.svg)](https://laravel.com)
[![PHP](https://img.shields.io/badge/PHP-8.2+-blue.svg)](https://php.net)
[![MySQL](https://img.shields.io/badge/MySQL-5.7+-orange.svg)](https://mysql.com)
[![License](https://img.shields.io/badge/license-MIT-green.svg)](LICENSE)

---

## 📋 Table of Contents

- [Features](#features)
- [Requirements](#requirements)
- [Installation](#installation)
- [Database Setup](#database-setup)
- [Configuration](#configuration)
- [API Documentation](#api-documentation)
- [Project Structure](#project-structure)
- [Development](#development)
- [Testing](#testing)
- [Contributing](#contributing)
- [License](#license)

---

## ✨ Features

### Core Functionality
- 🔐 **User Management** - Role-based system (Admin, Doctor, Patient)
- 📅 **Appointment Booking** - Complete appointment management system
- ���� **Service Management** - Medical services with pricing and scheduling
- 📝 **Blog System** - Health tips and medical articles
- 🔍 **Advanced Search** - Filter and search across all entities
- 📊 **Dashboard Analytics** - Statistics and reporting

### Technical Features
- ✅ RESTful API architecture
- ✅ JWT/Sanctum authentication ready
- ✅ Eloquent ORM with relationships
- ✅ Database migrations and seeders
- ✅ Request validation
- ✅ API resource transformers
- ✅ Query scopes and filters
- ✅ Comprehensive documentation

---

## 🔧 Requirements

- **PHP** >= 8.2
- **Composer** >= 2.0
- **MySQL** >= 5.7 or **MariaDB** >= 10.3
- **Node.js** >= 18.x (optional, for frontend assets)
- **Git** >= 2.0

---

## 🚀 Installation

### 1. Clone the Repository

```bash
git clone <repository-url>
cd doctor-appointment-api
```

### 2. Install Dependencies

```bash
composer install
```

### 3. Environment Configuration

```bash
# Copy the example environment file
cp .env.example .env

# Generate application key
php artisan key:generate
```

### 4. Configure Database

Edit `.env` file with your database credentials:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=doctor_appointment_db
DB_USERNAME=root
DB_PASSWORD=your_password
```

### 5. Run Migrations

```bash
# Create database first
mysql -u root -p
CREATE DATABASE doctor_appointment_db;
exit;

# Run migrations
php artisan migrate
```

### 6. (Optional) Seed Database

```bash
php artisan db:seed
```

### 7. Start Development Server

```bash
php artisan serve
```

The API will be available at: `http://localhost:8000`

---

## 🗄️ Database Setup

### Database Schema

The application uses the following main tables:

#### **Users Table**
- Supports multiple roles: admin, doctor, patient
- Doctor-specific fields: specialization, license_number, consultation_fee
- Profile management with images

#### **Appointments Table**
- Patient information: name, phone, message
- Scheduling: preferred_date, preferred_time
- Status tracking: pending, confirmed, completed, cancelled, rejected
- Links to doctors and services

#### **Services Table**
- Medical services catalog
- Pricing and duration management
- Active/inactive status
- Display ordering

#### **Blogs Table**
- Health articles and tips
- Author tracking
- Categories and tags
- Publishing workflow
- View counting

### Relationships

```
User (Doctor)
  ├── hasMany → Appointments
  └── hasMany → Blogs

Service
  └── hasMany → Appointments

Appointment
  ├── belongsTo → User (doctor)
  └── belongsTo → Service

Blog
  └── belongsTo → User (author)
```

---

## ⚙️ Configuration

### Environment Variables

Key configuration options in `.env`:

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

# Cache & Session
CACHE_STORE=file
SESSION_DRIVER=database

# Queue
QUEUE_CONNECTION=database
```

### API Configuration

Custom API settings in `config/api.php`:

- API version: v1
- Pagination: 15 items per page
- Appointment slot duration: 30 minutes
- Advance booking: 30 days
- Cancellation notice: 24 hours

---

## 📡 API Documentation

### Base URL

```
http://localhost:8000/api
```

### Health Check

```http
GET /api/health
```

**Response:**
```json
{
    "status": "success",
    "message": "Doctor Appointment API is running",
    "timestamp": "2025-12-30 12:00:00"
}
```

### Authentication Endpoints (To be implemented)

```http
POST   /api/v1/register          # Register new user
POST   /api/v1/login             # User login
POST   /api/v1/logout            # User logout
```

### Appointment Endpoints (To be implemented)

```http
GET    /api/v1/appointments      # List all appointments
POST   /api/v1/appointments      # Create appointment
GET    /api/v1/appointments/{id} # Get appointment details
PUT    /api/v1/appointments/{id} # Update appointment
DELETE /api/v1/appointments/{id} # Cancel appointment
```

### Service Endpoints (To be implemented)

```http
GET    /api/v1/services          # List all services
POST   /api/v1/services          # Create service
GET    /api/v1/services/{id}     # Get service details
PUT    /api/v1/services/{id}     # Update service
DELETE /api/v1/services/{id}     # Delete service
```

### Blog Endpoints (To be implemented)

```http
GET    /api/v1/blogs             # List all blogs
POST   /api/v1/blogs             # Create blog post
GET    /api/v1/blogs/{id}        # Get blog details
PUT    /api/v1/blogs/{id}        # Update blog post
DELETE /api/v1/blogs/{id}        # Delete blog post
```

### Response Format

All API responses follow this structure:

**Success Response:**
```json
{
    "status": "success",
    "message": "Operation successful",
    "data": { }
}
```

**Error Response:**
```json
{
    "status": "error",
    "message": "Error message",
    "errors": { }
}
```

---

## 📁 Project Structure

```
doctor-appointment-api/
├── app/
│   ├── Http/
│   │   └── Controllers/
│   │       └── Api/
│   │           └── ApiController.php
│   └── Models/
│       ├── User.php
│       ├── Appointment.php
│       ├── Service.php
│       └── Blog.php
├── config/
│   └── api.php
├── database/
│   ├── migrations/
│   │   ├── 0001_01_01_000000_create_users_table.php
│   │   ├── 2025_12_30_065013_create_services_table.php
│   │   ├── 2025_12_30_065019_create_blogs_table.php
│   │   └── 2025_12_30_065020_create_appointments_table.php
│   └── seeders/
├── routes/
│   ├── api.php
│   └── web.php
├── storage/
├── tests/
├── .env.example
├── .gitignore
├── composer.json
├── README.md
└── artisan
```

---

## 🛠️ Development

### Useful Commands

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

# Fresh migration (drop all tables and re-run)
php artisan migrate:fresh

# Seed database
php artisan db:seed

# Create new model with migration
php artisan make:model ModelName -m

# Create controller
php artisan make:controller Api/ControllerName --api

# Create request validator
php artisan make:request RequestName

# Create API resource
php artisan make:resource ResourceName

# Run tests
php artisan test
```

### Code Style

This project follows PSR-12 coding standards. Use Laravel Pint for code formatting:

```bash
./vendor/bin/pint
```

---

## 🧪 Testing

### Run Tests

```bash
# Run all tests
php artisan test

# Run specific test file
php artisan test tests/Feature/AppointmentTest.php

# Run with coverage
php artisan test --coverage
```

### Test Structure

```
tests/
├── Feature/
│   ├── AppointmentTest.php
│   ├── ServiceTest.php
│   └── BlogTest.php
└── Unit/
    ├── UserTest.php
    └── ModelTest.php
```

---

## 📚 Additional Documentation

- **[SETUP.md](SETUP.md)** - Detailed setup and configuration guide
- **[SPRINT_1_SUMMARY.md](SPRINT_1_SUMMARY.md)** - Sprint 1 completion summary
- **[DATABASE_SCHEMA.txt](DATABASE_SCHEMA.txt)** - Visual database schema
- **[MODELS_QUICK_REFERENCE.md](MODELS_QUICK_REFERENCE.md)** - Model usage examples
- **[postman_collection.json](postman_collection.json)** - Postman API collection

---

## 🤝 Contributing

Contributions are welcome! Please follow these steps:

1. Fork the repository
2. Create a feature branch (`git checkout -b feature/AmazingFeature`)
3. Commit your changes (`git commit -m 'Add some AmazingFeature'`)
4. Push to the branch (`git push origin feature/AmazingFeature`)
5. Open a Pull Request

### Coding Standards

- Follow PSR-12 coding standards
- Write meaningful commit messages
- Add tests for new features
- Update documentation as needed

---

## 🔒 Security

If you discover any security-related issues, please email security@example.com instead of using the issue tracker.

---

## 📝 License

This project is open-sourced software licensed under the [MIT license](LICENSE).

---

## 👥 Authors

- **Your Name** - *Initial work*

---

## 🙏 Acknowledgments

- Laravel Framework
- Laravel Community
- All Contributors

---

## 📞 Support

For support, email support@example.com or open an issue in the repository.

---

## 🗺️ Roadmap

### Phase 1: Core Features ✅
- [x] Database schema and migrations
- [x] Eloquent models with relationships
- [x] Basic API structure

### Phase 2: API Development (In Progress)
- [ ] Authentication system (Sanctum)
- [ ] Appointment CRUD operations
- [ ] Service management
- [ ] Blog management
- [ ] User management

### Phase 3: Advanced Features
- [ ] Email notifications
- [ ] SMS notifications
- [ ] Payment integration
- [ ] Appointment reminders
- [ ] Doctor availability management
- [ ] Patient medical records

### Phase 4: Admin Panel
- [ ] Dashboard with analytics
- [ ] Appointment management
- [ ] User management
- [ ] Service management
- [ ] Blog management
- [ ] Reports and statistics

### Phase 5: Mobile App Support
- [ ] Mobile-optimized API endpoints
- [ ] Push notifications
- [ ] Real-time updates

---

## 📊 Project Status

**Current Version:** 1.0.0  
**Status:** Active Development  
**Last Updated:** 2025-12-30

---

**Built with ❤️ using Laravel**
