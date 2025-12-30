# Sprint 4: Admin Appointment Management - Complete

## ✅ Appointment Management APIs Successfully Implemented!

### 🎯 Goal Achieved
Complete admin control over appointments with listing, approval, cancellation, pagination, and filtering.

---

## 📦 What Was Implemented

### 1. **Appointment Controller**
**File:** `app/Http/Controllers/Api/Admin/AppointmentController.php`

**Methods:**
- `index()` - List appointments with pagination and filtering
- `store()` - Create new appointment
- `show()` - Get appointment details
- `update()` - Update appointment
- `destroy()` - Delete appointment
- `approve()` - Approve/confirm appointment
- `cancel()` - Cancel appointment
- `reject()` - Reject appointment
- `complete()` - Mark appointment as completed
- `statistics()` - Get appointment statistics

### 2. **Request Validation**
**Files:**
- `app/Http/Requests/StoreAppointmentRequest.php`
- `app/Http/Requests/UpdateAppointmentRequest.php`

**Validation Rules:**
- Doctor ID validation
- Service ID validation
- Patient name and phone required
- Date validation (must be today or future)
- Status validation
- Message length limits

### 3. **API Resource**
**File:** `app/Http/Resources/AppointmentResource.php`

**Transforms:**
- Appointment data
- Related doctor information
- Related service information
- Formatted dates and times
- Status information

### 4. **Sample Data Seeder**
**File:** `database/seeders/AppointmentSeeder.php`

**Created:** 8 sample appointments with various statuses

---

## 📡 API Endpoints

### Base URL
```
http://localhost:8000/api/v1/admin/appointments
```

**Authentication Required:** Bearer Token (Admin only)

---

### 1. List Appointments (with Pagination & Filtering)

**Endpoint:** `GET /api/v1/admin/appointments`

**Headers:**
```
Authorization: Bearer {admin_token}
```

**Query Parameters:**
```
per_page        - Items per page (default: 15, max: 100)
status          - Filter by status (pending, confirmed, completed, cancelled, rejected)
doctor_id       - Filter by doctor ID
service_id      - Filter by service ID
date_from       - Filter from date (Y-m-d)
date_to         - Filter to date (Y-m-d)
search          - Search by patient name or phone
sort_by         - Sort field (default: created_at)
sort_order      - Sort order (asc/desc, default: desc)
```

**Example Request:**
```bash
curl -X GET "http://localhost:8000/api/v1/admin/appointments?status=pending&per_page=10" \
  -H "Authorization: Bearer YOUR_TOKEN"
```

**Success Response (200):**
```json
{
    "status": "success",
    "message": "Appointments retrieved successfully",
    "data": {
        "appointments": [
            {
                "id": 1,
                "doctor": {
                    "id": 2,
                    "name": "Dr. John Smith",
                    "specialization": "Cardiology",
                    "email": "dr.smith@example.com",
                    "phone": "+1234567890"
                },
                "service": {
                    "id": 1,
                    "name": "General Consultation",
                    "price": "100.00",
                    "duration": 30
                },
                "patient_name": "John Doe",
                "patient_phone": "+1234567890",
                "message": "Need consultation for chest pain",
                "preferred_date": "2025-01-02",
                "preferred_time": "10:00:00",
                "status": "pending",
                "admin_notes": null,
                "confirmed_at": null,
                "created_at": "2025-12-30 12:00:00",
                "updated_at": "2025-12-30 12:00:00"
            }
        ],
        "pagination": {
            "total": 50,
            "per_page": 10,
            "current_page": 1,
            "last_page": 5,
            "from": 1,
            "to": 10
        }
    }
}
```

---

### 2. Create Appointment

**Endpoint:** `POST /api/v1/admin/appointments`

**Headers:**
```
Authorization: Bearer {admin_token}
Content-Type: application/json
```

**Request Body:**
```json
{
    "doctor_id": 2,
    "service_id": 1,
    "name": "John Doe",
    "phone": "+1234567890",
    "message": "Need consultation for chest pain",
    "preferred_date": "2025-01-15",
    "preferred_time": "10:00:00",
    "status": "pending",
    "admin_notes": "Urgent case"
}
```

**Success Response (201):**
```json
{
    "status": "success",
    "message": "Appointment created successfully",
    "data": {
        "id": 9,
        "doctor": {...},
        "service": {...},
        "patient_name": "John Doe",
        "patient_phone": "+1234567890",
        ...
    }
}
```

---

### 3. Get Appointment Details

**Endpoint:** `GET /api/v1/admin/appointments/{id}`

**Headers:**
```
Authorization: Bearer {admin_token}
```

**Success Response (200):**
```json
{
    "status": "success",
    "message": "Appointment retrieved successfully",
    "data": {
        "id": 1,
        "doctor": {...},
        "service": {...},
        "patient_name": "John Doe",
        ...
    }
}
```

**Error Response (404):**
```json
{
    "status": "error",
    "message": "Appointment not found"
}
```

