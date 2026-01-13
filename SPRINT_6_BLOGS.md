# Sprint 6: Blog Management - Complete

## ✅ Blog Management APIs Successfully Implemented!

### 🎯 Goal Achieved
Complete admin control over blogs with CRUD operations, publishing workflow, category/tag management, filtering, and statistics.

---

## 📦 What Was Implemented

### 1. **Blog Controller**
**File:** `app/Http/Controllers/Api/Admin/BlogController.php`

**Methods:**
- `index()` - List blogs with pagination and filtering
- `store()` - Create new blog
- `show()` - Get blog details
- `update()` - Update blog
- `destroy()` - Delete blog
- `publish()` - Publish blog
- `unpublish()` - Unpublish blog (set to draft)
- `archive()` - Archive blog
- `statistics()` - Get blog statistics
- `categories()` - Get all unique categories
- `tags()` - Get all unique tags

### 2. **Request Validation**
**Files:**
- `app/Http/Requests/StoreBlogRequest.php`
- `app/Http/Requests/UpdateBlogRequest.php`

**Validation Rules:**
- Title validation (required, unique)
- Slug validation (unique, auto-generated)
- Content validation (required)
- Excerpt validation (max 500 chars)
- Category validation
- Tags validation (array)
- Status validation (draft, published, archived)
- Published date validation

### 3. **API Resource**
**File:** `app/Http/Resources/BlogResource.php`

**Transforms:**
- Blog data
- Author information
- Formatted dates
- Tags array
- Reading time estimation
- View count

### 4. **Sample Data Seeder**
**File:** `database/seeders/BlogSeeder.php`

**Created:** 10 sample blog posts including:
- 7 Published blogs
- 3 Draft blogs
- Various categories (Cardiology, Mental Health, Nutrition, etc.)
- Realistic medical content
- Tags and view counts

---

## 📡 API Endpoints

### Base URL
```
http://localhost:8000/api/v1/admin/blogs
```

**Authentication Required:** Bearer Token (Admin only)

---

### 1. List Blogs (with Pagination & Filtering)

**Endpoint:** `GET /api/v1/admin/blogs`

**Headers:**
```
Authorization: Bearer {admin_token}
```

**Query Parameters:**
```
per_page        - Items per page (default: 15, max: 100)
status          - Filter by status (draft, published, archived)
category        - Filter by category
author_id       - Filter by author ID
search          - Search by title, excerpt, or content
tag             - Filter by specific tag
date_from       - Filter from date (Y-m-d)
date_to         - Filter to date (Y-m-d)
sort_by         - Sort field (title, status, views, published_at, created_at)
sort_order      - Sort order (asc/desc, default: desc)
```

**Example Request:**
```bash
curl -X GET "http://localhost:8000/api/v1/admin/blogs?status=published&per_page=10" \
  -H "Authorization: Bearer YOUR_TOKEN"
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
                "title": "10 Essential Tips for Maintaining Heart Health",
                "slug": "10-essential-tips-for-maintaining-heart-health",
                "excerpt": "Learn the most important lifestyle changes...",
                "content": "<h2>Introduction</h2><p>Heart health is crucial...",
                "featured_image": "/images/blogs/heart-health.jpg",
                "category": "Cardiology",
                "tags": ["heart health", "cardiovascular", "prevention", "lifestyle"],
                "status": "published",
                "views": 245,
                "author": {
                    "id": 1,
                    "name": "Admin User",
                    "email": "admin@doctorappoint.com"
                },
                "published_at": "2025-12-20 12:00:00",
                "created_at": "2025-12-20 12:00:00",
                "updated_at": "2025-12-20 12:00:00",
                "reading_time": "5 mins read"
            }
        ],
        "links": {
            "first": "http://localhost:8000/api/v1/admin/blogs?page=1",
            "last": "http://localhost:8000/api/v1/admin/blogs?page=1",
            "prev": null,
            "next": null
        },
        "meta": {
            "current_page": 1,
            "from": 1,
            "last_page": 1,
            "per_page": 10,
            "to": 10,
            "total": 10
        }
    }
}
```

