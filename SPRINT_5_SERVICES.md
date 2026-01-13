# Sprint 5: Service Management - Complete

## ✅ Service Management APIs Successfully Implemented!

### 🎯 Goal Achieved
Complete admin control over services with CRUD operations, activation/deactivation, reordering, filtering, and statistics.

---

## 📦 What Was Implemented

### 1. **Service Controller**
**File:** `app/Http/Controllers/Api/Admin/ServiceController.php`

**Methods:**
- `index()` - List services with pagination and filtering
- `store()` - Create new service
- `show()` - Get service details
- `update()` - Update service
- `destroy()` - Delete service (with protection)
- `activate()` - Activate service
- `deactivate()` - Deactivate service
- `reorder()` - Change display order
- `statistics()` - Get service statistics

### 2. **Request Validation**
**Files:**
- `app/Http/Requests/StoreServiceRequest.php`
- `app/Http/Requests/UpdateServiceRequest.php`

**Validation Rules:**
- Name validation (required, unique)
- Slug validation (unique, auto-generated)
- Description validation
- Price validation (0-999,999.99)
- Duration validation (1-1440 minutes)
- Active status validation
- Order validation

### 3. **API Resource**
**File:** `app/Http/Resources/ServiceResource.php`

**Transforms:**
- Service data
- Formatted price
- Formatted duration (human-readable)
- Appointments count
- Active status
- Display order

### 4. **Sample Data Seeder**
**File:** `database/seeders/ServiceSeeder.php`

**Created:** 12 sample services including:
- General Consultation
- Cardiology Consultation
- Dental Check-up
- Pediatric Care
- Dermatology Consultation
- Orthopedic Consultation
- Eye Examination
- Mental Health Counseling
- Laboratory Tests
- Vaccination Services
- Physical Therapy
- Nutrition Counseling

---

## 📡 API Endpoints

### Base URL
```
http://localhost:8000/api/v1/admin/services
```

**Authentication Required:** Bearer Token (Admin only)

---

### 1. List Services (with Pagination & Filtering)

**Endpoint:** `GET /api/v1/admin/services`

**Headers:**
```
Authorization: Bearer {admin_token}
```

**Query Parameters:**
```
per_page        - Items per page (default: 15, max: 100)
is_active       - Filter by active status (true/false)
search          - Search by name or description
min_price       - Filter by minimum price
max_price       - Filter by maximum price
min_duration    - Filter by minimum duration (minutes)
max_duration    - Filter by maximum duration (minutes)
sort_by         - Sort field (name, price, duration, order, created_at)
sort_order      - Sort order (asc/desc, default: asc)
```

**Example Request:**
```bash
curl -X GET "http://localhost:8000/api/v1/admin/services?is_active=true&per_page=10" \
  -H "Authorization: Bearer YOUR_TOKEN"
```

**Success Response (200):**
```json
{
    "status": "success",
    "message": "Services retrieved successfully",
    "data": {
        "data": [
            {
                "id": 1,
                "name": "General Consultation",
                "slug": "general-consultation",
                "description": "Comprehensive medical consultation...",
                "short_description": "General health check-up and consultation",
                "price": "100.00",
                "price_raw": 100.0,
                "duration": 30,
                "duration_formatted": "30 mins",
                "icon": "fas fa-stethoscope",
                "image": null,
                "is_active": true,
                "order": 1,
                "appointments_count": 5,
                "created_at": "2025-12-30 12:00:00",
                "updated_at": "2025-12-30 12:00:00"
            }
        ],
        "links": {
            "first": "http://localhost:8000/api/v1/admin/services?page=1",
            "last": "http://localhost:8000/api/v1/admin/services?page=2",
            "prev": null,
            "next": "http://localhost:8000/api/v1/admin/services?page=2"
        },
        "meta": {
            "current_page": 1,
            "from": 1,
            "last_page": 2,
            "per_page": 10,
            "to": 10,
            "total": 12
        }
    }
}
```

---

### 2. Create Service

**Endpoint:** `POST /api/v1/admin/services`

**Headers:**
```
Authorization: Bearer {admin_token}
Content-Type: application/json
```

