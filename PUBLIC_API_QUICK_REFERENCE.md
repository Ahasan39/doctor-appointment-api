# 🌐 Public API Quick Reference

**Base URL:** `http://localhost:8000/api/v1`  
**Authentication:** None required for public endpoints  
**Response Format:** JSON

---

## 📋 Quick Links

- [Services](#-services-3-endpoints)
- [Doctors](#-doctors-4-endpoints)
- [Blogs](#-blogs-6-endpoints)
- [Appointments](#-appointments-3-endpoints)
- [Contact](#-contact-2-endpoints)

---

## 🏥 Services (3 endpoints)

### List Services
```http
GET /services
```
**Query Params:** `search`, `min_price`, `max_price`, `min_duration`, `max_duration`, `sort_by`, `sort_order`, `per_page`

### Featured Services
```http
GET /services/featured
```
Returns top 6 services

### View Service
```http
GET /services/{slug}
```

---

## 👨‍⚕️ Doctors (4 endpoints)

### List Doctors
```http
GET /doctors
```
**Query Params:** `search`, `specialization`, `min_fee`, `max_fee`, `min_experience`, `sort_by`, `sort_order`, `per_page`

### Featured Doctors
```http
GET /doctors/featured
```
Returns top 6 doctors

### Specializations
```http
GET /doctors/specializations
```
Returns unique list of specializations

### View Doctor
```http
GET /doctors/{id}
```

---

## 📝 Blogs (6 endpoints)

### List Blogs
```http
GET /blogs
```
**Query Params:** `search`, `category`, `tag`, `author_id`, `from_date`, `to_date`, `sort_by`, `sort_order`, `per_page`

### Featured Blogs
```http
GET /blogs/featured
```
Returns top 6 blogs

### Categories
```http
GET /blogs/categories
```
Returns unique list of categories

### Tags
```http
GET /blogs/tags
```
Returns unique list of tags

### View Blog
```http
GET /blogs/{slug}
```
Increments view count automatically

### Related Blogs
```http
GET /blogs/{slug}/related
```
Returns up to 3 related blogs

---

## 📅 Appointments (3 endpoints)

### Book Appointment
```http
POST /appointments
Content-Type: application/json

{
  "patient_name": "John Doe",
  "patient_email": "john@email.com",
  "patient_phone": "+1234567890",
  "doctor_id": 2,
  "service_id": 1,
  "appointment_date": "2025-12-31",
  "appointment_time": "14:00",
  "notes": "Optional notes"
}
```

### Available Slots
```http
GET /appointments/available-slots?doctor_id=2&date=2025-12-31
```
Returns time slots from 9 AM to 5 PM (30-min intervals)

### Check Status
```http
POST /appointments/check-status
Content-Type: application/json

{
  "patient_email": "john@email.com",
  "patient_phone": "+1234567890"
}
```

---

## 📧 Contact (2 endpoints)

### Submit Form
```http
POST /contact
Content-Type: application/json

{
  "name": "Jane Smith",
  "email": "jane@email.com",
  "phone": "+1234567890",
  "subject": "Inquiry",
  "message": "Your message here"
}
```

### Contact Info
```http
GET /contact/info
```
Returns contact details, hours, social media

---

## 📊 Response Format

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

## 🔍 Common Query Parameters

| Parameter | Type | Description | Example |
|-----------|------|-------------|---------|
| `search` | string | Search term | `?search=cardiology` |
| `per_page` | integer | Items per page (default varies) | `?per_page=20` |
| `sort_by` | string | Field to sort by | `?sort_by=name` |
| `sort_order` | string | `asc` or `desc` | `?sort_order=desc` |

---

## 🧪 Quick Test Commands

### Test Services
```bash
curl http://localhost:8000/api/v1/services
curl http://localhost:8000/api/v1/services/featured
curl http://localhost:8000/api/v1/services/general-consultation
```

### Test Doctors
```bash
curl http://localhost:8000/api/v1/doctors
curl http://localhost:8000/api/v1/doctors/specializations
curl http://localhost:8000/api/v1/doctors/2
```

### Test Blogs
```bash
curl http://localhost:8000/api/v1/blogs
curl http://localhost:8000/api/v1/blogs/categories
curl http://localhost:8000/api/v1/blogs/10-tips-healthy-heart
```

### Test Appointments
```bash
# Check slots
curl "http://localhost:8000/api/v1/appointments/available-slots?doctor_id=2&date=2025-12-31"

# Book appointment
curl -X POST http://localhost:8000/api/v1/appointments \
  -H "Content-Type: application/json" \
  -d '{"patient_name":"John","patient_email":"john@email.com","patient_phone":"+1234567890","doctor_id":2,"service_id":1,"appointment_date":"2025-12-31","appointment_time":"14:00"}'
```

### Test Contact
```bash
curl -X POST http://localhost:8000/api/v1/contact \
  -H "Content-Type: application/json" \
  -d '{"name":"Jane","email":"jane@email.com","subject":"Test","message":"Hello"}'
```

---

## 🎯 HTTP Status Codes

| Code | Meaning | When Used |
|------|---------|-----------|
| 200 | OK | Successful GET/PUT/DELETE |
| 201 | Created | Successful POST |
| 404 | Not Found | Resource doesn't exist |
| 409 | Conflict | Time slot already booked |
| 422 | Validation Error | Invalid input data |
| 500 | Server Error | Internal server error |

---

## 💡 Tips

1. **Pagination:** Most list endpoints support pagination. Use `per_page` to control results.
2. **Search:** Use the `search` parameter for full-text search across relevant fields.
3. **Filtering:** Combine multiple filters for precise results.
4. **Sorting:** Control order with `sort_by` and `sort_order`.
5. **Slugs:** Services and blogs use slugs (URL-friendly names) instead of IDs.

---

## 🔗 Related Documentation

- **Full API Docs:** `SPRINT_8_PUBLIC_APIS.md`
- **Admin API Docs:** `SPRINT_4_APPOINTMENTS.md`, `SPRINT_5_SERVICES.md`, `SPRINT_6_BLOGS.md`, `SPRINT_7_DOCTORS.md`
- **Authentication:** `SPRINT_3_AUTHENTICATION.md`
- **Setup Guide:** `SETUP.md`
- **Project Status:** `PROJECT_STATUS.md`

---

**Total Public Endpoints:** 21  
**Authentication Required:** No  
**Rate Limiting:** Not yet implemented  
**CORS:** Needs configuration for production
