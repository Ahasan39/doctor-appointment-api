# Authentication Testing Guide

## 🧪 Quick Testing Guide for Admin Authentication

### Prerequisites
- Server running: `php artisan serve`
- Admin user created (already seeded)

---

## 🔑 Default Admin Credentials

```
Email: admin@doctorappoint.com
Password: admin123
```

---

## 📡 Test Endpoints

### 1. Health Check (No Auth Required)

**Request:**
```bash
curl http://localhost:8000/api/health
```

**Expected Response:**
```json
{
    "status": "success",
    "message": "Doctor Appointment API is running",
    "timestamp": "2025-12-30 12:00:00"
}
```

---

### 2. Admin Login

**Request:**
```bash
curl -X POST http://localhost:8000/api/v1/admin/login \
  -H "Content-Type: application/json" \
  -d '{
    "email": "admin@doctorappoint.com",
    "password": "admin123"
  }'
```

**Expected Response:**
```json
{
    "status": "success",
    "message": "Login successful",
    "data": {
        "user": {
            "id": 1,
            "name": "Admin User",
            "email": "admin@doctorappoint.com",
            "role": "admin",
            "is_active": true
        },
        "token": "1|abc123xyz...",
        "token_type": "Bearer"
    }
}
```

**Save the token for next requests!**

---

### 3. Get Authenticated User

**Request:**
```bash
curl -X GET http://localhost:8000/api/v1/admin/me \
  -H "Authorization: Bearer YOUR_TOKEN_HERE"
```

**Expected Response:**
```json
{
    "status": "success",
    "message": "User retrieved successfully",
    "data": {
        "id": 1,
        "name": "Admin User",
        "email": "admin@doctorappoint.com",
        "role": "admin",
        "phone": "+1234567890",
        "address": null,
        "profile_image": null,
        "is_active": true,
        "created_at": "2025-12-30T12:00:00.000000Z"
    }
}
```

---

### 4. Refresh Token

**Request:**
```bash
curl -X POST http://localhost:8000/api/v1/admin/refresh \
  -H "Authorization: Bearer YOUR_TOKEN_HERE"
```

**Expected Response:**
```json
{
    "status": "success",
    "message": "Token refreshed successfully",
    "data": {
        "token": "2|new_token_here...",
        "token_type": "Bearer"
    }
}
```

---

### 5. Logout

**Request:**
```bash
curl -X POST http://localhost:8000/api/v1/admin/logout \
  -H "Authorization: Bearer YOUR_TOKEN_HERE"
```

**Expected Response:**
```json
{
    "status": "success",
    "message": "Logout successful",
    "data": null
}
```

---

### 6. Logout All Devices

**Request:**
```bash
curl -X POST http://localhost:8000/api/v1/admin/logout-all \
  -H "Authorization: Bearer YOUR_TOKEN_HERE"
```

**Expected Response:**
```json
{
    "status": "success",
    "message": "Logged out from all devices successfully",
    "data": null
}
```

---

## ❌ Error Scenarios

### 1. Invalid Credentials

**Request:**
```bash
curl -X POST http://localhost:8000/api/v1/admin/login \
  -H "Content-Type: application/json" \
  -d '{
    "email": "admin@doctorappoint.com",
    "password": "wrongpassword"
  }'
```

**Expected Response (401):**
```json
{
    "status": "error",
    "message": "Invalid credentials"
}
```

---

### 2. Non-Admin User

**Request:**
```bash
curl -X POST http://localhost:8000/api/v1/admin/login \
  -H "Content-Type: application/json" \
  -d '{
    "email": "doctor@example.com",
    "password": "password"
  }'
```

**Expected Response (403):**
```json
{
    "status": "error",
    "message": "Unauthorized. Admin access only."
}
```

---

### 3. Missing Token

**Request:**
```bash
curl -X GET http://localhost:8000/api/v1/admin/me
```

**Expected Response (401):**
```json
{
    "status": "error",
    "message": "Unauthenticated"
}
```

---

### 4. Invalid Token

**Request:**
```bash
curl -X GET http://localhost:8000/api/v1/admin/me \
  -H "Authorization: Bearer invalid_token"
```

**Expected Response (401):**
```json
{
    "status": "error",
    "message": "Unauthenticated"
}
```

---

### 5. Validation Error

**Request:**
```bash
curl -X POST http://localhost:8000/api/v1/admin/login \
  -H "Content-Type: application/json" \
  -d '{
    "email": "invalid-email",
    "password": "123"
  }'
```

