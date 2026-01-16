# 🚀 Frontend Setup Guide - Step by Step

**Project:** Doctor Appointment Admin Panel  
**Technology:** Vue 3 + Vite + Tailwind CSS  
**Time:** 30 minutes setup

---

## 📋 Step-by-Step Instructions

### **Step 1: Create Project Structure** (5 minutes)

Open your terminal and run these commands:

```bash
# Navigate to Doctor Website folder
cd "d:\Doctor Website"

# Create frontend directory (if not exists)
mkdir doctor-appointment-frontend
cd doctor-appointment-frontend

# Create admin panel using Vite
npm create vite@latest admin-panel

# When prompted:
# ✔ Select a framework: › Vue
# ✔ Select a variant: › JavaScript

# Navigate into the project
cd admin-panel

# Install dependencies
npm install
```

---

### **Step 2: Install Required Packages** (5 minutes)

```bash
# Install Tailwind CSS
npm install -D tailwindcss postcss autoprefixer
npx tailwindcss init -p

# Install Vue Router and Pinia
npm install vue-router@4 pinia

# Install Axios for API calls
npm install axios

# Install UI libraries
npm install @headlessui/vue @heroicons/vue

# Install Chart.js for dashboard
npm install chart.js vue-chartjs

# Install form validation
npm install vee-validate yup

# Install notifications
npm install vue-toastification@next

# Install date utilities
npm install dayjs @vuepic/vue-datepicker

# Install rich text editor
npm install @tiptap/vue-3 @tiptap/starter-kit
```

---

### **Step 3: Configure Tailwind CSS** (2 minutes)

**File: `tailwind.config.js`**

Replace the content with:

```javascript
/** @type {import('tailwindcss').Config} */
export default {
  content: [
    "./index.html",
    "./src/**/*.{vue,js,ts,jsx,tsx}",
  ],
  theme: {
    extend: {
      colors: {
        primary: {
          50: '#eff6ff',
          100: '#dbeafe',
          200: '#bfdbfe',
          300: '#93c5fd',
          400: '#60a5fa',
          500: '#3b82f6',
          600: '#2563eb',
          700: '#1d4ed8',
          800: '#1e40af',
          900: '#1e3a8a',
        },
      },
    },
  },
  plugins: [],
}
```

---

### **Step 4: Update CSS** (1 minute)

**File: `src/style.css`**

Replace the content with:

```css
@tailwind base;
@tailwind components;
@tailwind utilities;

@layer base {
  body {
    @apply bg-gray-50 text-gray-900;
  }
}

@layer components {
  .btn-primary {
    @apply bg-primary-600 text-white px-4 py-2 rounded-lg hover:bg-primary-700 transition-colors;
  }
  
  .btn-secondary {
    @apply bg-gray-200 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-300 transition-colors;
  }
  
  .card {
    @apply bg-white rounded-lg shadow-sm p-6;
  }
  
  .input {
    @apply w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent;
  }
}
```

---

### **Step 5: Create Project Structure** (3 minutes)

Create these folders inside `src/`:

```bash
cd src

# Create directories
mkdir components layouts views router stores services utils

# Create subdirectories
mkdir components/common
mkdir components/appointments
mkdir components/doctors
mkdir components/services
mkdir components/blogs
mkdir views/auth
mkdir views/dashboard
mkdir views/appointments
mkdir views/doctors
mkdir views/services
mkdir views/blogs
```

---

### **Step 6: Create Router Configuration** (5 minutes)

**File: `src/router/index.js`**

```javascript
import { createRouter, createWebHistory } from 'vue-router'
import { useAuthStore } from '../stores/auth'

const routes = [
  {
    path: '/login',
    name: 'Login',
    component: () => import('../views/auth/Login.vue'),
    meta: { requiresGuest: true }
  },
  {
    path: '/',
    component: () => import('../layouts/MainLayout.vue'),
    meta: { requiresAuth: true },
    children: [
      {
        path: '',
        name: 'Dashboard',
        component: () => import('../views/dashboard/Dashboard.vue')
      },
      {
        path: 'appointments',
        name: 'Appointments',
        component: () => import('../views/appointments/AppointmentsList.vue')
      },
      {
        path: 'doctors',
        name: 'Doctors',
        component: () => import('../views/doctors/DoctorsList.vue')
      },
      {
        path: 'services',
        name: 'Services',
        component: () => import('../views/services/ServicesList.vue')
      },
      {
        path: 'blogs',
        name: 'Blogs',
        component: () => import('../views/blogs/BlogsList.vue')
      }
    ]
  }
]

const router = createRouter({
  history: createWebHistory(),
  routes
})

// Navigation guard
router.beforeEach((to, from, next) => {
  const authStore = useAuthStore()
  
  if (to.meta.requiresAuth && !authStore.isAuthenticated) {
    next('/login')
  } else if (to.meta.requiresGuest && authStore.isAuthenticated) {
    next('/')
  } else {
    next()
  }
})

export default router
```

