# 🚀 Doctor Appointment Frontend - Complete Setup Guide

This guide will help you set up and run both the **Admin Panel** and **Public Website** for the Doctor Appointment System.

## 📋 Table of Contents

1. [Prerequisites](#prerequisites)
2. [Project Structure](#project-structure)
3. [Admin Panel Setup](#admin-panel-setup)
4. [Public Website Setup](#public-website-setup)
5. [Running the Applications](#running-the-applications)
6. [Development Workflow](#development-workflow)
7. [Troubleshooting](#troubleshooting)

---

## Prerequisites

Before you begin, ensure you have the following installed:

- **Node.js** 18.x or higher ([Download](https://nodejs.org/))
- **npm** 9.x or higher (comes with Node.js)
- **Laravel API** running on `http://localhost:8000`
- **Git** (optional, for version control)

### Verify Installation

```bash
node --version  # Should be v18.x or higher
npm --version   # Should be 9.x or higher
```

---

## Project Structure

```
doctor-appointment-frontend/
├── admin-panel/              # Admin Panel (Vue.js + Tailwind)
│   ├── src/
│   ├── public/
│   ├── package.json
│   └── README.md
│
├── public-website/           # Public Website (To be created)
│   ├── src/
│   ├── public/
│   ├── package.json
│   └── README.md
│
└── SETUP_GUIDE.md           # This file
```

---

## Admin Panel Setup

### Step 1: Navigate to Admin Panel Directory

```bash
cd "d:\Doctor Website\doctor-appointment-frontend\admin-panel"
```

### Step 2: Install Dependencies

```bash
npm install
```

This will install all required packages:
- Vue.js 3
- Vue Router
- Pinia (state management)
- Tailwind CSS
- Axios
- Chart.js
- And more...

**Installation time:** ~2-3 minutes (depending on internet speed)

### Step 3: Verify Installation

Check if `node_modules` folder was created:

```bash
dir node_modules  # Windows
ls node_modules   # Mac/Linux
```

### Step 4: Configure API Endpoint (Optional)

If your Laravel API is running on a different URL, update `src/services/api.js`:

```javascript
const api = axios.create({
  baseURL: 'http://localhost:8000/api/v1',  // Change this if needed
  // ...
})
```

### Step 5: Start Development Server

```bash
npm run dev
```

You should see output like:

```
  VITE v5.1.4  ready in 500 ms

  ➜  Local:   http://localhost:3000/
  ➜  Network: use --host to expose
  ➜  press h to show help
```

### Step 6: Access Admin Panel

Open your browser and navigate to:
```
http://localhost:3000
```

You should see the login page.

### Step 7: Login

Use the default admin credentials:
- **Email:** admin@hospital.com
- **Password:** Admin@123

---

## Public Website Setup

### Step 1: Create Public Website Project

```bash
cd "d:\Doctor Website\doctor-appointment-frontend"
npm create vite@latest public-website -- --template vue
```

### Step 2: Navigate to Public Website Directory

```bash
cd public-website
```

### Step 3: Install Dependencies

```bash
npm install
```

### Step 4: Install Additional Packages

```bash
# Install Tailwind CSS
npm install -D tailwindcss postcss autoprefixer
npx tailwindcss init -p

# Install other dependencies
npm install vue-router pinia axios @headlessui/vue @heroicons/vue
npm install vee-validate yup vue-toastification dayjs swiper
```

### Step 5: Configure Tailwind CSS

Create `tailwind.config.js`:

```javascript
/** @type {import('tailwindcss').Config} */
export default {
  content: [
    "./index.html",
    "./src/**/*.{vue,js,ts,jsx,tsx}",
  ],
  theme: {
    extend: {},
  },
  plugins: [],
}
```

### Step 6: Update `src/style.css`

```css
@tailwind base;
@tailwind components;
@tailwind utilities;
```

### Step 7: Start Development Server

```bash
npm run dev
```

The public website will run on `http://localhost:5173` (or another port if 5173 is taken).

---

## Running the Applications

### Running Both Applications Simultaneously

You'll need **two terminal windows**:

**Terminal 1 - Admin Panel:**
```bash
cd "d:\Doctor Website\doctor-appointment-frontend\admin-panel"
npm run dev
```

**Terminal 2 - Public Website:**
```bash
cd "d:\Doctor Website\doctor-appointment-frontend\public-website"
npm run dev
```

**Terminal 3 - Laravel API (if not already running):**
```bash
cd "d:\Doctor Website\doctor-appointment-api"
php artisan serve
```

### URLs

- **Laravel API:** http://localhost:8000
- **Admin Panel:** http://localhost:3000
- **Public Website:** http://localhost:5173

---

## Development Workflow

### 1. Making Changes

All changes are automatically hot-reloaded. Just save your files and the browser will update.

### 2. Adding New Components

```bash
# Create a new component
# Example: src/components/MyComponent.vue
```

```vue
<template>
  <div>
    <!-- Your template -->
  </div>
</template>

<script setup>
// Your logic
</script>
```

### 3. Adding New Routes

Edit `src/router/index.js`:

```javascript
{
  path: '/my-route',
  name: 'MyRoute',
  component: () => import('@/views/MyView.vue')
}
```

### 4. Adding New API Services

Create a new service file in `src/services/`:

```javascript
import api from './api'

export default {
  async getAll() {
    const response = await api.get('/my-endpoint')
    return response.data
  }
}
```

### 5. Building for Production

```bash
npm run build
```

This creates a `dist` folder with optimized production files.

---

## Troubleshooting

### Issue: Port Already in Use

**Error:** `Port 3000 is already in use`

**Solution:** Change the port in `vite.config.js`:

```javascript
export default defineConfig({
  server: {
    port: 3001  // Change to any available port
  }
})
```

### Issue: CORS Errors

**Error:** `Access to XMLHttpRequest has been blocked by CORS policy`

**Solution:** 

1. Check Laravel API is running
2. Verify `config/cors.php` in Laravel:

```php
'paths' => ['api/*'],
'allowed_origins' => ['http://localhost:3000', 'http://localhost:5173'],
```

3. Restart Laravel server:

```bash
php artisan serve
```

### Issue: Module Not Found

**Error:** `Cannot find module '@/components/...'`

**Solution:**

1. Check the file path is correct
2. Ensure the file exists
3. Restart the dev server:

```bash
# Press Ctrl+C to stop
npm run dev
```

### Issue: Tailwind Styles Not Working

**Solution:**

1. Ensure `tailwind.config.js` exists
2. Check `src/style.css` has Tailwind directives
3. Restart dev server

### Issue: API Requests Failing

**Solution:**

1. Check Laravel API is running: `http://localhost:8000/api/v1/health`
2. Check API URL in `src/services/api.js`
3. Check browser console for errors
4. Verify authentication token (if required)

### Issue: Login Not Working

**Solution:**

1. Ensure Laravel API is running
2. Check database is seeded with admin user:

```bash
cd "d:\Doctor Website\doctor-appointment-api"
php artisan db:seed --class=AdminUserSeeder
```

3. Verify credentials:
   - Email: admin@hospital.com
   - Password: Admin@123

### Issue: npm install Fails

**Solution:**

1. Clear npm cache:

```bash
npm cache clean --force
```

2. Delete `node_modules` and `package-lock.json`:

```bash
rm -rf node_modules package-lock.json  # Mac/Linux
rmdir /s node_modules & del package-lock.json  # Windows
```

3. Reinstall:

```bash
npm install
```

---

## Quick Start Commands

### First Time Setup

```bash
# 1. Install Admin Panel
cd "d:\Doctor Website\doctor-appointment-frontend\admin-panel"
npm install
npm run dev

# 2. In a new terminal, start Laravel API
cd "d:\Doctor Website\doctor-appointment-api"
php artisan serve

# 3. Access admin panel
# Open browser: http://localhost:3000
# Login: admin@hospital.com / Admin@123
```

### Daily Development

```bash
# Terminal 1 - Laravel API
cd "d:\Doctor Website\doctor-appointment-api"
php artisan serve

# Terminal 2 - Admin Panel
cd "d:\Doctor Website\doctor-appointment-frontend\admin-panel"
npm run dev

# Terminal 3 - Public Website (when ready)
cd "d:\Doctor Website\doctor-appointment-frontend\public-website"
npm run dev
```

---

## Next Steps

### Admin Panel

1. ✅ Login page - **COMPLETE**
2. ✅ Dashboard - **COMPLETE**
3. ✅ Appointments (List, Create, View) - **COMPLETE**
4. ⚠️ Appointments (Edit) - **TODO**
5. ⚠️ Doctors (All views) - **TODO**
6. ⚠️ Services (All views) - **TODO**
7. ⚠️ Blogs (All views) - **TODO**

### Public Website

1. ⚠️ Home page - **TODO**
2. ⚠️ Doctors listing - **TODO**
3. ⚠️ Services listing - **TODO**
4. ⚠️ Appointment booking - **TODO**
5. ⚠️ Blog listing - **TODO**
6. ⚠️ Contact page - **TODO**

---

## Useful Commands

```bash
# Install dependencies
npm install

# Start development server
npm run dev

# Build for production
npm run build

# Preview production build
npm run preview

# Check for outdated packages
npm outdated

# Update packages
npm update

# Clear cache
npm cache clean --force
```

---

## Resources

- **Vue.js Docs:** https://vuejs.org/
- **Tailwind CSS Docs:** https://tailwindcss.com/
- **Vite Docs:** https://vitejs.dev/
- **Vue Router Docs:** https://router.vuejs.org/
- **Pinia Docs:** https://pinia.vuejs.org/

---

## Support

If you encounter any issues:

1. Check this troubleshooting guide
2. Check browser console for errors
3. Check terminal for error messages
4. Verify all prerequisites are installed
5. Ensure Laravel API is running

---

**Happy Coding! 🚀**