**Request Body:**
```json
{
    "name": "X-Ray Imaging",
    "description": "Digital X-ray imaging services for diagnostic purposes including chest X-rays, bone X-rays, and dental X-rays.",
    "short_description": "Digital X-ray imaging and diagnostics",
    "price": 75.00,
    "duration": 25,
    "icon": "fas fa-x-ray",
    "image": null,
    "is_active": true,
    "order": 13
}
```

**Success Response (201):**
```json
{
    "status": "success",
    "message": "Service created successfully",
    "data": {
        "id": 13,
        "name": "X-Ray Imaging",
        "slug": "x-ray-imaging",
        "description": "Digital X-ray imaging services...",
        "short_description": "Digital X-ray imaging and diagnostics",
        "price": "75.00",
        "price_raw": 75.0,
        "duration": 25,
        "duration_formatted": "25 mins",
        "icon": "fas fa-x-ray",
        "image": null,
        "is_active": true,
        "order": 13,
        "appointments_count": 0,
        "created_at": "2025-12-30 14:30:00",
        "updated_at": "2025-12-30 14:30:00"
    }
}
```

**Validation Errors (422):**
```json
{
    "status": "error",
    "message": "Validation failed",
    "errors": {
        "name": ["Service name is required"],
        "price": ["Price must be a valid number"],
        "duration": ["Duration must be at least 1 minute"]
    }
}
```

---

### 3. Get Service Details

**Endpoint:** `GET /api/v1/admin/services/{id}`

**Headers:**
```
Authorization: Bearer {admin_token}
```

**Success Response (200):**
```json
{
    "status": "success",
    "message": "Service retrieved successfully",
    "data": {
        "id": 1,
        "name": "General Consultation",
        "slug": "general-consultation",
        "description": "Comprehensive medical consultation...",
        "short_description": "General health check-up and consultation",
        "price": "100.00",
        "price_raw": 100.0,
        "duration": 30,
        "duration_formatted": "30 mins",
        "icon": "fas fa-stethoscope",
        "image": null,
        "is_active": true,
        "order": 1,
        "appointments_count": 5,
        "created_at": "2025-12-30 12:00:00",
        "updated_at": "2025-12-30 12:00:00"
    }
}
```

**Error Response (404):**
```json
{
    "status": "error",
    "message": "Service not found"
}
```

---

### 4. Update Service

**Endpoint:** `PUT /api/v1/admin/services/{id}`

**Headers:**
```
Authorization: Bearer {admin_token}
Content-Type: application/json
```

**Request Body (Partial Update):**
```json
{
    "price": 120.00,
    "duration": 35,
    "is_active": true
}
```

**Success Response (200):**
```json
{
    "status": "success",
    "message": "Service updated successfully",
    "data": {
        "id": 1,
        "name": "General Consultation",
        "price": "120.00",
        "duration": 35,
        "duration_formatted": "35 mins",
        "is_active": true,
        ...
    }
}
```

---

### 5. Delete Service

**Endpoint:** `DELETE /api/v1/admin/services/{id}`

**Headers:**
```
Authorization: Bearer {admin_token}
```

**Success Response (200):**
```json
{
    "status": "success",
    "message": "Service deleted successfully",
    "data": null
}
```

**Error Response (400) - Has Appointments:**
```json
{
    "status": "error",
    "message": "Cannot delete service. It has 5 associated appointment(s). Please deactivate instead."
}
```

**Note:** Services with appointments cannot be deleted for data integrity. Deactivate them instead.

---

### 6. Activate Service

**Endpoint:** `POST /api/v1/admin/services/{id}/activate`

**Headers:**
```
Authorization: Bearer {admin_token}
```

**Success Response (200):**
```json
{
    "status": "success",
    "message": "Service activated successfully",
    "data": {
        "id": 1,
        "name": "General Consultation",
        "is_active": true,
        ...
    }
}
```

**Error Response (400):**
```json
{
    "status": "error",
    "message": "Service is already active"
}
```

---

### 7. Deactivate Service

**Endpoint:** `POST /api/v1/admin/services/{id}/deactivate`

**Headers:**
```
Authorization: Bearer {admin_token}
```

**Success Response (200):**
```json
{
    "status": "success",
    "message": "Service deactivated successfully",
    "data": {
        "id": 1,
        "name": "General Consultation",
        "is_active": false,
        ...
    }
}
```

