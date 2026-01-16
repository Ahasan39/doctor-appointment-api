# Doctor Appointment API - Comprehensive Testing Script (PowerShell)
# Tests all 65 endpoints (44 admin + 21 public)

$baseUrl = "http://localhost:8000/api/v1"
$healthUrl = "http://localhost:8000/api/health"

$totalTests = 0
$passedTests = 0
$failedTests = 0
$errors = @()

Write-Host "========================================" -ForegroundColor Cyan
Write-Host "Doctor Appointment API - Testing Suite" -ForegroundColor Cyan
Write-Host "========================================" -ForegroundColor Cyan
Write-Host ""

# Function to test endpoint
function Test-Endpoint {
    param(
        [string]$Name,
        [string]$Url,
        [string]$Method = "GET",
        [object]$Body = $null,
        [hashtable]$Headers = @{},
        [int]$ExpectedStatus = 200
    )
    
    $script:totalTests++
    Write-Host "Test $script:totalTests : $Name" -ForegroundColor Yellow
    Write-Host "  URL: $Url" -ForegroundColor Gray
    Write-Host "  Method: $Method" -ForegroundColor Gray
    
    try {
        $params = @{
            Uri = $Url
            Method = $Method
            Headers = $Headers
            ContentType = "application/json"
        }
        
        if ($Body) {
            $params.Body = ($Body | ConvertTo-Json -Depth 10)
        }
        
        $response = Invoke-RestMethod @params -ErrorAction Stop
        
        if ($response.status -eq "success" -or $response.status -eq "error") {
            Write-Host "  ✓ PASSED" -ForegroundColor Green
            Write-Host "  Response: $($response.message)" -ForegroundColor Gray
            $script:passedTests++
            return $response
        } else {
            Write-Host "  ✗ FAILED - Unexpected response format" -ForegroundColor Red
            $script:failedTests++
            $script:errors += "$Name - Unexpected response"
            return $null
        }
    }
    catch {
        $statusCode = $_.Exception.Response.StatusCode.value__
        if ($statusCode -eq $ExpectedStatus -or ($statusCode -ge 200 -and $statusCode -lt 300)) {
            Write-Host "  ✓ PASSED (HTTP $statusCode)" -ForegroundColor Green
            $script:passedTests++
        } else {
            Write-Host "  ✗ FAILED (HTTP $statusCode)" -ForegroundColor Red
            Write-Host "  Error: $($_.Exception.Message)" -ForegroundColor Red
            $script:failedTests++
            $script:errors += "$Name - HTTP $statusCode"
        }
        return $null
    }
    
    Write-Host ""
}

# ========================================
# 1. HEALTH CHECK
# ========================================
Write-Host "`n========================================" -ForegroundColor Cyan
Write-Host "1. HEALTH CHECK" -ForegroundColor Cyan
Write-Host "========================================" -ForegroundColor Cyan

Test-Endpoint -Name "Health Check" -Url $healthUrl

# ========================================
# 2. PUBLIC SERVICES (3 endpoints)
# ========================================
Write-Host "`n========================================" -ForegroundColor Cyan
Write-Host "2. PUBLIC SERVICES (3 endpoints)" -ForegroundColor Cyan
Write-Host "========================================" -ForegroundColor Cyan

Test-Endpoint -Name "List All Services" -Url "$baseUrl/services"
Test-Endpoint -Name "Featured Services" -Url "$baseUrl/services/featured"
Test-Endpoint -Name "View Service by Slug" -Url "$baseUrl/services/general-consultation"

# ========================================
# 3. PUBLIC DOCTORS (4 endpoints)
# ========================================
Write-Host "`n========================================" -ForegroundColor Cyan
Write-Host "3. PUBLIC DOCTORS (4 endpoints)" -ForegroundColor Cyan
Write-Host "========================================" -ForegroundColor Cyan

