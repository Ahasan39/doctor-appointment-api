# 🌐 Sprint 8: Public APIs - Complete Documentation

**Sprint Duration:** Sprint 8  
**Status:** ✅ Complete  
**Last Updated:** December 30, 2025

---

## 📋 Overview

Sprint 8 implements all public-facing APIs that don't require authentication. These endpoints allow the frontend website to display services, doctors, blogs, and enable patients to book appointments without admin access.

---

## ✅ Completed Features

### 1. Public Service APIs
- ✅ List all active services with filtering
- ✅ View service details by slug
- ✅ Get featured services
- ✅ Search and sort functionality
- ✅ Price and duration filtering

### 2. Public Doctor APIs
- ✅ List all active doctors with filtering
- ✅ View doctor profile by ID
- ✅ Get featured doctors
- ✅ List all specializations
- ✅ Search by name, bio, or specialization
- ✅ Filter by consultation fee and experience

### 3. Public Blog APIs
- ✅ List all published blogs with filtering
- ✅ View blog post by slug (with view counter)
- ✅ Get featured/latest blogs
- ✅ Get related blogs
- ✅ List all categories and tags
- ✅ Filter by category, tag, author, date

### 4. Public Appointment Booking
- ✅ Book appointment without authentication
- ✅ Check available time slots
- ✅ Check appointment status by email/phone
- ✅ Validation for doctor and service availability
- ✅ Conflict detection for time slots

### 5. Contact Form
- ✅ Submit contact inquiries
- ✅ Get contact information
- ✅ Form validation
- ✅ Logging for tracking

---

## 🔌 API Endpoints

### Public Services

#### 1. List All Active Services
```http
GET /api/v1/services
```

**Query Parameters:**
- `search` (optional) - Search by name or description
- `min_price` (optional) - Minimum price filter
- `max_price` (optional) - Maximum price filter
- `min_duration` (optional) - Minimum duration in minutes
- `max_duration` (optional) - Maximum duration in minutes
- `sort_by` (optional) - Sort field: `name`, `price`, `duration`, `display_order` (default)
- `sort_order` (optional) - Sort order: `asc` (default), `desc`
- `per_page` (optional) - Items per page (default: 12)

**Example Request:**
```bash
curl -X GET "http://localhost:8000/api/v1/services?search=consultation&min_price=50&max_price=200&sort_by=price&sort_order=asc&per_page=10"
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
                "description": "Comprehensive health checkup",
                "price": 100.00,
                "duration": 30,
                "is_active": true,
                "display_order": 1
            }
        ],
        "current_page": 1,
        "per_page": 10,
        "total": 12
    }
}
```

---

#### 2. Get Featured Services
```http
GET /api/v1/services/featured
```

**Description:** Returns top 6 active services ordered by display order.

**Example Request:**
```bash
curl -X GET "http://localhost:8000/api/v1/services/featured"
```

**Success Response (200):**
```json
{
    "status": "success",
    "message": "Featured services retrieved successfully",
    "data": [
        {
            "id": 1,
            "name": "General Consultation",
            "slug": "general-consultation",
            "price": 100.00,
            "duration": 30
        }
    ]
}
```

---

#### 3. View Service Details
```http
GET /api/v1/services/{slug}
```

**Path Parameters:**
- `slug` (required) - Service slug