**Expected Response (422):**
```json
{
    "status": "error",
    "message": "Validation failed",
    "errors": {
        "email": ["The email field must be a valid email address."],
        "password": ["The password field must be at least 6 characters."]
    }
}
```

---

## 🔧 Postman Testing

### Setup

1. **Import Collection:**
   - Open Postman
   - Import `postman_collection.json`

2. **Set Environment Variables:**
   - Create new environment
   - Add variable: `base_url` = `http://localhost:8000`
   - Add variable: `admin_token` = (will be set after login)

3. **Login:**
   - Send POST request to `/api/v1/admin/login`
   - Copy token from response
   - Set `admin_token` variable

4. **Test Protected Routes:**
   - Use `{{admin_token}}` in Authorization header
   - All admin routes should work

---

## 🧪 Testing Checklist

### Basic Authentication
- [ ] Health check works
- [ ] Admin can login with correct credentials
- [ ] Login returns token
- [ ] Token is valid format

### Protected Routes
- [ ] Can access `/me` with valid token
- [ ] Can refresh token
- [ ] Can logout
- [ ] Can logout all devices

### Error Handling
- [ ] Invalid credentials return 401
- [ ] Non-admin users return 403
- [ ] Missing token returns 401
- [ ] Invalid token returns 401
- [ ] Validation errors return 422

### Security
- [ ] Passwords are hashed
- [ ] Tokens are unique
- [ ] Old tokens are revoked on logout
- [ ] Admin role is enforced
- [ ] Account status is checked

---

## 📊 Test Results Template

```
Date: ___________
Tester: ___________

✅ Health Check: PASS / FAIL
✅ Admin Login: PASS / FAIL
✅ Get User Info: PASS / FAIL
✅ Refresh Token: PASS / FAIL
✅ Logout: PASS / FAIL
✅ Logout All: PASS / FAIL
✅ Invalid Credentials: PASS / FAIL
✅ Non-Admin Access: PASS / FAIL
✅ Missing Token: PASS / FAIL
✅ Invalid Token: PASS / FAIL
✅ Validation Errors: PASS / FAIL

Notes:
_________________________________
_________________________________
_________________________________
```

---

## 🐛 Troubleshooting

### Issue: "Unauthenticated" on protected routes

**Solution:**
1. Check token is included in header
2. Verify token format: `Bearer {token}`
3. Ensure token hasn't been revoked
4. Check token exists in database

### Issue: "Unauthorized. Admin access only."

**Solution:**
1. Verify user has `admin` role
2. Check user account is active
3. Ensure admin middleware is applied

### Issue: "Invalid credentials"

**Solution:**
1. Verify email is correct
2. Check password is correct
3. Ensure user exists in database
4. Verify password is hashed correctly

---

## 💻 Database Verification

### Check Admin User
```sql
SELECT * FROM users WHERE role = 'admin';
```

### Check Tokens
```sql
SELECT * FROM personal_access_tokens WHERE tokenable_id = 1;
```

### Verify Password Hash
```sql
SELECT email, password FROM users WHERE email = 'admin@doctorappoint.com';
```

---

## 🎯 Quick Test Script

Save as `test-auth.sh`:

```bash
#!/bin/bash

BASE_URL="http://localhost:8000"

echo "Testing Health Check..."
curl -s $BASE_URL/api/health | jq

echo "\nTesting Admin Login..."
RESPONSE=$(curl -s -X POST $BASE_URL/api/v1/admin/login \
  -H "Content-Type: application/json" \
  -d '{
    "email": "admin@doctorappoint.com",
    "password": "admin123"
  }')

echo $RESPONSE | jq

TOKEN=$(echo $RESPONSE | jq -r '.data.token')

echo "\nTesting Get User..."
curl -s -X GET $BASE_URL/api/v1/admin/me \
  -H "Authorization: Bearer $TOKEN" | jq

echo "\nTesting Logout..."
curl -s -X POST $BASE_URL/api/v1/admin/logout \
  -H "Authorization: Bearer $TOKEN" | jq
```

Run with: `bash test-auth.sh`

---

## ✅ Success Criteria

All tests should pass:
- ✅ Login returns valid token
- ✅ Protected routes accessible with token
- ✅ Unauthorized access blocked
- ✅ Proper error messages
- ✅ Token can be refreshed
- ✅ Logout revokes token

---

**Happy Testing! 🚀**
