# ✅ Working API Endpoints - Quick Test Guide

**Base URL:** `http://localhost:8000`

---

## 🚨 Important Note

The base URL `http://localhost:8000/api/v1` by itself will return **404 Not Found** because there's no route defined for the root path. You need to access **specific endpoints**.

---

## ✅ Working Endpoints to Test

### 1. Health Check (No /v1 prefix)
```
http://localhost:8000/api/health
```
**Expected:** API status message

---

### 2. Public Services
```
http://localhost:8000/api/v1/services
http://localhost:8000/api/v1/services/featured
http://localhost:8000/api/v1/services/general-consultation
```

---

### 3. Public Doctors
```
http://localhost:8000/api/v1/doctors
http://localhost:8000/api/v1/doctors/featured
http://localhost:8000/api/v1/doctors/specializations
http://localhost:8000/api/v1/doctors/2
```

---

### 4. Public Blogs
```
http://localhost:8000/api/v1/blogs
http://localhost:8000/api/v1/blogs/featured
http://localhost:8000/api/v1/blogs/categories
http://localhost:8000/api/v1/blogs/tags
http://localhost:8000/api/v1/blogs/10-tips-healthy-heart
```

---

### 5. Contact Info
```
http://localhost:8000/api/v1/contact/info
```

---

## 🧪 Quick Browser Tests

### Test 1: Health Check
Open in browser:
```
http://localhost:8000/api/health
```

**Expected Response:**
```json
{
  "status": "success",
  "message": "Doctor Appointment API is running",
  "timestamp": "2026-01-16 14:22:13"
}
```

---

### Test 2: List All Services
Open in browser:
```
http://localhost:8000/api/v1/services
```

**Expected Response:**
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
        "price": 100.00,
        "duration": 30
      }
    ]
  }
}
```

---

### Test 3: List All Doctors
Open in browser:
```
http://localhost:8000/api/v1/doctors
```

**Expected Response:**
```json
{
  "status": "success",
  "message": "Doctors retrieved successfully",
  "data": {
    "data": [
      {
        "id": 2,
        "name": "Dr. Sarah Johnson",
        "specialization": "Cardiology",
        "consultation_fee": 200.00
      }
    ]
  }
}
```

---

### Test 4: List All Blogs
Open in browser:
```
http://localhost:8000/api/v1/blogs
```

**Expected Response:**
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
        "category": "Health Tips"
      }
    ]
  }
}
```

---

### Test 5: Get Contact Info
Open in browser:
```
http://localhost:8000/api/v1/contact/info
```

**Expected Response:**
```json
{
  "status": "success",
  "message": "Contact information retrieved successfully",
  "data": {
    "email": "info@doctorappointment.com",
    "phone": "+1 (555) 123-4567",
    "address": "123 Medical Center Drive..."
  }
}
```

---

## 🔧 PowerShell Testing Commands

### Test Health Check
```powershell
Invoke-RestMethod -Uri "http://localhost:8000/api/health" | ConvertTo-Json
```

### Test Services
```powershell
Invoke-RestMethod -Uri "http://localhost:8000/api/v1/services" | ConvertTo-Json -Depth 5
```

### Test Doctors
```powershell
Invoke-RestMethod -Uri "http://localhost:8000/api/v1/doctors" | ConvertTo-Json -Depth 5
```

### Test Blogs
```powershell
Invoke-RestMethod -Uri "http://localhost:8000/api/v1/blogs" | ConvertTo-Json -Depth 5
```

---

## 📋 All Available Public Endpoints

### Services (3 endpoints)
- `GET /api/v1/services` - List all services
- `GET /api/v1/services/featured` - Featured services
- `GET /api/v1/services/{slug}` - View service details

### Doctors (4 endpoints)
- `GET /api/v1/doctors` - List all doctors
- `GET /api/v1/doctors/featured` - Featured doctors
- `GET /api/v1/doctors/specializations` - List specializations
- `GET /api/v1/doctors/{id}` - View doctor profile

### Blogs (6 endpoints)
- `GET /api/v1/blogs` - List all blogs
- `GET /api/v1/blogs/featured` - Featured blogs
- `GET /api/v1/blogs/categories` - List categories
- `GET /api/v1/blogs/tags` - List tags
- `GET /api/v1/blogs/{slug}` - View blog post
- `GET /api/v1/blogs/{slug}/related` - Related blogs

### Appointments (3 endpoints)
- `GET /api/v1/appointments/available-slots?doctor_id=2&date=2026-01-20` - Check slots
- `POST /api/v1/appointments` - Book appointment
- `POST /api/v1/appointments/check-status` - Check status

### Contact (2 endpoints)
- `GET /api/v1/contact/info` - Get contact info
- `POST /api/v1/contact` - Submit contact form

### Health (1 endpoint)
- `GET /api/health` - Health check

---

## ❌ Common Mistakes

### ❌ Wrong: Accessing base URL
```
http://localhost:8000/api/v1
```
**Result:** 404 Not Found

### ✅ Correct: Access specific endpoint
```
http://localhost:8000/api/v1/services
```
**Result:** List of services

---

## 🎯 Quick Test Checklist

Copy and paste these URLs into your browser:

- [ ] `http://localhost:8000/api/health`
- [ ] `http://localhost:8000/api/v1/services`
- [ ] `http://localhost:8000/api/v1/doctors`
- [ ] `http://localhost:8000/api/v1/blogs`
- [ ] `http://localhost:8000/api/v1/contact/info`

All should return JSON responses with `"status": "success"`

---

## 🔍 Troubleshooting

### If you get 404 errors:

1. **Check server is running:**
   ```powershell
   php artisan serve
   ```

2. **Verify the URL is correct:**
   - ✅ `http://localhost:8000/api/v1/services`
   - ❌ `http://localhost:8000/api/v1`

3. **Check routes are registered:**
   ```powershell
   php artisan route:list --path=api/v1
   ```

4. **Clear cache:**
   ```powershell
   php artisan route:clear
   php artisan cache:clear
   ```

---

## 📱 Testing with Postman

1. Import the collection: `postman_collection_public_apis.json`
2. Set base URL variable: `http://localhost:8000/api`
3. Run the collection

---

## 🎉 Success Indicators

When endpoints are working, you'll see:

```json
{
  "status": "success",
  "message": "...",
  "data": { ... }
}
```

If you see this, your API is working perfectly! ✅

---

**Remember:** Always access specific endpoints, not just the base URL!
