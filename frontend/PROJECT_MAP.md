# 🗺️ Doctor Appointment Frontend - Project Map

Visual guide to navigate the project structure and understand what's where.

---

## 📂 Directory Tree

```
d:\Doctor Website\
│
├── doctor-appointment-api/              # Laravel Backend (Already Complete)
│   └── ... (65 API endpoints ready)
│
└── doctor-appointment-frontend/         # Frontend Project (This)
    │
    ├── admin-panel/                     # ✅ Admin Panel (60% Complete)
    │   │
    │   ├── public/                      # Static assets
    │   │   └── vite.svg
    │   │
    │   ├── src/                         # Source code
    │   │   │
    │   │   ├── assets/                  # Images, fonts, etc.
    │   │   │
    │   │   ├── components/              # Reusable components (future)
    │   │   │
    │   │   ├── layouts/                 # Layout components
    │   │   │   └── MainLayout.vue       # ✅ Main admin layout
    │   │   │
    │   │   ├── views/                   # Page components
    │   │   │   │
    │   │   │   ├── Login.vue            # ✅ Login page
    │   │   │   ├── Dashboard.vue        # ✅ Dashboard with stats
    │   │   │   │
    │   │   │   ├── appointments/        # Appointments module
    │   │   │   │   ├── Index.vue        # ✅ List view
    │   │   │   │   ├── Create.vue       # ✅ Create form
    │   │   │   │   ├── View.vue         # ✅ Detail view
    │   │   │   │   └── Edit.vue         # ⚠️ Edit form (stub)
    │   │   │   │
    │   │   │   ├── doctors/             # Doctors module
    │   │   │   │   ├── Index.vue        # ⚠️ List view (stub)
    │   │   │   │   ├── Create.vue       # ⚠️ Create form (stub)
    │   │   │   │   ├── View.vue         # ⚠️ Detail view (stub)
    │   │   │   │   └── Edit.vue         # ⚠️ Edit form (stub)
    │   │   │   │
    │   │   │   ├── services/            # Services module
    │   │   │   │   ├── Index.vue        # ⚠️ List view (stub)
    │   │   │   │   ├── Create.vue       # ⚠️ Create form (stub)
    │   │   │   │   ├── View.vue         # ⚠️ Detail view (stub)
    │   │   │   │   └── Edit.vue         # ⚠️ Edit form (stub)
    │   │   │   │
    │   │   │   └── blogs/               # Blogs module
    │   │   │       ├── Index.vue        # ⚠️ List view (stub)
    │   │   │       ├── Create.vue       # ⚠️ Create form (stub)
    │   │   │       ├── View.vue         # ⚠️ Detail view (stub)
    │   │   │       └── Edit.vue         # ⚠️ Edit form (stub)
    │   │   │
    │   │   ├── router/                  # Routing configuration
    │   │   │   └── index.js             # ✅ Routes & guards
    │   │   │
    │   │   ├── stores/                  # State management (Pinia)
    │   │   │   └── auth.js              # ✅ Auth store
    │   │   │
    │   │   ├── services/                # API service layer
    │   │   │   ├── api.js               # ✅ Axios instance
    │   │   │   ├── authService.js       # ✅ Auth APIs
    │   │   │   ├── appointmentService.js # ✅ Appointment APIs
    │   │   │   ├── doctorService.js     # ✅ Doctor APIs
    │   │   │   ├── serviceService.js    # ✅ Service APIs
    │   │   │   └── blogService.js       # ✅ Blog APIs
    │   │   │
    │   │   ├── utils/                   # Utility functions (future)
    │   │   │
    │   │   ├── App.vue                  # ✅ Root component
    │   │   ├── main.js                  # ✅ App entry point
    │   │   └── style.css                # ✅ Global styles
    │   │
    │   ├── .gitignore                   # ✅ Git ignore rules
    │   ├── index.html                   # ✅ HTML template
    │   ├── package.json                 # ✅ Dependencies
    │   ├── vite.config.js               # ✅ Vite config
    │   ├── tailwind.config.js           # ✅ Tailwind config
    │   ├── postcss.config.js            # ✅ PostCSS config
    │   └── README.md                    # ✅ Admin panel docs
    │
    ├── public-website/                  # ❌ Public Website (Not Created)
    │   └── (To be created)
    │
    ├── QUICK_START.md                   # ✅ 5-minute quick start
    ├── SETUP_GUIDE.md                   # ✅ Complete setup guide
    ├── PROJECT_STATUS.md                # ✅ Progress tracking
    ├── PROJECT_MAP.md                   # ✅ This file
    └── README.md                        # ✅ Main documentation
```