---

### 2. Create Blog

**Endpoint:** `POST /api/v1/admin/blogs`

**Headers:**
```
Authorization: Bearer {admin_token}
Content-Type: application/json
```

**Request Body:**
```json
{
    "title": "The Benefits of Regular Exercise",
    "excerpt": "Discover how regular physical activity can transform your health and well-being.",
    "content": "<h2>Introduction</h2><p>Regular exercise is one of the most important things you can do for your health...</p>",
    "featured_image": "/images/blogs/exercise.jpg",
    "category": "Fitness",
    "tags": ["exercise", "fitness", "health", "wellness"],
    "status": "draft"
}
```

**Success Response (201):**
```json
{
    "status": "success",
    "message": "Blog created successfully",
    "data": {
        "id": 11,
        "title": "The Benefits of Regular Exercise",
        "slug": "the-benefits-of-regular-exercise",
        "excerpt": "Discover how regular physical activity...",
        "content": "<h2>Introduction</h2><p>Regular exercise...",
        "featured_image": "/images/blogs/exercise.jpg",
        "category": "Fitness",
        "tags": ["exercise", "fitness", "health", "wellness"],
        "status": "draft",
        "views": 0,
        "author": {
            "id": 1,
            "name": "Admin User",
            "email": "admin@doctorappoint.com"
        },
        "published_at": null,
        "created_at": "2025-12-30 15:00:00",
        "updated_at": "2025-12-30 15:00:00",
        "reading_time": "3 mins read"
    }
}
```

**Validation Errors (422):**
```json
{
    "status": "error",
    "message": "Validation failed",
    "errors": {
        "title": ["Blog title is required"],
        "content": ["Blog content is required"]
    }
}
```

---

### 3. Get Blog Details

**Endpoint:** `GET /api/v1/admin/blogs/{id}`

**Headers:**
```
Authorization: Bearer {admin_token}
```

**Success Response (200):**
```json
{
    "status": "success",
    "message": "Blog retrieved successfully",
    "data": {
        "id": 1,
        "title": "10 Essential Tips for Maintaining Heart Health",
        "slug": "10-essential-tips-for-maintaining-heart-health",
        "excerpt": "Learn the most important lifestyle changes...",
        "content": "<h2>Introduction</h2><p>Heart health is crucial...",
        "featured_image": "/images/blogs/heart-health.jpg",
        "category": "Cardiology",
        "tags": ["heart health", "cardiovascular", "prevention", "lifestyle"],
        "status": "published",
        "views": 245,
        "author": {
            "id": 1,
            "name": "Admin User",
            "email": "admin@doctorappoint.com"
        },
        "published_at": "2025-12-20 12:00:00",
        "created_at": "2025-12-20 12:00:00",
        "updated_at": "2025-12-20 12:00:00",
        "reading_time": "5 mins read"
    }
}
```

**Error Response (404):**
```json
{
    "status": "error",
    "message": "Blog not found"
}
```

---

### 4. Update Blog

**Endpoint:** `PUT /api/v1/admin/blogs/{id}`

**Headers:**
```
Authorization: Bearer {admin_token}
Content-Type: application/json
```

**Request Body (Partial Update):**
```json
{
    "title": "Updated Title",
    "category": "Wellness",
    "tags": ["health", "wellness", "lifestyle"]
}
```

**Success Response (200):**
```json
{
    "status": "success",
    "message": "Blog updated successfully",
    "data": {
        "id": 1,
        "title": "Updated Title",
        "category": "Wellness",
        "tags": ["health", "wellness", "lifestyle"],
        ...
    }
}
```

---

### 5. Delete Blog

**Endpoint:** `DELETE /api/v1/admin/blogs/{id}`

**Headers:**
```
Authorization: Bearer {admin_token}
```

**Success Response (200):**
```json
{
    "status": "success",
    "message": "Blog deleted successfully",
    "data": null
}
```

---

### 6. Publish Blog

**Endpoint:** `POST /api/v1/admin/blogs/{id}/publish`

