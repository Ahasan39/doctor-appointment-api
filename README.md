# Doctor Appointment API

A RESTful API backend for a doctor appointment management system built with Laravel 12.

## Features

- **API-Only Architecture**: No Blade views, pure REST API
- **MySQL Database**: Configured for production-ready database
- **Structured Response Format**: Consistent JSON responses
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

### Health Check
- **GET** `/api/health` - Check API status

### Authentication (To be implemented)
- **POST** `/api/v1/register` - Register new user
- **POST** `/api/v1/login` - User login
- **POST** `/api/v1/logout` - User logout (protected)

### Doctors (To be implemented)
- **GET** `/api/v1/doctors` - Get all doctors
- **GET** `/api/v1/doctors/{id}` - Get doctor by ID
- **POST** `/api/v1/doctors` - Create new doctor
- **PUT** `/api/v1/doctors/{id}` - Update doctor
- **DELETE** `/api/v1/doctors/{id}` - Delete doctor

### Patients (To be implemented)
- **GET** `/api/v1/patients` - Get all patients
- **GET** `/api/v1/patients/{id}` - Get patient by ID
- **POST** `/api/v1/patients` - Create new patient
- **PUT** `/api/v1/patients/{id}` - Update patient
- **DELETE** `/api/v1/patients/{id}` - Delete patient

### Appointments (To be implemented)
- **GET** `/api/v1/appointments` - Get all appointments
- **GET** `/api/v1/appointments/{id}` - Get appointment by ID
- **GET** `/api/v1/appointments/doctor/{doctorId}` - Get appointments by doctor
- **GET** `/api/v1/appointments/patient/{patientId}` - Get appointments by patient
- **POST** `/api/v1/appointments` - Create new appointment
- **PUT** `/api/v1/appointments/{id}` - Update appointment
- **DELETE** `/api/v1/appointments/{id}` - Cancel appointment

### Specializations (To be implemented)
- **GET** `/api/v1/specializations` - Get all specializations
- **POST** `/api/v1/specializations` - Create new specialization

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

## Next Steps

1. **Install Laravel Sanctum** for API authentication:
   ```bash
   php artisan install:api
   ```

2. **Create Models and Migrations**:
   - Doctor model
   - Patient model
   - Appointment model
   - Specialization model

3. **Create Controllers**:
   - AuthController
   - DoctorController
   - PatientController
   - AppointmentController
   - SpecializationController

4. **Implement Business Logic**:
   - Service classes
   - Request validation
   - Authorization policies

5. **Add API Documentation**:
   - Consider using Swagger/OpenAPI
   - Or Laravel API Documentation Generator

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