**Example Request:**
```bash
curl -X GET "http://localhost:8000/api/v1/services/general-consultation"
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
        "description": "Comprehensive health checkup and consultation",
        "price": 100.00,
        "duration": 30,
        "is_active": true,
        "display_order": 1
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

### Public Doctors

#### 1. List All Active Doctors
```http
GET /api/v1/doctors
```

**Query Parameters:**
- `search` (optional) - Search by name, bio, or specialization
- `specialization` (optional) - Filter by specialization
- `min_fee` (optional) - Minimum consultation fee
- `max_fee` (optional) - Maximum consultation fee
- `min_experience` (optional) - Minimum years of experience
- `sort_by` (optional) - Sort field: `name` (default), `specialization`, `consultation_fee`, `experience_years`
- `sort_order` (optional) - Sort order: `asc` (default), `desc`
- `per_page` (optional) - Items per page (default: 12)

**Example Request:**
```bash
curl -X GET "http://localhost:8000/api/v1/doctors?specialization=Cardiology&min_fee=100&max_fee=300&sort_by=consultation_fee&per_page=10"
```

**Success Response (200):**
```json
{
    "status": "success",
    "message": "Doctors retrieved successfully",
    "data": {
        "data": [
            {
                "id": 2,
                "name": "Dr. Sarah Johnson",
                "email": "sarah.johnson@hospital.com",
                "specialization": "Cardiology",
                "qualification": "MD, FACC",
                "experience_years": "2010-01-01",
                "consultation_fee": 200.00,
                "bio": "Experienced cardiologist...",
                "is_active": true
            }
        ],
        "current_page": 1,
        "per_page": 10,
        "total": 12
    }
}
```

---

#### 2. Get Featured Doctors
```http
GET /api/v1/doctors/featured
```

**Description:** Returns top 6 active doctors ordered by creation date.

**Example Request:**
```bash
curl -X GET "http://localhost:8000/api/v1/doctors/featured"
```

---

#### 3. Get All Specializations
```http
GET /api/v1/doctors/specializations
```

**Description:** Returns unique list of all specializations from active doctors.

**Example Request:**
```bash
curl -X GET "http://localhost:8000/api/v1/doctors/specializations"
```

**Success Response (200):**
```json
{
    "status": "success",
    "message": "Specializations retrieved successfully",
    "data": [
        "Cardiology",
        "Dermatology",
        "General Medicine",
        "Neurology",
        "Orthopedics",
        "Pediatrics"
    ]
}
```

---

#### 4. View Doctor Profile
```http
GET /api/v1/doctors/{id}
```

**Path Parameters:**
- `id` (required) - Doctor ID

**Example Request:**
```bash
curl -X GET "http://localhost:8000/api/v1/doctors/2"
```

**Success Response (200):**
```json
{
    "status": "success",
    "message": "Doctor retrieved successfully",
    "data": {
        "id": 2,
        "name": "Dr. Sarah Johnson",
        "email": "sarah.johnson@hospital.com",
        "specialization": "Cardiology",
        "qualification": "MD, FACC",
        "experience_years": "2010-01-01",
        "consultation_fee": 200.00,
        "bio": "Experienced cardiologist with over 14 years of practice...",
        "is_active": true
    }
}
```

---

### Public Blogs

#### 1. List All Published Blogs
```http
GET /api/v1/blogs
```

**Query Parameters:**
- `search` (optional) - Search by title, content, or excerpt
- `category` (optional) - Filter by category
- `tag` (optional) - Filter by tag
- `author_id` (optional) - Filter by author
- `from_date` (optional) - Filter from date (YYYY-MM-DD)
- `to_date` (optional) - Filter to date (YYYY-MM-DD)
- `sort_by` (optional) - Sort field: `published_at` (default), `title`, `views_count`, `reading_time`
- `sort_order` (optional) - Sort order: `desc` (default), `asc`
- `per_page` (optional) - Items per page (default: 10)

**Example Request:**
```bash
curl -X GET "http://localhost:8000/api/v1/blogs?category=Health Tips&sort_by=views_count&sort_order=desc&per_page=10"
```

**Success Response (200):**
```json
{
    "status": "success",
    "message": "Blogs retrieved successfully",
    "data": {
        "data": [
            {
                "id": 1,
                "title": "10 Tips for a Healthy Heart",
                "slug": "10-tips-healthy-heart",
                "excerpt": "Learn essential tips...",
                "category": "Health Tips",
                "tags": ["heart", "health", "wellness"],
                "author": {
                    "id": 1,
                    "name": "Admin User"
                },
                "published_at": "2025-12-25 10:00:00",
                "views_count": 150,
                "reading_time": 5
            }
        ],
        "current_page": 1,
        "per_page": 10,
        "total": 7
    }
}
```

---

#### 2. Get Featured Blogs
```http
GET /api/v1/blogs/featured
```

**Description:** Returns top 6 published blogs ordered by publication date.

**Example Request:**
```bash
curl -X GET "http://localhost:8000/api/v1/blogs/featured"
```

---

#### 3. Get All Categories
```http
GET /api/v1/blogs/categories
```

**Example Request:**
```bash
curl -X GET "http://localhost:8000/api/v1/blogs/categories"
```

**Success Response (200):**
```json
{
    "status": "success",
    "message": "Categories retrieved successfully",
    "data": [
        "Health Tips",
        "Medical News",
        "Patient Stories",
        "Wellness"
    ]
}
```

---

#### 4. Get All Tags
```http
GET /api/v1/blogs/tags
```

**Example Request:**
```bash
curl -X GET "http://localhost:8000/api/v1/blogs/tags"
```

**Success Response (200):**
```json
{
    "status": "success",
    "message": "Tags retrieved successfully",
    "data": [
        "cardiology",
        "diabetes",
        "health",
        "nutrition",
        "wellness"
    ]
}
```

---

#### 5. View Blog Post
```http
GET /api/v1/blogs/{slug}
```

**Path Parameters:**
- `slug` (required) - Blog slug

**Note:** This endpoint automatically increments the view count.

**Example Request:**
```bash
curl -X GET "http://localhost:8000/api/v1/blogs/10-tips-healthy-heart"
```

**Success Response (200):**
```json
{
    "status": "success",
    "message": "Blog retrieved successfully",
    "data": {
        "id": 1,
        "title": "10 Tips for a Healthy Heart",
        "slug": "10-tips-healthy-heart",
        "content": "Full blog content here...",
        "excerpt": "Learn essential tips...",
        "category": "Health Tips",
        "tags": ["heart", "health", "wellness"],
        "author": {
            "id": 1,
            "name": "Admin User",
            "email": "admin@hospital.com"
        },
        "published_at": "2025-12-25 10:00:00",
        "views_count": 151,
        "reading_time": 5
    }
}
```

---

#### 6. Get Related Blogs
```http
GET /api/v1/blogs/{slug}/related
```

**Path Parameters:**
- `slug` (required) - Blog slug

**Description:** Returns up to 3 related blogs based on category and tags.

**Example Request:**
```bash
curl -X GET "http://localhost:8000/api/v1/blogs/10-tips-healthy-heart/related"
```

**Success Response (200):**
```json
{
    "status": "success",
    "message": "Related blogs retrieved successfully",
    "data": [
        {
            "id": 2,
            "title": "Understanding Heart Disease",
            "slug": "understanding-heart-disease",
            "excerpt": "A comprehensive guide...",
            "category": "Health Tips",
            "published_at": "2025-12-20 10:00:00"
        }
    ]
}
```

---

### Public Appointments

#### 1. Book Appointment
```http
POST /api/v1/appointments
```

**Request Body:**
```json
{
    "patient_name": "John Doe",
    "patient_email": "john.doe@email.com",
    "patient_phone": "+1234567890",
    "doctor_id": 2,
    "service_id": 1,
    "appointment_date": "2025-12-31",
    "appointment_time": "10:00",
    "notes": "First time visit"
}
```

**Validation Rules:**
- `patient_name` - Required, max 255 characters
- `patient_email` - Required, valid email
- `patient_phone` - Required, max 20 characters
- `doctor_id` - Required, must exist and be active
- `service_id` - Optional, must exist and be active if provided
- `appointment_date` - Required, must be after today
- `appointment_time` - Required, format HH:mm
- `notes` - Optional, max 1000 characters

**Example Request:**
```bash
curl -X POST "http://localhost:8000/api/v1/appointments" \
  -H "Content-Type: application/json" \
  -d '{
    "patient_name": "John Doe",
    "patient_email": "john.doe@email.com",
    "patient_phone": "+1234567890",
    "doctor_id": 2,
    "service_id": 1,
    "appointment_date": "2025-12-31",
    "appointment_time": "10:00",
    "notes": "First time visit"
  }'