---

### 4. Update Appointment

**Endpoint:** `PUT /api/v1/admin/appointments/{id}`

**Headers:**
```
Authorization: Bearer {admin_token}
Content-Type: application/json
```

**Request Body:**
```json
{
    "status": "confirmed",
    "admin_notes": "Appointment confirmed with Dr. Smith",
    "preferred_date": "2025-01-16"
}
```

**Success Response (200):**
```json
{
    "status": "success",
    "message": "Appointment updated successfully",
    "data": {
        "id": 1,
        "status": "confirmed",
        "confirmed_at": "2025-12-30 12:30:00",
        ...
    }
}
```

---

### 5. Delete Appointment

**Endpoint:** `DELETE /api/v1/admin/appointments/{id}`

**Headers:**
```
Authorization: Bearer {admin_token}
```

**Success Response (200):**
```json
{
    "status": "success",
    "message": "Appointment deleted successfully",
    "data": null
}
```

---

### 6. Approve Appointment

**Endpoint:** `POST /api/v1/admin/appointments/{id}/approve`

**Headers:**
```
Authorization: Bearer {admin_token}
Content-Type: application/json
```

**Request Body (Optional):**
```json
{
    "admin_notes": "Appointment approved and confirmed"
}
```

**Success Response (200):**
```json
{
    "status": "success",
    "message": "Appointment approved successfully",
    "data": {
        "id": 1,
        "status": "confirmed",
        "confirmed_at": "2025-12-30 12:30:00",
        "admin_notes": "Appointment approved and confirmed",
        ...
    }
}
```

**Error Response (400):**
```json
{
    "status": "error",
    "message": "Appointment is already confirmed"
}
```

---

### 7. Cancel Appointment

**Endpoint:** `POST /api/v1/admin/appointments/{id}/cancel`

**Headers:**
```
Authorization: Bearer {admin_token}
Content-Type: application/json
```

**Request Body (Optional):**
```json
{
    "admin_notes": "Cancelled due to doctor unavailability"
}
```

**Success Response (200):**
```json
{
    "status": "success",
    "message": "Appointment cancelled successfully",
    "data": {
        "id": 1,
        "status": "cancelled",
        "admin_notes": "Cancelled due to doctor unavailability",
        ...
    }
}
```

**Error Responses:**
- `400` - Appointment is already cancelled
- `400` - Cannot cancel a completed appointment

---

### 8. Reject Appointment

**Endpoint:** `POST /api/v1/admin/appointments/{id}/reject`

**Headers:**
```
Authorization: Bearer {admin_token}
Content-Type: application/json
```

**Request Body (Optional):**
```json
{
    "admin_notes": "Doctor not available on requested date"
}
```

**Success Response (200):**
```json
{
    "status": "success",
    "message": "Appointment rejected successfully",
    "data": {
        "id": 1,
        "status": "rejected",
        "admin_notes": "Doctor not available on requested date",
        ...
    }
}
```

---

### 9. Complete Appointment

**Endpoint:** `POST /api/v1/admin/appointments/{id}/complete`

**Headers:**
```
Authorization: Bearer {admin_token}
Content-Type: application/json
```

**Request Body (Optional):**
```json
{
    "admin_notes": "Appointment completed successfully"
}
```

**Success Response (200):**
```json
{
    "status": "success",
    "message": "Appointment marked as completed",
    "data": {
        "id": 1,
        "status": "completed",
        "admin_notes": "Appointment completed successfully",
        ...
    }
}
```

**Error Response (400):**
```json
{
    "status": "error",
    "message": "Only confirmed appointments can be marked as completed"
}
```

---

### 10. Get Statistics

**Endpoint:** `GET /api/v1/admin/appointments/statistics`

**Headers:**
```
Authorization: Bearer {admin_token}
```

**Success Response (200):**
```json
{
    "status": "success",
    "message": "Statistics retrieved successfully",
    "data": {
        "total": 50,
        "pending": 15,
        "confirmed": 20,
        "completed": 10,
        "cancelled": 3,
        "rejected": 2,
        "today": 5,
        "this_week": 12,
        "this_month": 35
    }
}
```

---

## 🔍 Filtering & Pagination

### Filter by Status
```bash
GET /api/v1/admin/appointments?status=pending
GET /api/v1/admin/appointments?status=confirmed
GET /api/v1/admin/appointments?status=completed
```

### Filter by Date Range
```bash
GET /api/v1/admin/appointments?date_from=2025-01-01&date_to=2025-01-31
```

### Filter by Doctor
```bash
GET /api/v1/admin/appointments?doctor_id=2
```

### Search by Patient
```bash
GET /api/v1/admin/appointments?search=John
GET /api/v1/admin/appointments?search=+1234567890
```

### Pagination
```bash
GET /api/v1/admin/appointments?per_page=20&page=2
```