---

## 🎯 File Purpose Guide

### Configuration Files

| File | Purpose | Status |
|------|---------|--------|
| `package.json` | Dependencies & scripts | ✅ Complete |
| `vite.config.js` | Vite build configuration | ✅ Complete |
| `tailwind.config.js` | Tailwind CSS configuration | ✅ Complete |
| `postcss.config.js` | PostCSS configuration | ✅ Complete |
| `index.html` | HTML entry point | ✅ Complete |
| `.gitignore` | Git ignore rules | ✅ Complete |

### Core Application Files

| File | Purpose | Status |
|------|---------|--------|
| `src/main.js` | App initialization | ✅ Complete |
| `src/App.vue` | Root component | ✅ Complete |
| `src/style.css` | Global styles | ✅ Complete |

### Router & State

| File | Purpose | Status |
|------|---------|--------|
| `src/router/index.js` | Route definitions & guards | ✅ Complete |
| `src/stores/auth.js` | Authentication state | ✅ Complete |

### API Services

| File | Purpose | Status |
|------|---------|--------|
| `src/services/api.js` | Axios instance & interceptors | ✅ Complete |
| `src/services/authService.js` | Login, logout, get user | ✅ Complete |
| `src/services/appointmentService.js` | Appointment CRUD | ✅ Complete |
| `src/services/doctorService.js` | Doctor CRUD | ✅ Complete |
| `src/services/serviceService.js` | Service CRUD | ✅ Complete |
| `src/services/blogService.js` | Blog CRUD | ✅ Complete |

### Layouts

| File | Purpose | Status |
|------|---------|--------|
| `src/layouts/MainLayout.vue` | Admin layout with sidebar | ✅ Complete |

### Views - Authentication

| File | Purpose | Status |
|------|---------|--------|
| `src/views/Login.vue` | Login page | ✅ Complete |

### Views - Dashboard

| File | Purpose | Status |
|------|---------|--------|
| `src/views/Dashboard.vue` | Dashboard with stats & charts | ✅ Complete |

### Views - Appointments

| File | Purpose | Status |
|------|---------|--------|
| `src/views/appointments/Index.vue` | List all appointments | ✅ Complete |
| `src/views/appointments/Create.vue` | Create new appointment | ✅ Complete |
| `src/views/appointments/View.vue` | View appointment details | ✅ Complete |
| `src/views/appointments/Edit.vue` | Edit appointment | ⚠️ Stub |

### Views - Doctors

| File | Purpose | Status |
|------|---------|--------|
| `src/views/doctors/Index.vue` | List all doctors | ⚠️ Stub |
| `src/views/doctors/Create.vue` | Create new doctor | ⚠️ Stub |
| `src/views/doctors/View.vue` | View doctor details | ⚠️ Stub |
| `src/views/doctors/Edit.vue` | Edit doctor | ⚠️ Stub |

### Views - Services

| File | Purpose | Status |
|------|---------|--------|
| `src/views/services/Index.vue` | List all services | ⚠️ Stub |
| `src/views/services/Create.vue` | Create new service | ⚠️ Stub |
| `src/views/services/View.vue` | View service details | ⚠️ Stub |
| `src/views/services/Edit.vue` | Edit service | ⚠️ Stub |

### Views - Blogs

| File | Purpose | Status |
|------|---------|--------|
| `src/views/blogs/Index.vue` | List all blogs | ⚠️ Stub |
| `src/views/blogs/Create.vue` | Create new blog | ⚠️ Stub |
| `src/views/blogs/View.vue` | View blog details | ⚠️ Stub |
| `src/views/blogs/Edit.vue` | Edit blog | ⚠️ Stub |

### Documentation

| File | Purpose | Status |
|------|---------|--------|
| `README.md` | Main project documentation | ✅ Complete |
| `QUICK_START.md` | 5-minute quick start | ✅ Complete |
| `SETUP_GUIDE.md` | Complete setup guide | ✅ Complete |
| `PROJECT_STATUS.md` | Progress tracking | ✅ Complete |
| `PROJECT_MAP.md` | This file | ✅ Complete |
| `admin-panel/README.md` | Admin panel docs | ✅ Complete |