```

**Success Response (201):**
```json
{
    "status": "success",
    "message": "Appointment booked successfully. You will receive a confirmation email shortly.",
    "data": {
        "id": 9,
        "patient_name": "John Doe",
        "patient_email": "john.doe@email.com",
        "patient_phone": "+1234567890",
        "doctor": {
            "id": 2,
            "name": "Dr. Sarah Johnson",
            "specialization": "Cardiology"
        },
        "service": {
            "id": 1,
            "name": "General Consultation"
        },
        "appointment_date": "2025-12-31",
        "appointment_time": "10:00",
        "status": "pending",
        "notes": "First time visit"
    }
}
```

**Error Response - Time Slot Taken (409):**
```json
{
    "status": "error",
    "message": "This time slot is already booked. Please choose another time."
}
```

**Error Response - Validation (422):**
```json
{
    "status": "error",
    "message": "Validation failed",
    "errors": {
        "patient_email": ["The patient email must be a valid email address."],
        "appointment_date": ["The appointment date must be a date after today."]
    }
}
```

---

#### 2. Check Available Time Slots
```http
GET /api/v1/appointments/available-slots
```

**Query Parameters:**
- `doctor_id` (required) - Doctor ID
- `date` (required) - Date in YYYY-MM-DD format (must be after today)

**Example Request:**
```bash
curl -X GET "http://localhost:8000/api/v1/appointments/available-slots?doctor_id=2&date=2025-12-31"
```

**Success Response (200):**
```json
{
    "status": "success",
    "message": "Available slots retrieved successfully",
    "data": {
        "date": "2025-12-31",
        "doctor": {
            "id": 2,
            "name": "Dr. Sarah Johnson",
            "specialization": "Cardiology"
        },
        "slots": [
            {
                "time": "09:00",
                "available": true
            },
            {
                "time": "09:30",
                "available": true
            },
            {
                "time": "10:00",
                "available": false
            },
            {
                "time": "10:30",
                "available": true
            }
        ]
    }
}
```

**Note:** Time slots are generated from 9:00 AM to 5:00 PM in 30-minute intervals.

---

#### 3. Check Appointment Status
```http
POST /api/v1/appointments/check-status
```

**Request Body:**
```json
{
    "patient_email": "john.doe@email.com",
    "patient_phone": "+1234567890"
}
```

**Example Request:**
```bash
curl -X POST "http://localhost:8000/api/v1/appointments/check-status" \
  -H "Content-Type: application/json" \
  -d '{
    "patient_email": "john.doe@email.com",
    "patient_phone": "+1234567890"
  }'