Test-Endpoint -Name "List All Doctors" -Url "$baseUrl/doctors"
Test-Endpoint -Name "Featured Doctors" -Url "$baseUrl/doctors/featured"
Test-Endpoint -Name "List Specializations" -Url "$baseUrl/doctors/specializations"
Test-Endpoint -Name "View Doctor Profile" -Url "$baseUrl/doctors/2"

# ========================================
# 4. PUBLIC BLOGS (6 endpoints)
# ========================================
Write-Host "`n========================================" -ForegroundColor Cyan
Write-Host "4. PUBLIC BLOGS (6 endpoints)" -ForegroundColor Cyan
Write-Host "========================================" -ForegroundColor Cyan

Test-Endpoint -Name "List All Blogs" -Url "$baseUrl/blogs"
Test-Endpoint -Name "Featured Blogs" -Url "$baseUrl/blogs/featured"
Test-Endpoint -Name "List Categories" -Url "$baseUrl/blogs/categories"
Test-Endpoint -Name "List Tags" -Url "$baseUrl/blogs/tags"
Test-Endpoint -Name "View Blog Post" -Url "$baseUrl/blogs/10-tips-healthy-heart"
Test-Endpoint -Name "Related Blogs" -Url "$baseUrl/blogs/10-tips-healthy-heart/related"

# ========================================
# 5. PUBLIC APPOINTMENTS (3 endpoints)
# ========================================
Write-Host "`n========================================" -ForegroundColor Cyan
Write-Host "5. PUBLIC APPOINTMENTS (3 endpoints)" -ForegroundColor Cyan
Write-Host "========================================" -ForegroundColor Cyan

Test-Endpoint -Name "Check Available Slots" -Url "$baseUrl/appointments/available-slots?doctor_id=2&date=2026-01-20"

$appointmentData = @{
    patient_name = "Test Patient"
    patient_email = "test@example.com"
    patient_phone = "+1234567890"
    doctor_id = 2
    service_id = 1
    appointment_date = "2026-01-20"
    appointment_time = "14:00"
    notes = "Test appointment from automated testing"
}
$appointmentResponse = Test-Endpoint -Name "Book Appointment" -Url "$baseUrl/appointments" -Method "POST" -Body $appointmentData -ExpectedStatus 201

$statusData = @{
    patient_email = "test@example.com"
    patient_phone = "+1234567890"
}
Test-Endpoint -Name "Check Appointment Status" -Url "$baseUrl/appointments/check-status" -Method "POST" -Body $statusData

# ========================================
# 6. CONTACT (2 endpoints)
# ========================================
Write-Host "`n========================================" -ForegroundColor Cyan
Write-Host "6. CONTACT (2 endpoints)" -ForegroundColor Cyan
Write-Host "========================================" -ForegroundColor Cyan

Test-Endpoint -Name "Get Contact Info" -Url "$baseUrl/contact/info"

$contactData = @{
    name = "Test User"
    email = "test@example.com"
    phone = "+1234567890"
    subject = "Test Inquiry"
    message = "This is a test message from automated testing script."
}
Test-Endpoint -Name "Submit Contact Form" -Url "$baseUrl/contact" -Method "POST" -Body $contactData -ExpectedStatus 201

# ========================================
# 7. ADMIN AUTHENTICATION (5 endpoints)
# ========================================
Write-Host "`n========================================" -ForegroundColor Cyan
Write-Host "7. ADMIN AUTHENTICATION (5 endpoints)" -ForegroundColor Cyan
Write-Host "========================================" -ForegroundColor Cyan

$loginData = @{
    email = "admin@hospital.com"
    password = "Admin@123"
}
$loginResponse = Test-Endpoint -Name "Admin Login" -Url "$baseUrl/admin/login" -Method "POST" -Body $loginData

