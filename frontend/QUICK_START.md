# ⚡ Quick Start Guide

Get the Doctor Appointment Frontend up and running in 5 minutes!

## 🚀 Super Quick Start

### Step 1: Install Admin Panel Dependencies

```bash
cd "d:\Doctor Website\doctor-appointment-frontend\admin-panel"
npm install
```

**Wait for installation to complete (~2-3 minutes)**

### Step 2: Start Admin Panel

```bash
npm run dev
```

### Step 3: Start Laravel API (in another terminal)

```bash
cd "d:\Doctor Website\doctor-appointment-api"
php artisan serve
```

### Step 4: Open Browser

Navigate to: **http://localhost:3000**

### Step 5: Login

- **Email:** admin@hospital.com
- **Password:** Admin@123

**That's it! You're ready to go! 🎉**

---

## 📋 What You Can Do Now

### ✅ Working Features

1. **Dashboard**
   - View statistics
   - See charts
   - View recent appointments

2. **Appointments**
   - View all appointments
   - Filter by status and date
   - Search by patient name
   - Create new appointment
   - View appointment details
   - Approve/Cancel/Complete appointments
   - Delete appointments

3. **Authentication**
   - Login
   - Logout
   - Session management

---

## ⚠️ Not Yet Implemented

- Doctors management (all views)
- Services management (all views)
- Blogs management (all views)
- Public website

---

## 🐛 Troubleshooting

### Port 3000 Already in Use?

Edit `vite.config.js` and change the port:

```javascript
server: {
  port: 3001  // Change to any available port
}
```

### API Not Connecting?

1. Make sure Laravel is running: `php artisan serve`
2. Check API URL in `src/services/api.js`
3. Verify CORS settings in Laravel

### Login Not Working?

1. Ensure database is seeded:
```bash
cd "d:\Doctor Website\doctor-appointment-api"
php artisan db:seed --class=AdminUserSeeder
```

2. Use correct credentials:
   - Email: admin@hospital.com
   - Password: Admin@123

---

## 📚 Next Steps

1. Read the full [SETUP_GUIDE.md](./SETUP_GUIDE.md)
2. Check [PROJECT_STATUS.md](./PROJECT_STATUS.md) for progress
3. Read [admin-panel/README.md](./admin-panel/README.md) for details

---

## 🎯 Development Commands

```bash
# Start development server
npm run dev

# Build for production
npm run build

# Preview production build
npm run preview
```

---

## 📞 Need Help?

Check the troubleshooting sections in:
- [SETUP_GUIDE.md](./SETUP_GUIDE.md)
- [admin-panel/README.md](./admin-panel/README.md)

---

**Happy Coding! 🚀**