---

### **Step 7: Create Pinia Store** (5 minutes)

**File: `src/stores/auth.js`**

```javascript
import { defineStore } from 'pinia'
import axios from 'axios'

export const useAuthStore = defineStore('auth', {
  state: () => ({
    user: null,
    token: localStorage.getItem('token') || null,
  }),
  
  getters: {
    isAuthenticated: (state) => !!state.token,
    currentUser: (state) => state.user,
  },
  
  actions: {
    async login(credentials) {
      try {
        const response = await axios.post('/api/v1/admin/login', credentials)
        this.token = response.data.data.token
        this.user = response.data.data.user
        localStorage.setItem('token', this.token)
        axios.defaults.headers.common['Authorization'] = `Bearer ${this.token}`
        return response.data
      } catch (error) {
        throw error
      }
    },
    
    async logout() {
      try {
        await axios.post('/api/v1/admin/logout')
      } catch (error) {
        console.error('Logout error:', error)
      } finally {
        this.token = null
        this.user = null
        localStorage.removeItem('token')
        delete axios.defaults.headers.common['Authorization']
      }
    },
    
    async fetchUser() {
      try {
        const response = await axios.get('/api/v1/admin/me')
        this.user = response.data.data
      } catch (error) {
        this.logout()
      }
    }
  }
})
```

---

### **Step 8: Configure Axios** (3 minutes)

**File: `src/services/api.js`**

```javascript
import axios from 'axios'
import { useAuthStore } from '../stores/auth'

// Create axios instance
const api = axios.create({
  baseURL: 'http://localhost:8000',
  headers: {
    'Content-Type': 'application/json',
    'Accept': 'application/json'
  }
})

// Request interceptor
api.interceptors.request.use(
  (config) => {
    const token = localStorage.getItem('token')
    if (token) {
      config.headers.Authorization = `Bearer ${token}`
    }
    return config
  },
  (error) => {
    return Promise.reject(error)
  }
)

// Response interceptor
api.interceptors.response.use(
  (response) => response,
  (error) => {
    if (error.response?.status === 401) {
      const authStore = useAuthStore()
      authStore.logout()
      window.location.href = '/login'
    }
    return Promise.reject(error)
  }
)

export default api
```

---

### **Step 9: Update Main.js** (2 minutes)

**File: `src/main.js`**

```javascript
import { createApp } from 'vue'
import { createPinia } from 'pinia'
import router from './router'
import Toast from 'vue-toastification'
import 'vue-toastification/dist/index.css'
import './style.css'
import App from './App.vue'

const app = createApp(App)
const pinia = createPinia()

app.use(pinia)
app.use(router)
app.use(Toast, {
  position: 'top-right',
  timeout: 3000,
  closeOnClick: true,
  pauseOnFocusLoss: true,
  pauseOnHover: true,
  draggable: true,
  draggablePercent: 0.6,
  showCloseButtonOnHover: false,
  hideProgressBar: false,
  closeButton: 'button',
  icon: true,
  rtl: false
})

app.mount('#app')
```

---

### **Step 10: Update App.vue** (1 minute)

**File: `src/App.vue`**

```vue
<template>
  <router-view />
</template>

<script setup>
import { onMounted } from 'vue'
import { useAuthStore } from './stores/auth'

const authStore = useAuthStore()

onMounted(() => {
  if (authStore.isAuthenticated) {
    authStore.fetchUser()
  }
})
</script>
```

---

## ✅ **Verification**

After completing all steps, run:

```bash
npm run dev
```

You should see:
```
  VITE v5.0.11  ready in 500 ms

  ➜  Local:   http://localhost:5173/
  ➜  Network: use --host to expose
```

---

## 🎯 **Next Steps**

Now that the setup is complete, we'll create:

1. ✅ Login Page
2. ✅ Main Layout with Sidebar
3. ✅ Dashboard
4. ✅ Appointments Management
5. ✅ Doctors Management
6. ✅ Services Management
7. ✅ Blogs Management

---

## 📞 **Ready for Next Step?**

Once you've completed this setup, let me know and I'll provide:
- Login page component
- Main layout with sidebar
- Dashboard with charts
- All CRUD components

**Estimated time to complete setup:** 30 minutes

---

**Let me know when you're ready for the next step!** 🚀
