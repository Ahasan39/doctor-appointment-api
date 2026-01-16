@echo off
REM Doctor Appointment API - Public API Testing Script (Windows)
REM This script tests all public endpoints without authentication

setlocal enabledelayedexpansion

set BASE_URL=http://localhost:8000/api/v1
set TOTAL_TESTS=0
set PASSED_TESTS=0

echo ==================================
echo Testing Doctor Appointment API
echo Public Endpoints (No Auth Required)
echo ==================================
echo.

REM Test Health Check
echo ==================================
echo 1. HEALTH CHECK
echo ==================================
curl -s http://localhost:8000/api/health
echo.
echo.

REM Test Services
echo ==================================
echo 2. PUBLIC SERVICES
echo ==================================
echo Test: List All Services
curl -s %BASE_URL%/services
echo.
echo.

echo Test: Featured Services
curl -s %BASE_URL%/services/featured
echo.
echo.

echo Test: View Service by Slug
curl -s %BASE_URL%/services/general-consultation
echo.
echo.

REM Test Doctors
echo ==================================
echo 3. PUBLIC DOCTORS
echo ==================================
echo Test: List All Doctors
curl -s %BASE_URL%/doctors
echo.
echo.

echo Test: Featured Doctors
curl -s %BASE_URL%/doctors/featured
echo.
echo.

echo Test: List Specializations
curl -s %BASE_URL%/doctors/specializations
echo.
echo.

echo Test: View Doctor Profile
curl -s %BASE_URL%/doctors/2
echo.
echo.

REM Test Blogs
echo ==================================
echo 4. PUBLIC BLOGS
echo ==================================
echo Test: List All Blogs
curl -s %BASE_URL%/blogs
echo.
echo.

echo Test: Featured Blogs
curl -s %BASE_URL%/blogs/featured
echo.
echo.

echo Test: List Categories
curl -s %BASE_URL%/blogs/categories
echo.
echo.

echo Test: List Tags
curl -s %BASE_URL%/blogs/tags
echo.
echo.

REM Test Appointments
echo ==================================
echo 5. PUBLIC APPOINTMENTS
echo ==================================
echo Test: Check Available Slots
curl -s "%BASE_URL%/appointments/available-slots?doctor_id=2&date=2025-12-31"
echo.
echo.

echo Test: Book Appointment
curl -s -X POST %BASE_URL%/appointments ^
  -H "Content-Type: application/json" ^
  -d "{\"patient_name\":\"Test Patient\",\"patient_email\":\"test@example.com\",\"patient_phone\":\"+1234567890\",\"doctor_id\":2,\"service_id\":1,\"appointment_date\":\"2025-12-31\",\"appointment_time\":\"14:00\",\"notes\":\"Test appointment\"}"
echo.
echo.

echo Test: Check Appointment Status
curl -s -X POST %BASE_URL%/appointments/check-status ^
  -H "Content-Type: application/json" ^
  -d "{\"patient_email\":\"test@example.com\",\"patient_phone\":\"+1234567890\"}"
echo.
echo.

REM Test Contact
echo ==================================
echo 6. CONTACT FORM
echo ==================================
echo Test: Get Contact Info
curl -s %BASE_URL%/contact/info
echo.
echo.

echo Test: Submit Contact Form
curl -s -X POST %BASE_URL%/contact ^
  -H "Content-Type: application/json" ^
  -d "{\"name\":\"Test User\",\"email\":\"test@example.com\",\"phone\":\"+1234567890\",\"subject\":\"Test Inquiry\",\"message\":\"This is a test message.\"}"
echo.
echo.

echo ==================================
echo TESTING COMPLETE
echo ==================================
echo All public endpoints have been tested.
echo Check the responses above for any errors.
echo.

pause