---

## 🔍 Quick Navigation

### Want to...

**Start the project?**
→ Read `QUICK_START.md`

**Set up for development?**
→ Read `SETUP_GUIDE.md`

**See what's done?**
→ Read `PROJECT_STATUS.md`

**Understand the code?**
→ Read `admin-panel/README.md`

**Find a specific file?**
→ Use this `PROJECT_MAP.md`

**See overall progress?**
→ Read `README.md`

---

## 📊 Status Legend

| Symbol | Meaning |
|--------|---------|
| ✅ | Complete and functional |
| ⚠️ | Stub/placeholder (needs implementation) |
| ❌ | Not created yet |

---

## 🎯 Module Status

### Admin Panel Modules

```
Authentication    ████████████████████ 100% ✅
Dashboard         ████████████████████ 100% ✅
Appointments      ███████████████░░░░░  75% ⚠️
Doctors           ░░░░░░░░░░░░░░░░░░░░   0% ⚠️
Services          ░░░░░░░░░░░░░░░░░░░░   0% ⚠️
Blogs             ░░░░░░░░░░░░░░░░░░░░   0% ⚠️
```

### Overall Progress

```
Admin Panel       ████████████░░░░░░░░  60% ⚠️
Public Website    ���░░░░░░░░░░░░░░░░░░░   0% ❌
Total Project     ██████░░░░░░░░░░░░░░  30% ⚠️
```

---

## 🚀 Routes Map

### Public Routes (No Auth Required)

```
/login                    → Login.vue
```

### Protected Routes (Auth Required)

```
/                         → Redirect to /dashboard
/dashboard                → Dashboard.vue

/appointments             → appointments/Index.vue
/appointments/create      → appointments/Create.vue
/appointments/:id         → appointments/View.vue
/appointments/:id/edit    → appointments/Edit.vue

/doctors                  → doctors/Index.vue
/doctors/create           → doctors/Create.vue
/doctors/:id              → doctors/View.vue
/doctors/:id/edit         → doctors/Edit.vue

/services                 → services/Index.vue
/services/create          → services/Create.vue
/services/:id             → services/View.vue
/services/:id/edit        → services/Edit.vue

/blogs                    → blogs/Index.vue
/blogs/create             → blogs/Create.vue
/blogs/:id                → blogs/View.vue
/blogs/:id/edit           → blogs/Edit.vue
```

---

## 🔌 API Endpoints Map

### Authentication

```
POST   /api/v1/admin/login           → authService.login()
POST   /api/v1/admin/logout          → authService.logout()
GET    /api/v1/admin/me              → authService.getMe()
```

### Appointments

```
GET    /api/v1/admin/appointments              → appointmentService.getAll()
POST   /api/v1/admin/appointments              → appointmentService.create()
GET    /api/v1/admin/appointments/{id}         → appointmentService.getById()
PUT    /api/v1/admin/appointments/{id}         → appointmentService.update()
DELETE /api/v1/admin/appointments/{id}         → appointmentService.delete()
POST   /api/v1/admin/appointments/{id}/approve → appointmentService.approve()
POST   /api/v1/admin/appointments/{id}/cancel  → appointmentService.cancel()
POST   /api/v1/admin/appointments/{id}/complete → appointmentService.complete()
GET    /api/v1/admin/appointments/statistics   → appointmentService.getStatistics()
```

### Doctors

```
GET    /api/v1/admin/doctors                   → doctorService.getAll()
POST   /api/v1/admin/doctors                   → doctorService.create()
GET    /api/v1/admin/doctors/{id}              → doctorService.getById()
PUT    /api/v1/admin/doctors/{id}              → doctorService.update()
DELETE /api/v1/admin/doctors/{id}              → doctorService.delete()
POST   /api/v1/admin/doctors/{id}/activate     → doctorService.activate()
POST   /api/v1/admin/doctors/{id}/deactivate   → doctorService.deactivate()
GET    /api/v1/admin/doctors/statistics        → doctorService.getStatistics()
```

### Services

