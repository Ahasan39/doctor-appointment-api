# 🏥 Doctor Appointment System - Frontend

Modern, responsive frontend application for managing doctor appointments, built with Vue.js 3 and Tailwind CSS.

## 📦 Project Structure

This repository contains two separate applications:

### 1. Admin Panel (60% Complete) ✅
Modern admin dashboard for managing appointments, doctors, services, and blogs.

**Location:** `admin-panel/`  
**Status:** Core features complete, CRUD operations in progress  
**URL:** http://localhost:3000

### 2. Public Website (Not Started) ⚠️
Patient-facing website for booking appointments and viewing information.

**Location:** `public-website/`  
**Status:** Not yet created  
**URL:** http://localhost:5173 (when created)

---

## 🚀 Quick Start

### Prerequisites

- Node.js 18+ and npm
- Laravel API backend running on http://localhost:8000

### Install & Run Admin Panel

```bash
# Navigate to admin panel
cd admin-panel

# Install dependencies
npm install

# Start development server
npm run dev
```

**Access:** http://localhost:3000  
**Login:** admin@hospital.com / Admin@123

---

## ✨ Features

### Admin Panel

#### ✅ Completed
- **Authentication** - Secure login with JWT
- **Dashboard** - Statistics, charts, recent appointments
- **Appointments** - List, create, view, approve, cancel, complete
- **Responsive Design** - Works on all devices
- **Modern UI** - Clean, professional interface

#### ⚠️ In Progress
- Appointments Edit
- Doctors Management
- Services Management
- Blogs Management

### Public Website

#### 🚫 Not Started
- Home page
- Doctors listing
- Services listing
- Appointment booking
- Blog
- Contact page

---

## 📁 Directory Structure

```
doctor-appointment-frontend/
│
├── admin-panel/                    # Admin Panel Application
│   ├── src/
│   │   ├── views/                 # Page components
│   │   │   ├── Login.vue          ✅ Complete
│   │   │   ├── Dashboard.vue      ✅ Complete
│   │   │   ├── appointments/      ⚠️ 75% complete
│   │   │   ├── doctors/           ⚠️ Stubs only
│   │   │   ├── services/          ⚠️ Stubs only
│   │   │   └── blogs/             ⚠️ Stubs only
│   │   ├── layouts/
│   │   │   └── MainLayout.vue     ✅ Complete
│   │   ├── services/              # API services
│   │   │   ├── api.js             ✅ Complete
│   │   │   ├── authService.js     ✅ Complete
│   │   │   ├── appointmentService.js ✅ Complete
│   │   │   ├── doctorService.js   ✅ Complete
│   │   │   ├── serviceService.js  ✅ Complete
│   │   │   └── blogService.js     ✅ Complete
│   │   ├── stores/
│   │   │   └── auth.js            ✅ Complete
│   │   ├── router/
│   │   │   └── index.js           ✅ Complete
│   │   ├── App.vue                ✅ Complete
│   │   ├── main.js                ✅ Complete
│   │   └── style.css              ✅ Complete
│   ├── package.json
│   ├── vite.config.js
│   ├── tailwind.config.js
│   └── README.md
│
├── public-website/                 # Public Website (Not created)
│   └── (To be created)
│
├── SETUP_GUIDE.md                  # Complete setup instructions
├── PROJECT_STATUS.md               # Detailed progress tracking
├── QUICK_START.md                  # 5-minute quick start
└── README.md                       # This file
```

---

## 🛠️ Tech Stack

### Admin Panel

- **Vue.js 3** - Progressive JavaScript framework
- **Vite** - Next generation frontend tooling
- **Vue Router** - Official router for Vue.js
- **Pinia** - State management
- **Tailwind CSS** - Utility-first CSS framework
- **Axios** - HTTP client
- **Chart.js** - Charts and graphs
- **Day.js** - Date manipulation
- **Vue Toastification** - Toast notifications

### Public Website (Planned)

- Same stack as Admin Panel
- Additional: Swiper.js for carousels

---

## 📊 Progress Overview

### Overall: 30%

```
Admin Panel:     ████████░░░░░░░░░░░░  60%
Public Website:  ░░░░░░░░░░░░░░░░░░░░   0%
```

### Admin Panel Breakdown

```
Infrastructure:  ████████████████████ 100%
Authentication:  ████████████████████ 100%
Dashboard:       ████████████████████ 100%
Appointments:    ███████████████░░░░░  75%
Doctors:         ░░░░░░░░░░░░░░░░░░░░   0%
Services:        ░░░░░░░░░░░░░░░░░░░░   0%
Blogs:           ░░░░░░░░░░░░░░░░░░░░   0%
```

---

## 📖 Documentation

### Quick Links

- **[QUICK_START.md](./QUICK_START.md)** - Get started in 5 minutes
- **[SETUP_GUIDE.md](./SETUP_GUIDE.md)** - Complete setup instructions
- **[PROJECT_STATUS.md](./PROJECT_STATUS.md)** - Detailed progress tracking
- **[admin-panel/README.md](./admin-panel/README.md)** - Admin panel documentation

### What to Read First

1. **New to the project?** → Start with [QUICK_START.md](./QUICK_START.md)
2. **Setting up for development?** → Read [SETUP_GUIDE.md](./SETUP_GUIDE.md)
3. **Want to see progress?** → Check [PROJECT_STATUS.md](./PROJECT_STATUS.md)
4. **Working on admin panel?** → See [admin-panel/README.md](./admin-panel/README.md)

---

## 🎯 Current Status

### ✅ What's Working

1. **Authentication System**
   - Login page with modern UI
   - JWT token management
   - Auto-redirect on session expiry
   - Logout functionality