**Headers:**
```
Authorization: Bearer {admin_token}
```

**Success Response (200):**
```json
{
    "status": "success",
    "message": "Blog published successfully",
    "data": {
        "id": 8,
        "title": "Understanding Allergies: Types, Triggers, and Treatment",
        "status": "published",
        "published_at": "2025-12-30 15:30:00",
        ...
    }
}
```

**Error Response (400):**
```json
{
    "status": "error",
    "message": "Blog is already published"
}
```

---

### 7. Unpublish Blog

**Endpoint:** `POST /api/v1/admin/blogs/{id}/unpublish`

**Headers:**
```
Authorization: Bearer {admin_token}
```

**Success Response (200):**
```json
{
    "status": "success",
    "message": "Blog unpublished successfully",
    "data": {
        "id": 1,
        "title": "10 Essential Tips for Maintaining Heart Health",
        "status": "draft",
        "published_at": null,
        ...
    }
}
```

**Error Response (400):**
```json
{
    "status": "error",
    "message": "Blog is already a draft"
}
```

---

### 8. Archive Blog

**Endpoint:** `POST /api/v1/admin/blogs/{id}/archive`

**Headers:**
```
Authorization: Bearer {admin_token}
```

**Success Response (200):**
```json
{
    "status": "success",
    "message": "Blog archived successfully",
    "data": {
        "id": 1,
        "title": "10 Essential Tips for Maintaining Heart Health",
        "status": "archived",
        ...
    }
}
```

**Error Response (400):**
```json
{
    "status": "error",
    "message": "Blog is already archived"
}
```

---

### 9. Get Statistics

**Endpoint:** `GET /api/v1/admin/blogs/statistics`

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
        "total": 10,
        "published": 7,
        "draft": 3,
        "archived": 0,
        "total_views": 1321,
        "average_views": 132,
        "most_viewed": [
            {
                "id": 4,
                "title": "Mental Health Matters: Breaking the Stigma",
                "slug": "mental-health-matters-breaking-the-stigma",
                "views": 312,
                "author": "Admin User"
            },
            {
                "id": 1,
                "title": "10 Essential Tips for Maintaining Heart Health",
                "slug": "10-essential-tips-for-maintaining-heart-health",
                "views": 245,
                "author": "Admin User"
            }
        ],
        "recent_published": [
            {
                "id": 7,
                "title": "Pediatric Care: Common Childhood Illnesses",
                "slug": "pediatric-care-common-childhood-illnesses",
                "published_at": "2025-12-29 12:00:00",
                "author": "Admin User"
            }
        ],
        "categories": [
            {
                "category": "Cardiology",
                "count": 1
            },
            {
                "category": "Mental Health",
                "count": 1
            },
            {
                "category": "Nutrition",
                "count": 1
            }
        ]
    }
}
```

---

### 10. Get Categories

**Endpoint:** `GET /api/v1/admin/blogs/categories`

**Headers:**
```
Authorization: Bearer {admin_token}
```

**Success Response (200):**
```json
{
    "status": "success",
    "message": "Categories retrieved successfully",
    "data": {
        "categories": [
            "Cardiology",
            "Endocrinology",
            "Immunology",
            "Mental Health",
            "Nutrition",
            "Ophthalmology",
            "Orthopedics",
            "Pediatrics",
            "Preventive Care",
            "Wellness"
        ]
    }
}
```

---

### 11. Get Tags

**Endpoint:** `GET /api/v1/admin/blogs/tags`

**Headers:**
```
Authorization: Bearer {admin_token}
```

**Success Response (200):**
```json
{
    "status": "success",
    "message": "Tags retrieved successfully",
    "data": {
        "tags": [
            "allergies",
            "anxiety",
            "arthritis",
            "blood sugar",
            "cardiovascular",
            "check-up",
            "children health",
            "chronic disease",
            "depression",
            "diabetes",
            "diet",
            "early detection",
            "eye care",
            "eye health",
            "health",
            "health management",
            "health screening",
            "healthy eating",
            "heart health",
            "illness",
            "immune system",
            "joint health",
            "lifestyle",
            "mental health",
            "nutrition",
            "orthopedics",
            "pain management",
            "parenting",
            "pediatrics",
            "prevention",
            "preventive care",
            "rest",
            "sleep",
            "sleep hygiene",
            "treatment",
            "vision",
            "wellness"
        ]
    }
}
```

---

## 🔍 Filtering & Search Examples

### Filter by Status
```bash
GET /api/v1/admin/blogs?status=published
GET /api/v1/admin/blogs?status=draft
GET /api/v1/admin/blogs?status=archived
```

### Filter by Category
```bash
GET /api/v1/admin/blogs?category=Cardiology
GET /api/v1/admin/blogs?category=Mental Health
```

### Filter by Tag
```bash
GET /api/v1/admin/blogs?tag=heart health
GET /api/v1/admin/blogs?tag=wellness
```

### Search by Content
```bash
GET /api/v1/admin/blogs?search=diabetes
GET /api/v1/admin/blogs?search=mental health
```

### Filter by Date Range
```bash
GET /api/v1/admin/blogs?date_from=2025-12-01&date_to=2025-12-31
```

### Filter by Author
```bash
GET /api/v1/admin/blogs?author_id=1
```

### Sorting
```bash
GET /api/v1/admin/blogs?sort_by=views&sort_order=desc
GET /api/v1/admin/blogs?sort_by=title&sort_order=asc
GET /api/v1/admin/blogs?sort_by=published_at&sort_order=desc
```

### Combined Filters
```bash
GET /api/v1/admin/blogs?status=published&category=Cardiology&sort_by=views&sort_order=desc&per_page=20
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
- ✅ Author automatically set to authenticated user