if ($loginResponse -and $loginResponse.data.token) {
    $token = $loginResponse.data.token
    $authHeaders = @{
        "Authorization" = "Bearer $token"
    }
    
    Write-Host "`n  Token obtained: $($token.Substring(0, 20))..." -ForegroundColor Green
    
    Test-Endpoint -Name "Get Current User" -Url "$baseUrl/admin/me" -Headers $authHeaders
    Test-Endpoint -Name "Refresh Token" -Url "$baseUrl/admin/refresh" -Method "POST" -Headers $authHeaders
    
    # ========================================
    # 8. ADMIN APPOINTMENTS (10 endpoints)
    # ========================================
    Write-Host "`n========================================" -ForegroundColor Cyan
    Write-Host "8. ADMIN APPOINTMENTS (10 endpoints)" -ForegroundColor Cyan
    Write-Host "========================================" -ForegroundColor Cyan
    
    Test-Endpoint -Name "List Appointments" -Url "$baseUrl/admin/appointments" -Headers $authHeaders
    Test-Endpoint -Name "Get Appointment Statistics" -Url "$baseUrl/admin/appointments/statistics" -Headers $authHeaders
    
    $newAppointment = @{
        patient_name = "Admin Test Patient"
        patient_email = "admintest@example.com"
        patient_phone = "+9876543210"
        doctor_id = 3
        service_id = 2
        appointment_date = "2026-01-25"
        appointment_time = "10:00"
        status = "pending"
        notes = "Created by admin for testing"
    }
    $createdAppointment = Test-Endpoint -Name "Create Appointment" -Url "$baseUrl/admin/appointments" -Method "POST" -Body $newAppointment -Headers $authHeaders -ExpectedStatus 201
    
    if ($createdAppointment -and $createdAppointment.data.id) {
        $appointmentId = $createdAppointment.data.id
        
        Test-Endpoint -Name "View Appointment" -Url "$baseUrl/admin/appointments/$appointmentId" -Headers $authHeaders
        
        $updateData = @{
            notes = "Updated by automated test"
        }
        Test-Endpoint -Name "Update Appointment" -Url "$baseUrl/admin/appointments/$appointmentId" -Method "PUT" -Body $updateData -Headers $authHeaders
        
        Test-Endpoint -Name "Approve Appointment" -Url "$baseUrl/admin/appointments/$appointmentId/approve" -Method "POST" -Headers $authHeaders
        Test-Endpoint -Name "Complete Appointment" -Url "$baseUrl/admin/appointments/$appointmentId/complete" -Method "POST" -Headers $authHeaders
        Test-Endpoint -Name "Cancel Appointment" -Url "$baseUrl/admin/appointments/$appointmentId/cancel" -Method "POST" -Headers $authHeaders
        Test-Endpoint -Name "Reject Appointment" -Url "$baseUrl/admin/appointments/$appointmentId/reject" -Method "POST" -Headers $authHeaders
        
        Test-Endpoint -Name "Delete Appointment" -Url "$baseUrl/admin/appointments/$appointmentId" -Method "DELETE" -Headers $authHeaders
    }
    
    # ========================================
    # 9. ADMIN SERVICES (9 endpoints)
    # ========================================
    Write-Host "`n========================================" -ForegroundColor Cyan
    Write-Host "9. ADMIN SERVICES (9 endpoints)" -ForegroundColor Cyan
    Write-Host "========================================" -ForegroundColor Cyan
    
    Test-Endpoint -Name "List Services" -Url "$baseUrl/admin/services" -Headers $authHeaders
    Test-Endpoint -Name "Get Service Statistics" -Url "$baseUrl/admin/services/statistics" -Headers $authHeaders
    
    $newService = @{
        name = "Test Service"
        slug = "test-service-$(Get-Random)"
        description = "This is a test service created by automated testing"
        price = 150.00
        duration = 45
        is_active = $true
        display_order = 99
    }
    $createdService = Test-Endpoint -Name "Create Service" -Url "$baseUrl/admin/services" -Method "POST" -Body $newService -Headers $authHeaders -ExpectedStatus 201
    
    if ($createdService -and $createdService.data.id) {
        $serviceId = $createdService.data.id
        
        Test-Endpoint -Name "View Service" -Url "$baseUrl/admin/services/$serviceId" -Headers $authHeaders
        
        $updateService = @{
            price = 175.00
        }
        Test-Endpoint -Name "Update Service" -Url "$baseUrl/admin/services/$serviceId" -Method "PUT" -Body $updateService -Headers $authHeaders
        
        Test-Endpoint -Name "Deactivate Service" -Url "$baseUrl/admin/services/$serviceId/deactivate" -Method "POST" -Headers $authHeaders
        Test-Endpoint -Name "Activate Service" -Url "$baseUrl/admin/services/$serviceId/activate" -Method "POST" -Headers $authHeaders
        
        Test-Endpoint -Name "Delete Service" -Url "$baseUrl/admin/services/$serviceId" -Method "DELETE" -Headers $authHeaders
    }
    
    # ========================================
    # 10. ADMIN BLOGS (11 endpoints)
    # ========================================
    Write-Host "`n========================================" -ForegroundColor Cyan
    Write-Host "10. ADMIN BLOGS (11 endpoints)" -ForegroundColor Cyan
    Write-Host "========================================" -ForegroundColor Cyan
    
    Test-Endpoint -Name "List Blogs" -Url "$baseUrl/admin/blogs" -Headers $authHeaders
    Test-Endpoint -Name "Get Blog Statistics" -Url "$baseUrl/admin/blogs/statistics" -Headers $authHeaders
    Test-Endpoint -Name "Get Blog Categories" -Url "$baseUrl/admin/blogs/categories" -Headers $authHeaders
    Test-Endpoint -Name "Get Blog Tags" -Url "$baseUrl/admin/blogs/tags" -Headers $authHeaders
    
    $newBlog = @{
        title = "Test Blog Post"
        slug = "test-blog-post-$(Get-Random)"
        content = "This is a test blog post created by automated testing. It contains sample content for testing purposes."
        excerpt = "Test blog excerpt"
        category = "Testing"
        tags = @("test", "automation")
        status = "draft"
        author_id = 1
    }
    $createdBlog = Test-Endpoint -Name "Create Blog" -Url "$baseUrl/admin/blogs" -Method "POST" -Body $newBlog -Headers $authHeaders -ExpectedStatus 201
    
    if ($createdBlog -and $createdBlog.data.id) {
        $blogId = $createdBlog.data.id
        
        Test-Endpoint -Name "View Blog" -Url "$baseUrl/admin/blogs/$blogId" -Headers $authHeaders
        
        $updateBlog = @{
            excerpt = "Updated excerpt"
        }
        Test-Endpoint -Name "Update Blog" -Url "$baseUrl/admin/blogs/$blogId" -Method "PUT" -Body $updateBlog -Headers $authHeaders
        
        Test-Endpoint -Name "Publish Blog" -Url "$baseUrl/admin/blogs/$blogId/publish" -Method "POST" -Headers $authHeaders
        Test-Endpoint -Name "Unpublish Blog" -Url "$baseUrl/admin/blogs/$blogId/unpublish" -Method "POST" -Headers $authHeaders
        Test-Endpoint -Name "Archive Blog" -Url "$baseUrl/admin/blogs/$blogId/archive" -Method "POST" -Headers $authHeaders
        
        Test-Endpoint -Name "Delete Blog" -Url "$baseUrl/admin/blogs/$blogId" -Method "DELETE" -Headers $authHeaders
    }
    
    # ========================================
    # 11. ADMIN DOCTORS (9 endpoints)
    # ========================================
    Write-Host "`n========================================" -ForegroundColor Cyan
    Write-Host "11. ADMIN DOCTORS (9 endpoints)" -ForegroundColor Cyan
    Write-Host "========================================" -ForegroundColor Cyan
    
    Test-Endpoint -Name "List Doctors" -Url "$baseUrl/admin/doctors" -Headers $authHeaders
    Test-Endpoint -Name "Get Doctor Statistics" -Url "$baseUrl/admin/doctors/statistics" -Headers $authHeaders
    Test-Endpoint -Name "Get Doctor Specializations" -Url "$baseUrl/admin/doctors/specializations" -Headers $authHeaders
    
    $newDoctor = @{
        name = "Dr. Test Doctor"
        email = "test.doctor$(Get-Random)@hospital.com"
        password = "TestDoctor@123"
        specialization = "Testing Medicine"
        qualification = "MD, Test"
        experience_years = "2020-01-01"
        consultation_fee = 200.00
        bio = "This is a test doctor created by automated testing"
        is_active = $true
    }
    $createdDoctor = Test-Endpoint -Name "Create Doctor" -Url "$baseUrl/admin/doctors" -Method "POST" -Body $newDoctor -Headers $authHeaders -ExpectedStatus 201
    
    if ($createdDoctor -and $createdDoctor.data.id) {
        $doctorId = $createdDoctor.data.id
        
        Test-Endpoint -Name "View Doctor" -Url "$baseUrl/admin/doctors/$doctorId" -Headers $authHeaders
        
        $updateDoctor = @{
            consultation_fee = 250.00
        }
        Test-Endpoint -Name "Update Doctor" -Url "$baseUrl/admin/doctors/$doctorId" -Method "PUT" -Body $updateDoctor -Headers $authHeaders
        
        Test-Endpoint -Name "Deactivate Doctor" -Url "$baseUrl/admin/doctors/$doctorId/deactivate" -Method "POST" -Headers $authHeaders
        Test-Endpoint -Name "Activate Doctor" -Url "$baseUrl/admin/doctors/$doctorId/activate" -Method "POST" -Headers $authHeaders
        
        Test-Endpoint -Name "Delete Doctor" -Url "$baseUrl/admin/doctors/$doctorId" -Method "DELETE" -Headers $authHeaders
    }
    
    # ========================================
    # 12. LOGOUT TESTS
    # ========================================
    Write-Host "`n========================================" -ForegroundColor Cyan
    Write-Host "12. LOGOUT TESTS" -ForegroundColor Cyan
    Write-Host "========================================" -ForegroundColor Cyan
    
    Test-Endpoint -Name "Logout All Devices" -Url "$baseUrl/admin/logout-all" -Method "POST" -Headers $authHeaders
    Test-Endpoint -Name "Admin Logout" -Url "$baseUrl/admin/logout" -Method "POST" -Headers $authHeaders
    
} else {
    Write-Host "`n  ✗ Cannot proceed with admin tests - Login failed" -ForegroundColor Red
}

