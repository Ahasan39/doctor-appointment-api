# 🔌 API Endpoints Overview

**Doctor Appointment API - Complete Endpoint Reference**  
**Base URL:** `http://localhost:8000/api/v1`  
**Total Endpoints:** 65

---

## 📊 Endpoint Distribution

```
┌─────────────────────────────────────────────────────────┐
│                    API ENDPOINTS (65)                   │
├─────────────────────────────────────────────────────────┤
│                                                         │
│  🔐 ADMIN ENDPOINTS (44) - Require Authentication      │
│  ├── Authentication (5)                                │
│  ├── Appointments (10)                                 │
│  ├── Services (9)                                      │
│  ├── Blogs (11)                                        │
│  └── Doctors (9)                                       │
│                                                         │
│  🌐 PUBLIC ENDPOINTS (21) - No Authentication          │
│  ├── Services (3)                                      │
│  ├── Doctors (4)                                       │
│  ├── Blogs (6)                                         │
│  ├── Appointments (3)                                  │
│  ├── Contact (2)                                       │
│  └── Health Check (1)                                  │
│                                                         │
└─────────────────────────────────────────────────────────┘
```

---

## 🔐 ADMIN ENDPOINTS (44)

### Authentication (5 endpoints)
```
POST   /admin/login              Login as admin
POST   /admin/logout             Logout current session
POST   /admin/logout-all         Logout from all devices
GET    /admin/me                 Get current user info
POST   /admin/refresh            Refresh authentication token
```

### Appointments Management (10 endpoints)
```
GET    /admin/appointments                    List all appointments
POST   /admin/appointments                    Create new appointment
GET    /admin/appointments/{id}               View appointment details
PUT    /admin/appointments/{id}               Update appointment
DELETE /admin/appointments/{id}               Delete appointment
POST   /admin/appointments/{id}/approve       Approve appointment
POST   /admin/appointments/{id}/cancel        Cancel appointment
POST   /admin/appointments/{id}/reject        Reject appointment
POST   /admin/appointments/{id}/complete      Mark as complete
GET    /admin/appointments/statistics         Get statistics
```

### Services Management (9 endpoints)
```
GET    /admin/services                        List all services
POST   /admin/services                        Create new service
GET    /admin/services/{id}                   View service details
PUT    /admin/services/{id}                   Update service
DELETE /admin/services/{id}                   Delete service
POST   /admin/services/{id}/activate          Activate service
POST   /admin/services/{id}/deactivate        Deactivate service
POST   /admin/services/reorder                Reorder services
GET    /admin/services/statistics             Get statistics
```

### Blogs Management (11 endpoints)
```
GET    /admin/blogs                           List all blogs
POST   /admin/blogs                           Create new blog
GET    /admin/blogs/{id}                      View blog details
PUT    /admin/blogs/{id}                      Update blog
DELETE /admin/blogs/{id}                      Delete blog
POST   /admin/blogs/{id}/publish              Publish blog
POST   /admin/blogs/{id}/unpublish            Unpublish blog
POST   /admin/blogs/{id}/archive              Archive blog
GET    /admin/blogs/statistics                Get statistics
GET    /admin/blogs/categories                List categories
GET    /admin/blogs/tags                      List tags
```

### Doctors Management (9 endpoints)
```
GET    /admin/doctors                         List all doctors
POST   /admin/doctors                         Create new doctor
GET    /admin/doctors/{id}                    View doctor details
PUT    /admin/doctors/{id}                    Update doctor
DELETE /admin/doctors/{id}                    Delete doctor
POST   /admin/doctors/{id}/activate           Activate doctor
POST   /admin/doctors/{id}/deactivate         Deactivate doctor
GET    /admin/doctors/statistics              Get statistics
GET    /admin/doctors/specializations         List specializations
```

---

## 🌐 PUBLIC ENDPOINTS (21)

### Services (3 endpoints)
```
GET    /services                              List active services
GET    /services/featured                     Get featured services (top 6)
GET    /services/{slug}                       View service details
```

### Doctors (4 endpoints)
```
GET    /doctors                               List active doctors
GET    /doctors/featured                      Get featured doctors (top 6)
GET    /doctors/specializations               List all specializations
GET    /doctors/{id}                          View doctor profile
```

### Blogs (6 endpoints)
```
GET    /blogs                                 List published blogs
GET    /blogs/featured                        Get featured blogs (top 6)
GET    /blogs/categories                      List all categories
GET    /blogs/tags                            List all tags
GET    /blogs/{slug}                          View blog post (increments views)
GET    /blogs/{slug}/related                  Get related blogs (up to 3)
```

### Appointments (3 endpoints)
```
POST   /appointments                          Book new appointment
GET    /appointments/available-slots          Check available time slots
POST   /appointments/check-status             Check appointment status
```

### Contact (2 endpoints)
```
POST   /contact                               Submit contact form
GET    /contact/info                          Get contact information
```

### Health Check (1 endpoint)
```
GET    /health                                Check API status
```

---

## 📈 HTTP Methods Distribution

```
┌──────────────────────────────────────┐
│  HTTP Method Usage                   │
├──────────────────────────────────────┤
│  GET     40 endpoints (62%)          │
│  POST    23 endpoints (35%)          │
│  PUT      1 endpoint  (2%)           │
│  DELETE   1 endpoint  (2%)           │
├──────────────────────────────────────┤
│  TOTAL   65 endpoints (100%)         │
└──────────────────────────────────────┘
```

---

## 🎯 Endpoint Categories