### Input Validation
- ✅ All inputs validated
- ✅ Unique title validation
- ✅ Content required
- ✅ Status validation
- ✅ Tags array validation
- ✅ Custom error messages

### Data Protection
- ✅ Database transactions
- ✅ Rollback on errors
- ✅ Proper error handling

---

## 📊 Blog Status Flow

```
draft → published → archived
  ↓         ↓
draft    draft
```

**Rules:**
- Draft blogs can be: published or archived
- Published blogs can be: unpublished (to draft) or archived
- Archived blogs can be: published or unpublished
- Publishing automatically sets published_at timestamp
- Unpublishing clears published_at timestamp

---

## 📊 Blog Fields

| Field | Type | Required | Description |
|-------|------|----------|-------------|
| title | string | Yes | Blog title (max 255 chars, unique) |
| slug | string | Auto | URL-friendly identifier (auto-generated) |
| excerpt | string | No | Short summary (max 500 chars) |
| content | text | Yes | Full blog content (HTML supported) |
| featured_image | string | No | Featured image path |
| category | string | No | Blog category (max 100 chars) |
| tags | array | No | Array of tags (each max 50 chars) |
| status | enum | No | Status (draft, published, archived) |
| published_at | datetime | Auto | Publication timestamp |
| views | integer | Auto | View count (default: 0) |
| author_id | integer | Auto | Author ID (authenticated user) |

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

### 2. List All Blogs
```bash
curl -X GET http://localhost:8000/api/v1/admin/blogs \
  -H "Authorization: Bearer YOUR_TOKEN"
```

### 3. Create New Blog
```bash
curl -X POST http://localhost:8000/api/v1/admin/blogs \
  -H "Authorization: Bearer YOUR_TOKEN" \
  -H "Content-Type: application/json" \
  -d '{
    "title": "New Health Article",
    "excerpt": "A brief summary of the article",
    "content": "<h2>Introduction</h2><p>Content here...</p>",
    "category": "Health",
    "tags": ["health", "wellness"],
    "status": "draft"
  }'
```

### 4. Publish Blog
```bash
curl -X POST http://localhost:8000/api/v1/admin/blogs/8/publish \
  -H "Authorization: Bearer YOUR_TOKEN"
```

