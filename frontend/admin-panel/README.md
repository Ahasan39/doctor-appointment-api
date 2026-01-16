# 🏥 Doctor Appointment - Admin Panel

Modern admin panel built with Vue.js 3, Tailwind CSS, and Vite for managing doctor appointments, doctors, services, and blog posts.

## 🚀 Features

- ✅ **Dashboard** - Statistics, charts, and recent appointments
- ✅ **Appointments Management** - Full CRUD with status management
- ✅ **Doctors Management** - Manage doctor profiles and specializations
- ✅ **Services Management** - Manage medical services
- ✅ **Blogs Management** - Create and publish blog posts
- ✅ **Authentication** - Secure login with JWT tokens
- ✅ **Responsive Design** - Works on all devices
- ✅ **Modern UI** - Clean and professional interface

## 📋 Prerequisites

- Node.js 18+ and npm
- Laravel API backend running on `http://localhost:8000`

## 🛠️ Installation

### Step 1: Install Dependencies

```bash
cd "d:\Doctor Website\doctor-appointment-frontend\admin-panel"
npm install
```

### Step 2: Configure API Endpoint

The API endpoint is configured in `src/services/api.js`. Default is:
```javascript
baseURL: 'http://localhost:8000/api/v1'
```

If your Laravel API runs on a different URL, update this file.

### Step 3: Start Development Server

```bash
npm run dev
```

The admin panel will be available at `http://localhost:3000`

## 🔐 Login Credentials

Default admin credentials (from Laravel seeder):
- **Email:** admin@hospital.com
- **Password:** Admin@123

## 📁 Project Structure

```
admin-panel/
├── public/                 # Static assets
├── src/
│   ├── assets/            # Images, fonts, etc.
│   ├── components/        # Reusable Vue components
│   ├── layouts/           # Layout components
│   │   └── MainLayout.vue # Main admin layout with sidebar
│   ├── views/             # Page components
│   │   ├── Login.vue      # Login page
│   │   ├── Dashboard.vue  # Dashboard with stats
│   │   ├── appointments/  # Appointment views
│   │   ├── doctors/       # Doctor views
│   │   ├── services/      # Service views
│   │   └── blogs/         # Blog views
│   ├── router/            # Vue Router configuration
│   │   └── index.js       # Routes definition
│   ├── stores/            # Pinia stores
│   │   └── auth.js        # Authentication store
│   ├── services/          # API service layer
│   │   ├── api.js         # Axios instance
│   │   ├── authService.js
│   │   ├── appointmentService.js
│   │   ├── doctorService.js
│   │   ├── serviceService.js
│   │   └── blogService.js
│   ├── utils/             # Utility functions
│   ├── App.vue            # Root component
│   ├── main.js            # App entry point
│   └── style.css          # Global styles with Tailwind
├── index.html             # HTML template
├── package.json           # Dependencies
├── vite.config.js         # Vite configuration
├── tailwind.config.js     # Tailwind CSS configuration
└── postcss.config.js      # PostCSS configuration
```

## 🎨 Tech Stack

- **Vue.js 3** - Progressive JavaScript framework
- **Vite** - Next generation frontend tooling
- **Vue Router** - Official router for Vue.js
- **Pinia** - State management
- **Tailwind CSS** - Utility-first CSS framework
- **Axios** - HTTP client
- **Chart.js** - Charts and graphs
- **Day.js** - Date manipulation
- **Vue Toastification** - Toast notifications

## 📝 Available Scripts

```bash
# Start development server
npm run dev

# Build for production
npm run build

# Preview production build
npm run preview
```

## 🔌 API Integration

The admin panel integrates with the Laravel API backend. All API calls are made through service files in `src/services/`.

### Authentication Flow

1. User logs in via `/login`
2. JWT token is stored in localStorage
3. Token is automatically attached to all API requests
4. On 401 error, user is redirected to login

### API Services

- **authService** - Login, logout, get user info
- **appointmentService** - CRUD operations for appointments
- **doctorService** - CRUD operations for doctors
- **serviceService** - CRUD operations for services
- **blogService** - CRUD operations for blogs

## 🎯 Key Features Implemented