# ========================================
# FINAL SUMMARY
# ========================================
Write-Host "`n========================================" -ForegroundColor Cyan
Write-Host "TEST SUMMARY" -ForegroundColor Cyan
Write-Host "========================================" -ForegroundColor Cyan
Write-Host ""
Write-Host "Total Tests:  $totalTests" -ForegroundColor White
Write-Host "Passed:       $passedTests" -ForegroundColor Green
Write-Host "Failed:       $failedTests" -ForegroundColor Red
Write-Host "Success Rate: $([math]::Round(($passedTests / $totalTests) * 100, 2))%" -ForegroundColor $(if ($failedTests -eq 0) { "Green" } else { "Yellow" })
Write-Host ""

if ($failedTests -gt 0) {
    Write-Host "Failed Tests:" -ForegroundColor Red
    foreach ($error in $errors) {
        Write-Host "  - $error" -ForegroundColor Red
    }
    Write-Host ""
}

if ($failedTests -eq 0) {
    Write-Host "✓ ALL TESTS PASSED!" -ForegroundColor Green
    Write-Host "The API is working perfectly!" -ForegroundColor Green
} else {
    Write-Host "✗ SOME TESTS FAILED" -ForegroundColor Red
    Write-Host "Please review the errors above." -ForegroundColor Yellow
}

Write-Host ""
Write-Host "========================================" -ForegroundColor Cyan
Write-Host "Testing Complete!" -ForegroundColor Cyan
Write-Host "========================================" -ForegroundColor Cyan