### 5. Get Statistics
```bash
curl -X GET http://localhost:8000/api/v1/admin/blogs/statistics \
  -H "Authorization: Bearer YOUR_TOKEN"
```

### 6. Get All Categories
```bash
curl -X GET http://localhost:8000/api/v1/admin/blogs/categories \
  -H "Authorization: Bearer YOUR_TOKEN"
```

### 7. Get All Tags
```bash
curl -X GET http://localhost:8000/api/v1/admin/blogs/tags \
  -H "Authorization: Bearer YOUR_TOKEN"
```

---

## 📁 Files Created/Modified

### Created Files:
1. **Controller:**
   - `app/Http/Controllers/Api/Admin/BlogController.php`

2. **Requests:**
   - `app/Http/Requests/StoreBlogRequest.php`
   - `app/Http/Requests/UpdateBlogRequest.php`

3. **Resource:**
   - `app/Http/Resources/BlogResource.php`

4. **Seeder:**
   - `database/seeders/BlogSeeder.php`

### Modified Files:
5. **Routes:**
   - `routes/api.php` (added blog routes)

---

## 🎯 Features Summary

### CRUD Operations
- ✅ Create blogs
- ✅ Read blogs (list & detail)
- ✅ Update blogs
- ✅ Delete blogs

### Publishing Workflow
- ✅ Publish blogs
- ✅ Unpublish blogs
- ✅ Archive blogs
- ✅ Auto-set published_at timestamp

### Filtering & Search
- ✅ Filter by status
- ✅ Filter by category
- ✅ Filter by author
- ✅ Filter by tag
- ✅ Filter by date range
- ✅ Search by title/content

### Pagination & Sorting
- ✅ Configurable items per page
- ✅ Page navigation
- ✅ Sort by multiple fields
- ✅ Pagination metadata

### Additional Features
- ✅ Statistics dashboard
- ✅ Category management
- ✅ Tag management
- ✅ View count tracking
- ✅ Reading time estimation
- ✅ Author information
- ✅ Auto-generate slug
- ✅ HTML content support

---

## 📊 Sample Data

**10 blog posts created:**
1. 10 Essential Tips for Maintaining Heart Health (Published, 245 views)
2. Understanding Diabetes: Types, Symptoms, and Management (Published, 189 views)
3. The Importance of Regular Health Check-ups (Published, 156 views)
4. Mental Health Matters: Breaking the Stigma (Published, 312 views)
5. Nutrition Guide: Eating for Optimal Health (Published, 198 views)
6. Sleep Hygiene: The Key to Better Rest (Published, 134 views)
7. Pediatric Care: Common Childhood Illnesses (Published, 87 views)
8. Understanding Allergies: Types, Triggers, and Treatment (Draft)
9. Orthopedic Health: Preventing and Managing Joint Pain (Draft)
10. Eye Care Essentials: Protecting Your Vision (Draft)

**Categories:** Cardiology, Endocrinology, Preventive Care, Mental Health, Nutrition, Wellness, Pediatrics, Immunology, Orthopedics, Ophthalmology

---

## 🚀 Next Steps

### Sprint 7: Doctor Management
- Create doctor CRUD endpoints
- Doctor activation/deactivation
- Specialization management
- Profile management
- Availability scheduling

### Sprint 8: Public APIs
- Public blog viewing
- Public service listing
- Public doctor listing
- Public appointment booking
- Contact form

---

## 🎉 Sprint 6 Complete!

**Status:** ✅ All objectives achieved

**Deliverables:**
- ✅ Blog listing with pagination
- ✅ Blog filtering and search
- ✅ Blog CRUD operations
- ✅ Publishing workflow
- ✅ Category management
- ✅ Tag management
- ✅ Statistics dashboard
- ✅ Sanctum security
- ✅ Request validation
- ✅ API resources
- ✅ Sample data (10 blogs)
- ✅ Reading time estimation

**Ready for:** Sprint 7 - Doctor Management

---

**Created:** 2025-12-30  
**Framework:** Laravel 12  
**Authentication:** Laravel Sanctum  
**Status:** Production Ready