2. **Dashboard**
   - Statistics cards (4 metrics)
   - Line chart (appointments overview)
   - Doughnut chart (status distribution)
   - Recent appointments table

3. **Appointments Management**
   - List all appointments
   - Search and filter
   - Create new appointment
   - View appointment details
   - Approve/Cancel/Complete
   - Delete appointment

4. **Infrastructure**
   - API service layer
   - Error handling
   - Loading states
   - Toast notifications
   - Responsive design

### ⚠️ In Progress

- Appointments Edit form
- Doctors module (all views)
- Services module (all views)
- Blogs module (all views)

### 🚫 Not Started

- Public website (all features)

---

## 🚀 Getting Started

### Step 1: Clone or Navigate to Project

```bash
cd "d:\Doctor Website\doctor-appointment-frontend"
```

### Step 2: Install Admin Panel

```bash
cd admin-panel
npm install
```

### Step 3: Start Development Server

```bash
npm run dev
```

### Step 4: Start Laravel API (in another terminal)

```bash
cd "d:\Doctor Website\doctor-appointment-api"
php artisan serve
```

### Step 5: Access Application

Open browser: http://localhost:3000  
Login: admin@hospital.com / Admin@123

---

## 📝 Available Scripts

### Admin Panel

```bash
# Start development server
npm run dev

# Build for production
npm run build

# Preview production build
npm run preview
```

---

## 🎨 Design System

### Colors

```
Primary:    #3B82F6 (Blue)
Secondary:  #10B981 (Green)
Success:    #10B981 (Green)
Warning:    #F59E0B (Amber)
Danger:     #EF4444 (Red)
```

### Typography

```
Font:       Inter (Google Fonts)
Headings:   Bold
Body:       Normal
```

### Components

- Modern card designs
- Smooth animations
- Hover effects
- Loading states
- Empty states
- Error states

---

## 🔌 API Integration

### Base URL

```
http://localhost:8000/api/v1
```

### Authentication

All admin endpoints require JWT token:

```javascript
Authorization: Bearer {token}
```

### Endpoints Used

```
POST   /admin/login
POST   /admin/logout
GET    /admin/me
GET    /admin/appointments
POST   /admin/appointments
GET    /admin/appointments/{id}
PUT    /admin/appointments/{id}
DELETE /admin/appointments/{id}
POST   /admin/appointments/{id}/approve
POST   /admin/appointments/{id}/cancel
POST   /admin/appointments/{id}/complete
GET    /admin/appointments/statistics
```

---

## 🐛 Troubleshooting

### Port Already in Use

Change port in `admin-panel/vite.config.js`:

```javascript
server: {
  port: 3001  // Change to any available port
}
```

### CORS Errors

1. Ensure Laravel API is running
2. Check `config/cors.php` in Laravel
3. Verify allowed origins include `http://localhost:3000`

### Login Not Working

1. Ensure database is seeded:
```bash
cd "d:\Doctor Website\doctor-appointment-api"
php artisan db:seed --class=AdminUserSeeder
```

2. Use correct credentials:
   - Email: admin@hospital.com
   - Password: Admin@123

### API Connection Failed

1. Check Laravel is running: `php artisan serve`
2. Verify API URL in `admin-panel/src/services/api.js`
3. Check browser console for errors

---

## 📅 Roadmap

### Week 1 (Completed) ✅
- Project setup
- Authentication
- Dashboard
- Appointments (partial)

### Week 2 (Current) ⚠️
- Complete Appointments module
- Implement Doctors module
- Implement Services module

### Week 3 (Planned)
- Implement Blogs module
- Start Public Website
- Home page

### Week 4 (Planned)
- Public website pages
- Booking system
- Testing & polish

---

## 🤝 Contributing

### Code Style

- Use Vue.js Composition API
- Follow Tailwind CSS utility-first approach
- Keep components small and focused
- Add proper error handling
- Write clear comments

### File Naming

- Components: PascalCase (e.g., `MyComponent.vue`)
- Services: camelCase (e.g., `myService.js`)
- Views: PascalCase (e.g., `MyView.vue`)

### Commit Messages

```
feat: Add new feature
fix: Fix bug
docs: Update documentation
style: Format code
refactor: Refactor code
test: Add tests
```

---

## 📚 Resources

### Official Documentation

- [Vue.js](https://vuejs.org/)
- [Tailwind CSS](https://tailwindcss.com/)
- [Vite](https://vitejs.dev/)
- [Vue Router](https://router.vuejs.org/)
- [Pinia](https://pinia.vuejs.org/)

### Tutorials

- [Vue.js 3 Tutorial](https://vuejs.org/tutorial/)
- [Tailwind CSS Tutorial](https://tailwindcss.com/docs)
- [Composition API Guide](https://vuejs.org/guide/extras/composition-api-faq.html)

---

## 📄 License

This project is part of the Doctor Appointment System.

---

## 📞 Support

For issues and questions:

1. Check the troubleshooting section
2. Read the documentation
3. Check browser console for errors
4. Verify Laravel API is running

---

## 🎯 Next Steps

1. **Complete Admin Panel**
   - Finish Appointments Edit
   - Implement Doctors CRUD
   - Implement Services CRUD
   - Implement Blogs CRUD

2. **Create Public Website**
   - Set up project
   - Design home page
   - Implement booking system
   - Add blog pages

3. **Testing & Deployment**
   - Test all features
   - Optimize performance
   - Deploy to production

---

**Status:** 🚧 Active Development  
**Version:** 1.0.0  
**Last Updated:** 2025

---

**Built with ❤️ using Vue.js 3 + Tailwind CSS**