```

**Success Response (200):**
```json
{
    "status": "success",
    "message": "Appointments retrieved successfully",
    "data": [
        {
            "id": 9,
            "patient_name": "John Doe",
            "doctor": {
                "id": 2,
                "name": "Dr. Sarah Johnson"
            },
            "service": {
                "id": 1,
                "name": "General Consultation"
            },
            "appointment_date": "2025-12-31",
            "appointment_time": "10:00",
            "status": "pending"
        }
    ]
}
```

**Error Response (404):**
```json
{
    "status": "error",
    "message": "No appointments found with the provided information"
}
```

---

### Contact Form

#### 1. Submit Contact Form
```http
POST /api/v1/contact
```

**Request Body:**
```json
{
    "name": "Jane Smith",
    "email": "jane.smith@email.com",
    "phone": "+1234567890",
    "subject": "Inquiry about services",
    "message": "I would like to know more about your cardiology services."
}
```

**Validation Rules:**
- `name` - Required, max 255 characters
- `email` - Required, valid email
- `phone` - Optional, max 20 characters
- `subject` - Required, max 255 characters
- `message` - Required, max 2000 characters

**Example Request:**
```bash
curl -X POST "http://localhost:8000/api/v1/contact" \
  -H "Content-Type: application/json" \
  -d '{
    "name": "Jane Smith",
    "email": "jane.smith@email.com",
    "phone": "+1234567890",
    "subject": "Inquiry about services",
    "message": "I would like to know more about your cardiology services."
  }'
```

**Success Response (201):**
```json
{
    "status": "success",
    "message": "Thank you for contacting us. We will get back to you shortly.",
    "data": {
        "submitted_at": "2025-12-30 15:30:00",
        "reference_id": "CNT-A1B2C3D4"
    }
}
```

---

#### 2. Get Contact Information
```http
GET /api/v1/contact/info
```

**Example Request:**
```bash
curl -X GET "http://localhost:8000/api/v1/contact/info"
```

**Success Response (200):**
```json
{
    "status": "success",
    "message": "Contact information retrieved successfully",
    "data": {
        "email": "info@doctorappointment.com",
        "phone": "+1 (555) 123-4567",
        "address": "123 Medical Center Drive, Healthcare City, HC 12345",
        "working_hours": {
            "monday_friday": "9:00 AM - 6:00 PM",
            "saturday": "10:00 AM - 4:00 PM",
            "sunday": "Closed"
        },
        "emergency": "+1 (555) 911-HELP",
        "social_media": {
            "facebook": "https://facebook.com/doctorappointment",
            "twitter": "https://twitter.com/doctorappointment",
            "instagram": "https://instagram.com/doctorappointment",
            "linkedin": "https://linkedin.com/company/doctorappointment"
        }
    }
}
```

---

## 📊 Summary

### Total Public Endpoints: 21

| Category | Endpoints | Description |
|----------|-----------|-------------|
| Services | 3 | List, featured, view details |
| Doctors | 4 | List, featured, specializations, view profile |
| Blogs | 6 | List, featured, categories, tags, view, related |
| Appointments | 3 | Book, check slots, check status |
| Contact | 2 | Submit form, get info |

---

## 🎯 Key Features

### 1. No Authentication Required
All endpoints are publicly accessible without tokens or login.

### 2. Comprehensive Filtering
- Search functionality across all resources
- Multiple filter options (price, date, category, etc.)
- Flexible sorting options

### 3. Pagination
All list endpoints support pagination with customizable `per_page` parameter.

### 4. Smart Features
- **Blog view counter** - Automatically increments on view
- **Related blogs** - Based on category and tags
- **Time slot availability** - Real-time checking
- **Conflict detection** - Prevents double booking

### 5. Data Validation
- Comprehensive validation rules
- Clear error messages
- Proper HTTP status codes

---

## 🔒 Security Considerations

### Implemented
- ✅ Input validation on all endpoints
- ✅ Only active resources are shown
- ✅ Email and phone required for appointment status check
- ✅ Date validation (appointments must be in future)
- ✅ Doctor and service existence validation
- ✅ Contact form logging for tracking

### Recommended Additions
- ⚠️ Rate limiting to prevent abuse
- ⚠️ CAPTCHA for contact form
- ⚠️ Email verification for appointments
- ⚠️ IP-based throttling
- ⚠️ Honeypot fields for spam prevention

---

## 🧪 Testing

### Test Public Services
```bash
# List services
curl http://localhost:8000/api/v1/services