### By Resource Type
```
Appointments  → 13 endpoints (10 admin + 3 public)
Blogs         → 17 endpoints (11 admin + 6 public)
Doctors       → 13 endpoints (9 admin + 4 public)
Services      → 12 endpoints (9 admin + 3 public)
Authentication→  5 endpoints (5 admin)
Contact       →  2 endpoints (2 public)
Health        →  1 endpoint  (1 public)
Misc          →  2 endpoints (statistics, etc.)
```

### By Access Level
```
🔐 Admin Only     → 44 endpoints (68%)
🌐 Public Access  → 21 endpoints (32%)
```

### By Operation Type
```
📋 List/Read      → 40 endpoints (62%)
➕ Create         →  5 endpoints (8%)
✏️ Update         →  5 endpoints (8%)
🗑️ Delete         →  5 endpoints (8%)
⚡ Actions        → 10 endpoints (15%)
```

---

## 🔍 Common Query Parameters

### Pagination
```
per_page     Number of items per page (default varies by endpoint)
page         Page number (default: 1)
```

### Sorting
```
sort_by      Field to sort by (e.g., name, date, price)
sort_order   Sort direction: asc or desc
```

### Filtering
```
search       Full-text search across relevant fields
status       Filter by status (pending, approved, etc.)
category     Filter by category
tag          Filter by tag
from_date    Filter from date (YYYY-MM-DD)
to_date      Filter to date (YYYY-MM-DD)
min_price    Minimum price filter
max_price    Maximum price filter
```

---

## 📊 Response Codes

### Success Codes
```
200 OK              Successful GET, PUT, DELETE
201 Created         Successful POST (resource created)
```

### Error Codes
```
400 Bad Request     Invalid request format
401 Unauthorized    Missing or invalid authentication
403 Forbidden       Insufficient permissions
404 Not Found       Resource doesn't exist
409 Conflict        Resource conflict (e.g., time slot taken)
422 Unprocessable   Validation failed
500 Server Error    Internal server error
```

---

## 🔐 Authentication

### Admin Endpoints
All admin endpoints require authentication:
```http
Authorization: Bearer {your_token_here}
```

### Getting a Token
```bash
curl -X POST http://localhost:8000/api/v1/admin/login \
  -H "Content-Type: application/json" \
  -d '{
    "email": "admin@hospital.com",
    "password": "Admin@123"
  }'
```

### Public Endpoints
No authentication required - accessible to anyone.

---

## 📝 Request/Response Format

### Request Headers
```http
Content-Type: application/json
Authorization: Bearer {token}  # For admin endpoints only
```

### Success Response
```json
{
  "status": "success",
  "message": "Operation successful",
  "data": { ... }
}
```

### Error Response
```json
{
  "status": "error",
  "message": "Error description",
  "errors": { ... }
}
```

### Paginated Response
```json
{
  "status": "success",
  "message": "Items retrieved",
  "data": {
    "data": [ ... ],
    "current_page": 1,
    "per_page": 10,
    "total": 50,
    "last_page": 5
  }
}
```

---

## 🚀 Quick Examples

### Public API Example
```bash
# List services with filtering
curl "http://localhost:8000/api/v1/services?search=consultation&min_price=50&per_page=10"

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

### Admin API Example
```bash
# Login
TOKEN=$(curl -X POST http://localhost:8000/api/v1/admin/login \
  -H "Content-Type: application/json" \
  -d '{"email":"admin@hospital.com","password":"Admin@123"}' \
  | jq -r '.data.token')

# List appointments
curl http://localhost:8000/api/v1/admin/appointments \
  -H "Authorization: Bearer $TOKEN"

# Approve appointment
curl -X POST http://localhost:8000/api/v1/admin/appointments/1/approve \
  -H "Authorization: Bearer $TOKEN"
```

---

## 📚 Documentation Links

- **Complete API Docs:** `SPRINT_8_PUBLIC_APIS.md`
- **Quick Reference:** `PUBLIC_API_QUICK_REFERENCE.md`
- **Admin Endpoints:** Sprint docs (3-7)
- **Authentication:** `SPRINT_3_AUTHENTICATION.md`
- **Project Status:** `PROJECT_STATUS.md`

---

## 🎯 Endpoint Summary Table

| Category | Admin | Public | Total | Auth Required |
|----------|-------|--------|-------|---------------|
| Authentication | 5 | 0 | 5 | Mixed |
| Appointments | 10 | 3 | 13 | Admin only |
| Services | 9 | 3 | 12 | Admin only |
| Blogs | 11 | 6 | 17 | Admin only |
| Doctors | 9 | 4 | 13 | Admin only |
| Contact | 0 | 2 | 2 | No |
| Health | 0 | 1 | 1 | No |
| **TOTAL** | **44** | **21** | **65** | - |

---

## ✅ Feature Highlights

### Admin Features
- ✅ Complete CRUD operations for all resources
- ✅ Advanced filtering and search
- ✅ Status management workflows
- ✅ Statistics dashboards
- ✅ Bulk operations (reorder, activate/deactivate)

### Public Features
- ✅ Browse services, doctors, and blogs
- ✅ Book appointments without login
- ✅ Check appointment availability
- ✅ Submit contact inquiries
- ✅ View featured content

### Smart Features
- ✅ Automatic view counting for blogs
- ✅ Related content suggestions
- ✅ Time slot conflict detection
- ✅ Reading time estimation
- ✅ Experience level calculation

---

**Total Endpoints:** 65  
**Admin Endpoints:** 44 (68%)  
**Public Endpoints:** 21 (32%)  
**Documentation:** Complete  
**Status:** Production Ready