**Error Response (400):**
```json
{
    "status": "error",
    "message": "Service is already inactive"
}
```

---

### 8. Reorder Services

**Endpoint:** `POST /api/v1/admin/services/reorder`

**Headers:**
```
Authorization: Bearer {admin_token}
Content-Type: application/json
```

**Request Body:**
```json
{
    "services": [
        { "id": 1, "order": 5 },
        { "id": 2, "order": 1 },
        { "id": 3, "order": 2 },
        { "id": 4, "order": 3 },
        { "id": 5, "order": 4 }
    ]
}
```

**Success Response (200):**
```json
{
    "status": "success",
    "message": "Services reordered successfully",
    "data": null
}
```

**Validation Error (422):**
```json
{
    "status": "error",
    "message": "Validation failed",
    "errors": {
        "services.0.id": ["The selected id is invalid"],
        "services.1.order": ["The order must be an integer"]
    }
}
```

---

### 9. Get Statistics

**Endpoint:** `GET /api/v1/admin/services/statistics`

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
        "total": 12,
        "active": 11,
        "inactive": 1,
        "total_appointments": 45,
        "average_price": 108.75,
        "average_duration": 36,
        "most_popular": [
            {
                "id": 1,
                "name": "General Consultation",
                "appointments_count": 12
            },
            {
                "id": 2,
                "name": "Cardiology Consultation",
                "appointments_count": 8
            },
            {
                "id": 3,
                "name": "Dental Check-up",
                "appointments_count": 7
            },
            {
                "id": 7,
                "name": "Eye Examination",
                "appointments_count": 6
            },
            {
                "id": 4,
                "name": "Pediatric Care",
                "appointments_count": 5
            }
        ]
    }
}
```

---

## 🔍 Filtering & Search Examples

### Filter by Active Status
```bash
GET /api/v1/admin/services?is_active=true
GET /api/v1/admin/services?is_active=false
```

### Search by Name or Description
```bash
GET /api/v1/admin/services?search=consultation
GET /api/v1/admin/services?search=dental
```

### Filter by Price Range
```bash
GET /api/v1/admin/services?min_price=50&max_price=150
```

### Filter by Duration Range
```bash
GET /api/v1/admin/services?min_duration=30&max_duration=60
```

### Sorting
```bash
GET /api/v1/admin/services?sort_by=price&sort_order=asc
GET /api/v1/admin/services?sort_by=name&sort_order=asc
GET /api/v1/admin/services?sort_by=duration&sort_order=desc
```

### Combined Filters
```bash
GET /api/v1/admin/services?is_active=true&min_price=100&sort_by=price&sort_order=asc&per_page=20
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
- ✅ Unique name validation
- ✅ Price range validation (0-999,999.99)
- ✅ Duration validation (1-1440 minutes)
- ✅ Custom error messages

### Data Protection
- ✅ Database transactions
- ✅ Rollback on errors
- ✅ Proper error handling
- ✅ Prevent deletion of services with appointments

---

## 📊 Service Fields

| Field | Type | Required | Description |
|-------|------|----------|-------------|
| name | string | Yes | Service name (max 255 chars, unique) |
| slug | string | Auto | URL-friendly identifier (auto-generated) |
| description | text | Yes | Full service description |
| short_description | string | No | Brief description (max 500 chars) |
| price | decimal | Yes | Service price (0-999,999.99) |
| duration | integer | Yes | Duration in minutes (1-1440) |
| icon | string | No | Icon class or path |
| image | string | No | Service image path |
| is_active | boolean | No | Active status (default: true) |
| order | integer | No | Display order (default: 0) |

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

### 2. List All Services
```bash
curl -X GET http://localhost:8000/api/v1/admin/services \
  -H "Authorization: Bearer YOUR_TOKEN"
```

### 3. Create New Service
```bash
curl -X POST http://localhost:8000/api/v1/admin/services \
  -H "Authorization: Bearer YOUR_TOKEN" \
  -H "Content-Type: application/json" \
  -d '{
    "name": "Ultrasound Scan",
    "description": "Medical ultrasound imaging for diagnostic purposes",
    "short_description": "Diagnostic ultrasound imaging",
    "price": 150.00,
    "duration": 30,
    "icon": "fas fa-wave-square",
    "is_active": true,
    "order": 13
  }'
```

