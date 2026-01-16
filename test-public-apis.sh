#!/bin/bash

# Doctor Appointment API - Public API Testing Script
# This script tests all public endpoints without authentication

BASE_URL="http://localhost:8000/api/v1"

echo "=================================="
echo "Testing Doctor Appointment API"
echo "Public Endpoints (No Auth Required)"
echo "=================================="
echo ""

# Colors for output
GREEN='\033[0;32m'
RED='\033[0;31m'
BLUE='\033[0;34m'
NC='\033[0m' # No Color

# Test counter
TOTAL_TESTS=0
PASSED_TESTS=0

# Function to test endpoint
test_endpoint() {
    TOTAL_TESTS=$((TOTAL_TESTS + 1))
    echo -e "${BLUE}Test $TOTAL_TESTS: $1${NC}"
    echo "Endpoint: $2"
    
    RESPONSE=$(curl -s -w "\n%{http_code}" "$2")
    HTTP_CODE=$(echo "$RESPONSE" | tail -n1)
    BODY=$(echo "$RESPONSE" | sed '$d')
    
    if [ "$HTTP_CODE" -eq "$3" ]; then
        echo -e "${GREEN}✓ PASSED${NC} (HTTP $HTTP_CODE)"
        PASSED_TESTS=$((PASSED_TESTS + 1))
    else
        echo -e "${RED}✗ FAILED${NC} (Expected HTTP $3, got HTTP $HTTP_CODE)"
    fi
    echo ""
}

# Function to test POST endpoint
test_post_endpoint() {
    TOTAL_TESTS=$((TOTAL_TESTS + 1))
    echo -e "${BLUE}Test $TOTAL_TESTS: $1${NC}"
    echo "Endpoint: $2"
    
    RESPONSE=$(curl -s -w "\n%{http_code}" -X POST "$2" \
        -H "Content-Type: application/json" \
        -d "$3")
    HTTP_CODE=$(echo "$RESPONSE" | tail -n1)
    BODY=$(echo "$RESPONSE" | sed '$d')
    
    if [ "$HTTP_CODE" -eq "$4" ]; then
        echo -e "${GREEN}✓ PASSED${NC} (HTTP $HTTP_CODE)"
        PASSED_TESTS=$((PASSED_TESTS + 1))
    else
        echo -e "${RED}✗ FAILED${NC} (Expected HTTP $4, got HTTP $HTTP_CODE)"
        echo "Response: $BODY"
    fi
    echo ""
}

echo "=================================="
echo "1. HEALTH CHECK"
echo "=================================="
test_endpoint "Health Check" "http://localhost:8000/api/health" 200

echo "=================================="
echo "2. PUBLIC SERVICES"
echo "=================================="
test_endpoint "List All Services" "$BASE_URL/services" 200
test_endpoint "Featured Services" "$BASE_URL/services/featured" 200
test_endpoint "View Service by Slug" "$BASE_URL/services/general-consultation" 200
test_endpoint "Search Services" "$BASE_URL/services?search=consultation" 200
test_endpoint "Filter Services by Price" "$BASE_URL/services?min_price=50&max_price=200" 200

echo "=================================="
echo "3. PUBLIC DOCTORS"
echo "=================================="
test_endpoint "List All Doctors" "$BASE_URL/doctors" 200
test_endpoint "Featured Doctors" "$BASE_URL/doctors/featured" 200
test_endpoint "List Specializations" "$BASE_URL/doctors/specializations" 200
test_endpoint "View Doctor Profile" "$BASE_URL/doctors/2" 200
test_endpoint "Search Doctors" "$BASE_URL/doctors?search=cardiology" 200
test_endpoint "Filter Doctors by Specialization" "$BASE_URL/doctors?specialization=Cardiology" 200

echo "=================================="
echo "4. PUBLIC BLOGS"
echo "=================================="
test_endpoint "List All Blogs" "$BASE_URL/blogs" 200
test_endpoint "Featured Blogs" "$BASE_URL/blogs/featured" 200
test_endpoint "List Categories" "$BASE_URL/blogs/categories" 200
test_endpoint "List Tags" "$BASE_URL/blogs/tags" 200
test_endpoint "View Blog Post" "$BASE_URL/blogs/10-tips-healthy-heart" 200
test_endpoint "Related Blogs" "$BASE_URL/blogs/10-tips-healthy-heart/related" 200
test_endpoint "Filter Blogs by Category" "$BASE_URL/blogs?category=Health%20Tips" 200

echo "=================================="
echo "5. PUBLIC APPOINTMENTS"
echo "=================================="
test_endpoint "Check Available Slots" "$BASE_URL/appointments/available-slots?doctor_id=2&date=2025-12-31" 200

# Test booking appointment
APPOINTMENT_DATA='{
  "patient_name": "Test Patient",
  "patient_email": "test@example.com",
  "patient_phone": "+1234567890",
  "doctor_id": 2,
  "service_id": 1,
  "appointment_date": "2025-12-31",
  "appointment_time": "14:00",
  "notes": "Test appointment"
}'
test_post_endpoint "Book Appointment" "$BASE_URL/appointments" "$APPOINTMENT_DATA" 201

# Test check status
STATUS_DATA='{
  "patient_email": "test@example.com",
  "patient_phone": "+1234567890"
}'
test_post_endpoint "Check Appointment Status" "$BASE_URL/appointments/check-status" "$STATUS_DATA" 200

echo "=================================="
echo "6. CONTACT FORM"
echo "=================================="
test_endpoint "Get Contact Info" "$BASE_URL/contact/info" 200

# Test contact form submission
CONTACT_DATA='{
  "name": "Test User",
  "email": "test@example.com",
  "phone": "+1234567890",
  "subject": "Test Inquiry",
  "message": "This is a test message from the automated testing script."
}'
test_post_endpoint "Submit Contact Form" "$BASE_URL/contact" "$CONTACT_DATA" 201

echo "=================================="
echo "TEST SUMMARY"
echo "=================================="
echo "Total Tests: $TOTAL_TESTS"
echo -e "Passed: ${GREEN}$PASSED_TESTS${NC}"
echo -e "Failed: ${RED}$((TOTAL_TESTS - PASSED_TESTS))${NC}"
echo ""

if [ $PASSED_TESTS -eq $TOTAL_TESTS ]; then
    echo -e "${GREEN}✓ ALL TESTS PASSED!${NC}"
    exit 0
else
    echo -e "${RED}✗ SOME TESTS FAILED${NC}"
    exit 1
fi
