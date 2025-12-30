# Appointment API Testing Guide

## 🧪 Complete Testing Guide for Admin Appointment Management

### Prerequisites
- Server running: `php artisan serve`
- Admin logged in with token
- Sample appointments seeded

---

## 🔑 Step 1: Get Admin Token

```bash
curl -X POST http://localhost:8000/api/v1/admin/login \
  -H "Content-Type: application/json" \
  -d '{
    "email": "admin@doctorappoint.com",
    "password": "admin123"
  }'
```

**Save the token from response!**

---

## 📋 Step 2: List All Appointments

```bash
curl -X GET http://localhost:8000/api/v1/admin/appointments \
  -H "Authorization: Bearer YOUR_TOKEN"
```

**Expected:** List of all appointments with pagination

---

## 🔍 Step 3: Test Filtering

### Filter by Status (Pending)
```bash
curl -X GET "http://localhost:8000/api/v1/admin/appointments?status=pending" \
  -H "Authorization: Bearer YOUR_TOKEN"
```

### Filter by Status (Confirmed)
```bash
curl -X GET "http://localhost:8000/api/v1/admin/appointments?status=confirmed" \
  -H "Authorization: Bearer YOUR_TOKEN"
```

### Filter by Date Range
```bash
curl -X GET "http://localhost:8000/api/v1/admin/appointments?date_from=2025-01-01&date_to=2025-01-31" \
  -H "Authorization: Bearer YOUR_TOKEN"
```

### Search by Patient Name
```bash
curl -X GET "http://localhost:8000/api/v1/admin/appointments?search=John" \
  -H "Authorization: Bearer YOUR_TOKEN"
```

---

## 📄 Step 4: Test Pagination

### Get First Page (10 items)
```bash
curl -X GET "http://localhost:8000/api/v1/admin/appointments?per_page=10&page=1" \
  -H "Authorization: Bearer YOUR_TOKEN"
```

### Get Second Page
```bash
curl -X GET "http://localhost:8000/api/v1/admin/appointments?per_page=10&page=2" \
  -H "Authorization: Bearer YOUR_TOKEN"
```

---

## 📊 Step 5: Get Statistics

```bash
curl -X GET http://localhost:8000/api/v1/admin/appointments/statistics \
  -H "Authorization: Bearer YOUR_TOKEN"
```

**Expected:** Statistics with counts for each status

---

## 👁️ Step 6: Get Single Appointment

```bash
curl -X GET http://localhost:8000/api/v1/admin/appointments/1 \
  -H "Authorization: Bearer YOUR_TOKEN"
```

**Expected:** Detailed appointment information

---

## ➕ Step 7: Create New Appointment

```bash
curl -X POST http://localhost:8000/api/v1/admin/appointments \
  -H "Authorization: Bearer YOUR_TOKEN" \
  -H "Content-Type: application/json" \
  -d '{
    "name": "Test Patient",
    "phone": "+1234567899",
    "message": "Test appointment",
    "preferred_date": "2025-01-20",
    "preferred_time": "10:00:00",
    "status": "pending"
  }'
```

**Expected:** New appointment created with ID

---

## ✅ Step 8: Approve Appointment

```bash
curl -X POST http://localhost:8000/api/v1/admin/appointments/1/approve \
  -H "Authorization: Bearer YOUR_TOKEN" \
  -H "Content-Type: application/json" \
  -d '{
    "admin_notes": "Approved by admin"
  }'
```

**Expected:** Status changed to "confirmed" with confirmed_at timestamp

---

## ✏️ Step 9: Update Appointment

```bash
curl -X PUT http://localhost:8000/api/v1/admin/appointments/1 \
  -H "Authorization: Bearer YOUR_TOKEN" \
  -H "Content-Type: application/json" \
  -d '{
    "admin_notes": "Updated notes",
    "preferred_time": "11:00:00"
  }'
```

**Expected:** Appointment updated successfully

---

## ✔️ Step 10: Complete Appointment

```bash
curl -X POST http://localhost:8000/api/v1/admin/appointments/2/complete \
  -H "Authorization: Bearer YOUR_TOKEN" \
  -H "Content-Type: application/json" \
  -d '{
    "admin_notes": "Appointment completed successfully"
  }'
```

**Expected:** Status changed to "completed"

---

## ❌ Step 11: Cancel Appointment

```bash
curl -X POST http://localhost:8000/api/v1/admin/appointments/3/cancel \
  -H "Authorization: Bearer YOUR_TOKEN" \
  -H "Content-Type: application/json" \
  -d '{
    "admin_notes": "Cancelled by patient request"
  }'
```

**Expected:** Status changed to "cancelled"

---

## 🚫 Step 12: Reject Appointment

```bash
curl -X POST http://localhost:8000/api/v1/admin/appointments/4/reject \
  -H "Authorization: Bearer YOUR_TOKEN" \
  -H "Content-Type: application/json" \
  -d '{
    "admin_notes": "Doctor not available"
  }'
```

**Expected:** Status changed to "rejected"

---

## 🗑️ Step 13: Delete Appointment

```bash
curl -X DELETE http://localhost:8000/api/v1/admin/appointments/8 \
  -H "Authorization: Bearer YOUR_TOKEN"
```

**Expected:** Appointment deleted successfully

---

## 🔄 Step 14: Test Sorting

### Sort by Date (Ascending)
```bash
curl -X GET "http://localhost:8000/api/v1/admin/appointments?sort_by=preferred_date&sort_order=asc" \
  -H "Authorization: Bearer YOUR_TOKEN"
```