### Sorting
```bash
GET /api/v1/admin/appointments?sort_by=preferred_date&sort_order=asc
GET /api/v1/admin/appointments?sort_by=status&sort_order=desc
```

### Combined Filters
```bash
GET /api/v1/admin/appointments?status=pending&date_from=2025-01-01&per_page=10&sort_by=preferred_date&sort_order=asc
```

---

## 🔒 Security Features

### Authentication
- ✅ Sanctum token required
- ✅ Admin role required
- ✅ Active account required

### Authorization
- ✅ Only admins can access endpoints
- ✅ Middleware enforces admin role
- ✅ Token validation on every request

### Input Validation
- ✅ All inputs validated
- ✅ Date validation (no past dates)
- ✅ Status validation
- ✅ Foreign key validation
- ✅ Custom error messages

### Data Protection
- ✅ Database transactions
- ✅ Rollback on errors
- ✅ Proper error handling

---

## 📊 Status Flow

```
pending → confirmed → completed
   ↓          ↓
rejected   cancelled
```

**Rules:**
- Pending appointments can be: confirmed, rejected, or cancelled
- Confirmed appointments can be: completed or cancelled
- Completed appointments cannot be changed
- Cancelled/Rejected appointments cannot be changed

---

## 🧪 Testing Examples

### 1. Login as Admin
```bash
curl -X POST http://localhost:8000/api/v1/admin/login \
  -H "Content-Type: application/json" \
  -d '{
    "email": "admin@doctorappoint.com",
    "password": "admin123"
  }'
```

### 2. List All Appointments
```bash
curl -X GET http://localhost:8000/api/v1/admin/appointments \
  -H "Authorization: Bearer YOUR_TOKEN"
```

### 3. Filter Pending Appointments
```bash
curl -X GET "http://localhost:8000/api/v1/admin/appointments?status=pending" \
  -H "Authorization: Bearer YOUR_TOKEN"
```

### 4. Approve Appointment
```bash
curl -X POST http://localhost:8000/api/v1/admin/appointments/1/approve \
  -H "Authorization: Bearer YOUR_TOKEN" \
  -H "Content-Type: application/json" \
  -d '{"admin_notes": "Approved by admin"}'
```

### 5. Get Statistics
```bash
curl -X GET http://localhost:8000/api/v1/admin/appointments/statistics \
  -H "Authorization: Bearer YOUR_TOKEN"
```

---

## 📁 Files Created

1. **Controller:**
   - `app/Http/Controllers/Api/Admin/AppointmentController.php`

2. **Requests:**
   - `app/Http/Requests/StoreAppointmentRequest.php`
   - `app/Http/Requests/UpdateAppointmentRequest.php`

3. **Resource:**
   - `app/Http/Resources/AppointmentResource.php`

4. **Seeder:**
   - `database/seeders/AppointmentSeeder.php`

5. **Routes:**
   - Updated `routes/api.php`

---

## 🎯 Features Summary

### CRUD Operations
- ✅ Create appointments
- ✅ Read appointments (list & detail)
- ✅ Update appointments
- ✅ Delete appointments

### Status Management
- ✅ Approve appointments
- ✅ Cancel appointments
- ✅ Reject appointments
- ✅ Complete appointments

### Filtering & Search
- ✅ Filter by status
- ✅ Filter by doctor
- ✅ Filter by service
- ✅ Filter by date range
- ✅ Search by patient name/phone

### Pagination
- ✅ Configurable items per page
- ✅ Page navigation
- ✅ Total count
- ✅ Pagination metadata

### Additional Features
- ✅ Statistics dashboard
- ✅ Sorting options
- ✅ Relationship loading
- ✅ Formatted responses
- ✅ Error handling

---

## 📊 Sample Data

**8 appointments created with various statuses:**
- 3 Pending
- 2 Confirmed
- 1 Completed
- 1 Cancelled
- 1 Rejected

---

## 🚀 Next Steps

### Sprint 5: Service Management
- Create service CRUD endpoints
- Service activation/deactivation
- Service ordering

### Sprint 6: Blog Management
- Create blog CRUD endpoints
- Blog publishing workflow
- Category and tag management

### Sprint 7: Doctor Management
- Create doctor CRUD endpoints
- Doctor activation/deactivation
- Specialization management

---

## 🎉 Sprint 4 Complete!

**Status:** ✅ All objectives achieved

**Deliverables:**
- ✅ Appointment listing with pagination
- ✅ Appointment filtering by status
- ✅ Appointment approval system
- ✅ Appointment cancellation
- ✅ Appointment rejection
- ✅ Appointment completion
- ✅ Statistics dashboard
- ✅ Full CRUD operations
- ✅ Sanctum security
- ✅ Request validation
- ✅ API resources
- ✅ Sample data

**Ready for:** Sprint 5 - Service Management

---

**Created:** 2025-12-30  
**Framework:** Laravel 12  
**Authentication:** Laravel Sanctum  
**Status:** Production Ready