```
GET    /api/v1/admin/services                  → serviceService.getAll()
POST   /api/v1/admin/services                  → serviceService.create()
GET    /api/v1/admin/services/{id}             → serviceService.getById()
PUT    /api/v1/admin/services/{id}             → serviceService.update()
DELETE /api/v1/admin/services/{id}             → serviceService.delete()
POST   /api/v1/admin/services/{id}/activate    → serviceService.activate()
POST   /api/v1/admin/services/{id}/deactivate  → serviceService.deactivate()
POST   /api/v1/admin/services/reorder          → serviceService.reorder()
GET    /api/v1/admin/services/statistics       → serviceService.getStatistics()
```

### Blogs

```
GET    /api/v1/admin/blogs                     → blogService.getAll()
POST   /api/v1/admin/blogs                     → blogService.create()
GET    /api/v1/admin/blogs/{id}                → blogService.getById()
PUT    /api/v1/admin/blogs/{id}                → blogService.update()
DELETE /api/v1/admin/blogs/{id}                → blogService.delete()
POST   /api/v1/admin/blogs/{id}/publish        → blogService.publish()
POST   /api/v1/admin/blogs/{id}/unpublish      → blogService.unpublish()
POST   /api/v1/admin/blogs/{id}/archive        → blogService.archive()
GET    /api/v1/admin/blogs/statistics          → blogService.getStatistics()
```

---

## 🎨 Component Hierarchy

```
App.vue
└── <router-view>
    │
    ├── Login.vue (Public)
    │
    └── MainLayout.vue (Protected)
        ├── Sidebar Navigation
        ├── Top Bar
        └── <router-view>
            │
            ├── Dashboard.vue
            │
            ├── appointments/
            │   ├── Index.vue
            │   ├── Create.vue
            │   ├── View.vue
            │   └── Edit.vue
            │
            ├── doctors/
            │   ├── Index.vue
            │   ├── Create.vue
            │   ├── View.vue
            │   └── Edit.vue
            │
            ├── services/
            │   ├── Index.vue
            │   ├── Create.vue
            │   ├── View.vue
            │   └── Edit.vue
            │
            └── blogs/
                ├── Index.vue
                ├── Create.vue
                ├── View.vue
                └── Edit.vue
```

---

## 📦 Dependencies Map

### Production Dependencies

```
vue                    → Core framework
vue-router             → Routing
pinia                  → State management
axios                  → HTTP client
@headlessui/vue        → Accessible components
@heroicons/vue         → Icons
chart.js               → Charts
vue-chartjs            → Vue wrapper for Chart.js
vee-validate           → Form validation
yup                    → Schema validation
vue-toastification     → Toast notifications
dayjs                  → Date manipulation
@vuepic/vue-datepicker → Date picker
```

### Development Dependencies

```
@vitejs/plugin-vue     → Vite Vue plugin
vite                   → Build tool
tailwindcss            → CSS framework
autoprefixer           → CSS autoprefixer
postcss                → CSS processor
```

---

## 🎯 Where to Start

### For New Developers

1. **Read:** `QUICK_START.md`
2. **Install:** Follow installation steps
3. **Explore:** Login and navigate the admin panel
4. **Read:** `admin-panel/README.md`
5. **Code:** Start with stub files

### For Implementing Features

1. **Check:** This `PROJECT_MAP.md` to find files
2. **Read:** Existing complete files (e.g., `appointments/Index.vue`)
3. **Copy:** Pattern from complete files
4. **Modify:** For your specific module
5. **Test:** In browser

### For Understanding Architecture

1. **Start:** `src/main.js` (entry point)
2. **Then:** `src/App.vue` (root component)
3. **Then:** `src/router/index.js` (routing)
4. **Then:** `src/stores/auth.js` (state)
5. **Then:** `src/services/api.js` (API layer)

---

## 🔧 Build Process

```
Development:
npm run dev
    ↓
Vite starts dev server
    ↓
Hot Module Replacement enabled
    ↓
Access at http://localhost:3000

Production:
npm run build
    ↓
Vite builds optimized bundle
    ↓
Output to dist/ folder
    ↓
Deploy dist/ folder
```

---

## 📝 Quick Reference

### Start Development
```bash
cd admin-panel
npm run dev
```

### Build for Production
```bash
cd admin-panel
npm run build
```

### Preview Production Build
```bash
cd admin-panel
npm run preview
```

### Install Dependencies
```bash
cd admin-panel
npm install
```

---

**Use this map to navigate the project efficiently! 🗺️**