### Sort by Status (Descending)
```bash
curl -X GET "http://localhost:8000/api/v1/admin/appointments?sort_by=status&sort_order=desc" \
  -H "Authorization: Bearer YOUR_TOKEN"
```

---

## 🔗 Step 15: Combined Filters

```bash
curl -X GET "http://localhost:8000/api/v1/admin/appointments?status=pending&per_page=5&sort_by=preferred_date&sort_order=asc" \
  -H "Authorization: Bearer YOUR_TOKEN"
```

**Expected:** Filtered, paginated, and sorted results

---

## ❌ Error Testing

### Test 1: Invalid Status
```bash
curl -X POST http://localhost:8000/api/v1/admin/appointments \
  -H "Authorization: Bearer YOUR_TOKEN" \
  -H "Content-Type: application/json" \
  -d '{
    "name": "Test",
    "phone": "+1234567890",
    "preferred_date": "2025-01-20",
    "status": "invalid_status"
  }'
```

**Expected:** 422 Validation Error

### Test 2: Past Date
```bash
curl -X POST http://localhost:8000/api/v1/admin/appointments \
  -H "Authorization: Bearer YOUR_TOKEN" \
  -H "Content-Type: application/json" \
  -d '{
    "name": "Test",
    "phone": "+1234567890",
    "preferred_date": "2020-01-01"
  }'
```

**Expected:** 422 Validation Error

### Test 3: Missing Required Fields
```bash
curl -X POST http://localhost:8000/api/v1/admin/appointments \
  -H "Authorization: Bearer YOUR_TOKEN" \
  -H "Content-Type: application/json" \
  -d '{
    "message": "Test"
  }'
```

**Expected:** 422 Validation Error

### Test 4: Non-existent Appointment
```bash
curl -X GET http://localhost:8000/api/v1/admin/appointments/9999 \
  -H "Authorization: Bearer YOUR_TOKEN"
```

**Expected:** 404 Not Found

### Test 5: Approve Already Confirmed
```bash
# First approve
curl -X POST http://localhost:8000/api/v1/admin/appointments/1/approve \
  -H "Authorization: Bearer YOUR_TOKEN"

# Try to approve again
curl -X POST http://localhost:8000/api/v1/admin/appointments/1/approve \
  -H "Authorization: Bearer YOUR_TOKEN"
```

**Expected:** 400 Error - Already confirmed

### Test 6: Complete Non-confirmed Appointment
```bash
curl -X POST http://localhost:8000/api/v1/admin/appointments/3/complete \
  -H "Authorization: Bearer YOUR_TOKEN"
```

**Expected:** 400 Error - Only confirmed appointments can be completed

### Test 7: Cancel Completed Appointment
```bash
curl -X POST http://localhost:8000/api/v1/admin/appointments/5/cancel \
  -H "Authorization: Bearer YOUR_TOKEN"
```

**Expected:** 400 Error - Cannot cancel completed appointment

---

## 📊 Testing Checklist

### Basic Operations
- [ ] List all appointments
- [ ] Get single appointment
- [ ] Create appointment
- [ ] Update appointment
- [ ] Delete appointment

### Status Management
- [ ] Approve appointment
- [ ] Cancel appointment
- [ ] Reject appointment
- [ ] Complete appointment

### Filtering
- [ ] Filter by status
- [ ] Filter by doctor
- [ ] Filter by service
- [ ] Filter by date range
- [ ] Search by patient name
- [ ] Search by phone

### Pagination
- [ ] Get first page
- [ ] Get specific page
- [ ] Change items per page
- [ ] Verify pagination metadata

### Sorting
- [ ] Sort by date
- [ ] Sort by status
- [ ] Sort ascending
- [ ] Sort descending

### Statistics
- [ ] Get appointment statistics
- [ ] Verify counts

### Error Handling
- [ ] Invalid status
- [ ] Past date
- [ ] Missing fields
- [ ] Non-existent appointment
- [ ] Duplicate actions
- [ ] Invalid state transitions

### Security
- [ ] Requires authentication
- [ ] Requires admin role
- [ ] Token validation

---

## 🎯 Expected Results Summary

| Test | Expected Status | Expected Message |
|------|----------------|------------------|
| List appointments | 200 | Appointments retrieved successfully |
| Create appointment | 201 | Appointment created successfully |
| Get appointment | 200 | Appointment retrieved successfully |
| Update appointment | 200 | Appointment updated successfully |
| Delete appointment | 200 | Appointment deleted successfully |
| Approve appointment | 200 | Appointment approved successfully |
| Cancel appointment | 200 | Appointment cancelled successfully |
| Reject appointment | 200 | Appointment rejected successfully |
| Complete appointment | 200 | Appointment marked as completed |
| Get statistics | 200 | Statistics retrieved successfully |
| Invalid data | 422 | Validation failed |
| Not found | 404 | Appointment not found |
| Invalid action | 400 | Error message |

---

## 💻 Postman Testing

### Import Collection
1. Open Postman
2. Import `postman_collection_v2.json`
3. Set environment variable `admin_token`

### Test Sequence
1. Login → Save token
2. List appointments
3. Filter by status
4. Create appointment
5. Approve appointment
6. Get statistics
7. Update appointment
8. Complete appointment
9. Cancel appointment
10. Delete appointment

---

## 🐛 Troubleshooting

### Issue: 401 Unauthenticated
**Solution:** Check token is valid and included in header

### Issue: 403 Unauthorized
**Solution:** Ensure user has admin role

### Issue: 422 Validation Error
**Solution:** Check request body matches validation rules

### Issue: 404 Not Found
**Solution:** Verify appointment ID exists

### Issue: 400 Bad Request
**Solution:** Check appointment status allows the action

---

**Happy Testing! 🚀**