### 4. Update Service
```bash
curl -X PUT http://localhost:8000/api/v1/admin/services/1 \
  -H "Authorization: Bearer YOUR_TOKEN" \
  -H "Content-Type: application/json" \
  -d '{
    "price": 120.00,
    "duration": 35
  }'
```

### 5. Deactivate Service
```bash
curl -X POST http://localhost:8000/api/v1/admin/services/1/deactivate \
  -H "Authorization: Bearer YOUR_TOKEN"
```

### 6. Get Statistics
```bash
curl -X GET http://localhost:8000/api/v1/admin/services/statistics \
  -H "Authorization: Bearer YOUR_TOKEN"
```

### 7. Reorder Services
```bash
curl -X POST http://localhost:8000/api/v1/admin/services/reorder \
  -H "Authorization: Bearer YOUR_TOKEN" \
  -H "Content-Type: application/json" \
  -d '{
    "services": [
      {"id": 1, "order": 1},
      {"id": 2, "order": 2},
      {"id": 3, "order": 3}
    ]
  }'
```

---

## 📁 Files Created/Modified

### Created Files:
1. **Controller:**
   - `app/Http/Controllers/Api/Admin/ServiceController.php`

2. **Requests:**
   - `app/Http/Requests/StoreServiceRequest.php`
   - `app/Http/Requests/UpdateServiceRequest.php`

3. **Resource:**
   - `app/Http/Resources/ServiceResource.php`

4. **Seeder:**
   - `database/seeders/ServiceSeeder.php`

### Modified Files:
5. **Routes:**
   - `routes/api.php` (added service routes)

---

## 🎯 Features Summary

### CRUD Operations
- ��� Create services
- ✅ Read services (list & detail)
- ✅ Update services
- ✅ Delete services (with protection)

### Status Management
- ✅ Activate services
- ✅ Deactivate services
- ✅ Prevent deletion of services with appointments

### Filtering & Search
- ✅ Filter by active status
- ✅ Filter by price range
- ✅ Filter by duration range
- ✅ Search by name/description

### Pagination & Sorting
- ✅ Configurable items per page
- ✅ Page navigation
- ✅ Sort by multiple fields
- ✅ Pagination metadata

### Additional Features
- ✅ Statistics dashboard
- ✅ Reorder services
- ✅ Appointments count
- ✅ Formatted responses
- ✅ Error handling
- ✅ Auto-generate slug

---

## 📊 Sample Data

**12 services created:**
1. General Consultation - $100 (30 mins)
2. Cardiology Consultation - $200 (45 mins)
3. Dental Check-up - $80 (40 mins)
4. Pediatric Care - $120 (35 mins)
5. Dermatology Consultation - $150 (30 mins)
6. Orthopedic Consultation - $180 (40 mins)
7. Eye Examination - $90 (30 mins)
8. Mental Health Counseling - $130 (60 mins)
9. Laboratory Tests - $60 (15 mins)
10. Vaccination Services - $50 (20 mins)
11. Physical Therapy - $110 (50 mins)
12. Nutrition Counseling - $95 (40 mins)

---

## 🚀 Next Steps

### Sprint 6: Blog Management
- Create blog CRUD endpoints
- Blog publishing workflow
- Category and tag management
- Featured image handling
- View count tracking

### Sprint 7: Doctor Management
- Create doctor CRUD endpoints
- Doctor activation/deactivation
- Specialization management
- Profile management
- Availability scheduling

### Sprint 8: Public APIs
- Public service listing
- Public doctor listing
- Public blog viewing
- Public appointment booking
- Contact form

---

## 🎉 Sprint 5 Complete!

**Status:** ✅ All objectives achieved

**Deliverables:**
- ✅ Service listing with pagination
- ✅ Service filtering and search
- ✅ Service CRUD operations
- ✅ Service activation/deactivation
- ✅ Service reordering
- ✅ Statistics dashboard
- ✅ Sanctum security
- ✅ Request validation
- ✅ API resources
- ✅ Sample data (12 services)
- ✅ Delete protection

**Ready for:** Sprint 6 - Blog Management

---

**Created:** 2025-12-30  
**Framework:** Laravel 12  
**Authentication:** Laravel Sanctum  
**Status:** Production Ready