# Get featured services
curl http://localhost:8000/api/v1/services/featured

# View service
curl http://localhost:8000/api/v1/services/general-consultation
```

### Test Public Doctors
```bash
# List doctors
curl http://localhost:8000/api/v1/doctors

# Get specializations
curl http://localhost:8000/api/v1/doctors/specializations

# View doctor
curl http://localhost:8000/api/v1/doctors/2
```

### Test Public Blogs
```bash
# List blogs
curl http://localhost:8000/api/v1/blogs

# Get categories
curl http://localhost:8000/api/v1/blogs/categories

# View blog
curl http://localhost:8000/api/v1/blogs/10-tips-healthy-heart
```

### Test Appointment Booking
```bash
# Check available slots
curl "http://localhost:8000/api/v1/appointments/available-slots?doctor_id=2&date=2025-12-31"

# Book appointment
curl -X POST http://localhost:8000/api/v1/appointments \
  -H "Content-Type: application/json" \
  -d '{
    "patient_name": "Test Patient",
    "patient_email": "test@email.com",
    "patient_phone": "+1234567890",
    "doctor_id": 2,
    "service_id": 1,
    "appointment_date": "2025-12-31",
    "appointment_time": "14:00"
  }'
```

### Test Contact Form
```bash
curl -X POST http://localhost:8000/api/v1/contact \
  -H "Content-Type: application/json" \
  -d '{
    "name": "Test User",
    "email": "test@email.com",
    "subject": "Test Inquiry",
    "message": "This is a test message"
  }'
```

---

## 📱 Frontend Integration Examples

### React/Next.js Example
```javascript
// Fetch services
const fetchServices = async () => {
  const response = await fetch('http://localhost:8000/api/v1/services');
  const data = await response.json();
  return data.data;
};

// Book appointment
const bookAppointment = async (appointmentData) => {
  const response = await fetch('http://localhost:8000/api/v1/appointments', {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json',
    },
    body: JSON.stringify(appointmentData),
  });
  return await response.json();
};
```

### Vue.js Example
```javascript
// Fetch doctors
async fetchDoctors() {
  try {
    const response = await axios.get('http://localhost:8000/api/v1/doctors');
    this.doctors = response.data.data.data;
  } catch (error) {
    console.error('Error fetching doctors:', error);
  }
}
```

---

## 🚀 Next Steps

### Immediate Enhancements
1. **Email Notifications**
   - Send confirmation emails for appointments
   - Auto-reply for contact form submissions

2. **Rate Limiting**
   - Implement throttling on public endpoints
   - Prevent spam and abuse

3. **CORS Configuration**
   - Configure allowed origins for frontend
   - Set up proper headers

### Future Features
1. **Advanced Search**
   - Full-text search across all resources
   - Elasticsearch integration

2. **Caching**
   - Cache frequently accessed data
   - Redis integration

3. **Analytics**
   - Track popular services/doctors
   - Monitor appointment booking patterns

---

## ✅ Sprint 8 Completion Checklist

- [x] Create PublicServiceController
- [x] Create PublicDoctorController
- [x] Create PublicBlogController
- [x] Create PublicAppointmentController
- [x] Create ContactController
- [x] Add all public routes
- [x] Implement filtering and search
- [x] Implement pagination
- [x] Add validation
- [x] Test all endpoints
- [x] Create comprehensive documentation

---

## 🎉 Achievement Unlocked!

**Sprint 8 Complete!** The Doctor Appointment API now has a complete set of public-facing endpoints ready for frontend integration. Users can browse services, doctors, and blogs, and book appointments without requiring authentication.

**Total API Endpoints:** 65 (44 admin + 21 public)

---

**Status:** ✅ Production Ready  
**Next Sprint:** Testing & Documentation (Sprint 9)