### Dashboard
- Statistics cards (total appointments, pending, approved, completed)
- Line chart for appointments overview
- Doughnut chart for status distribution
- Recent appointments table

### Appointments
- List all appointments with filters
- Search by patient name
- Filter by status and date range
- View appointment details
- Approve/Cancel/Complete appointments
- Create new appointments
- Pagination support

### Authentication
- Secure login page
- JWT token management
- Auto-redirect on session expiry
- Remember me functionality

### UI/UX
- Responsive sidebar navigation
- Mobile-friendly design
- Loading states
- Error handling
- Toast notifications
- Smooth transitions

## 🚧 Remaining Work

The following views need to be fully implemented (currently have placeholder content):

### Appointments
- ✅ Index (List) - **COMPLETE**
- ✅ Create - **COMPLETE**
- ✅ View - **COMPLETE**
- ⚠️ Edit - Needs implementation

### Doctors
- ⚠️ Index (List) - Needs implementation
- ⚠️ Create - Needs implementation
- ⚠️ View - Needs implementation
- ⚠️ Edit - Needs implementation

### Services
- ⚠️ Index (List) - Needs implementation
- ⚠️ Create - Needs implementation
- ⚠️ View - Needs implementation
- ⚠️ Edit - Needs implementation

### Blogs
- ⚠️ Index (List) - Needs implementation
- ⚠️ Create - Needs implementation (needs rich text editor)
- ⚠️ View - Needs implementation
- ⚠️ Edit - Needs implementation

## 📖 Implementation Guide

To implement the remaining views, follow the pattern used in `appointments/`:

1. **Index View** - List with filters, search, and pagination
2. **Create View** - Form with validation
3. **View View** - Display details with action buttons
4. **Edit View** - Pre-filled form for editing

Example structure for Doctors Index:

```vue
<template>
  <div class="space-y-6">
    <!-- Header with Add button -->
    <!-- Filters card -->
    <!-- Table with data -->
    <!-- Pagination -->
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import doctorService from '@/services/doctorService'

const doctors = ref([])
const loading = ref(false)

const fetchDoctors = async () => {
  loading.value = true
  try {
    const response = await doctorService.getAll()
    doctors.value = response.data.data
  } finally {
    loading.value = false
  }
}

onMounted(() => {
  fetchDoctors()
})
</script>
```

## 🎨 Styling Guide

### Tailwind Utility Classes

Common classes used throughout the app:

```css
/* Buttons */
.btn - Base button styles
.btn-primary - Primary blue button
.btn-secondary - Gray button
.btn-success - Green button
.btn-danger - Red button

/* Cards */
.card - White card with shadow

/* Forms */
.input - Input field styles
.label - Label styles

/* Badges */
.badge - Base badge
.badge-success - Green badge
.badge-warning - Yellow badge
.badge-danger - Red badge
.badge-info - Blue badge
```

### Color Palette

```
Primary: Blue (#3B82F6)
Secondary: Green (#10B981)
Success: Green (#10B981)
Warning: Yellow (#F59E0B)
Danger: Red (#EF4444)
```

## 🐛 Troubleshooting

### API Connection Issues

If you get CORS errors:
1. Ensure Laravel API is running
2. Check `config/cors.php` in Laravel
3. Verify API URL in `src/services/api.js`

### Build Errors

```bash
# Clear node_modules and reinstall
rm -rf node_modules package-lock.json
npm install
```

### Port Already in Use

```bash
# Change port in vite.config.js
server: {
  port: 3001  // Change to different port
}
```

## 📚 Resources

- [Vue.js Documentation](https://vuejs.org/)
- [Tailwind CSS Documentation](https://tailwindcss.com/)
- [Vite Documentation](https://vitejs.dev/)
- [Vue Router Documentation](https://router.vuejs.org/)
- [Pinia Documentation](https://pinia.vuejs.org/)

## 🤝 Contributing

1. Follow the existing code structure
2. Use Composition API for all components
3. Keep components small and focused
4. Add proper error handling
5. Test all features before committing

## 📄 License

This project is part of the Doctor Appointment System.

---

**Status:** 🚧 In Development  
**Version:** 1.0.0  
**Last Updated:** 2025
