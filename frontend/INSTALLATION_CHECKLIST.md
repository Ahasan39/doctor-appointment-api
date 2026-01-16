# ✅ Installation Checklist

Quick checklist to get the Doctor Appointment Admin Panel running.

---

## 📋 Pre-Installation

### ✅ Prerequisites Check

- [ ] Node.js 18+ installed (`node --version`)
- [ ] npm 9+ installed (`npm --version`)
- [ ] Laravel API running on http://localhost:8000
- [ ] Database seeded with admin user

---

## 🚀 Installation Steps

### Step 1: Navigate to Project

```bash
cd "d:\Doctor Website\doctor-appointment-frontend\admin-panel"
```

- [ ] Navigated to admin-panel directory

### Step 2: Install Dependencies

```bash
npm install
```

**Wait time:** ~2-3 minutes

- [ ] Dependencies installed successfully
- [ ] No error messages
- [ ] `node_modules` folder created

### Step 3: Verify Configuration

Check `src/services/api.js`:
```javascript
baseURL: 'http://localhost:8000/api/v1'
```

- [ ] API URL is correct
- [ ] Matches your Laravel API URL

### Step 4: Start Development Server

```bash
npm run dev
```

**Expected output:**
```
VITE v5.1.4  ready in 500 ms
➜  Local:   http://localhost:3000/
```

- [ ] Server started successfully
- [ ] No error messages
- [ ] URL displayed in terminal

### Step 5: Start Laravel API

In a **new terminal**:

```bash
cd "d:\Doctor Website\doctor-appointment-api"
php artisan serve
```

**Expected output:**
```
Starting Laravel development server: http://127.0.0.1:8000
```

- [ ] Laravel server started
- [ ] Running on port 8000
- [ ] No error messages

### Step 6: Access Admin Panel

Open browser and navigate to:
```
http://localhost:3000
```

- [ ] Login page loads
- [ ] No console errors (F12 → Console)
- [ ] Page looks correct

### Step 7: Login

Use credentials:
- **Email:** admin@hospital.com
- **Password:** Admin@123

- [ ] Login successful
- [ ] Redirected to dashboard
- [ ] Dashboard loads with data

---

## ✅ Verification Tests

### Test 1: Dashboard

- [ ] Statistics cards show numbers
- [ ] Charts are visible
- [ ] Recent appointments table loads
- [ ] No errors in console

### Test 2: Appointments

Click "Appointments" in sidebar:

- [ ] Appointments list loads
- [ ] Can search appointments
- [ ] Can filter by status
- [ ] Pagination works

### Test 3: Create Appointment

Click "New Appointment":

- [ ] Form loads
- [ ] Doctors dropdown populated
- [ ] Services dropdown populated
- [ ] Can submit form

### Test 4: View Appointment

Click "View" on any appointment:

- [ ] Details page loads
- [ ] All information displayed
- [ ] Action buttons visible

### Test 5: Responsive Design

Resize browser window:

- [ ] Sidebar collapses on mobile
- [ ] Mobile menu works
- [ ] Tables are scrollable
- [ ] Forms are usable

---

## 🐛 Troubleshooting

### Issue: npm install fails

**Try:**
```bash
npm cache clean --force
rm -rf node_modules package-lock.json
npm install
```

- [ ] Tried clearing cache
- [ ] Reinstalled successfully

### Issue: Port 3000 in use

**Solution:** Edit `vite.config.js`:
```javascript
server: {
  port: 3001  // Change to any available port
}
```

- [ ] Changed port
- [ ] Server starts on new port

### Issue: CORS errors

**Check:**
1. Laravel API is running
2. `config/cors.php` in Laravel:
```php
'allowed_origins' => ['http://localhost:3000']
```

- [ ] Laravel API running
- [ ] CORS configured
- [ ] Restarted Laravel server

### Issue: Login fails

**Solution:** Seed database:
```bash
cd "d:\Doctor Website\doctor-appointment-api"
php artisan db:seed --class=AdminUserSeeder
```

- [ ] Database seeded
- [ ] Can login now

### Issue: White screen

**Check:**
1. Browser console (F12 → Console)
2. Terminal for errors
3. Laravel API is running

- [ ] Checked console
- [ ] Checked terminal
- [ ] API is running

---

## 📊 Success Criteria

### ✅ Installation Successful If:

- [ ] Admin panel loads at http://localhost:3000
- [ ] Can login with admin credentials
- [ ] Dashboard shows data
- [ ] Can navigate between pages
- [ ] No console errors
- [ ] API calls work

---

## 🎯 Next Steps

After successful installation:

1. [ ] Read `QUICK_START.md`
2. [ ] Explore the admin panel
3. [ ] Try creating an appointment
4. [ ] Read `admin-panel/README.md`
5. [ ] Start implementing remaining features

---

## 📞 Need Help?

If you encounter issues:

1. **Check Documentation:**
   - `QUICK_START.md`
   - `SETUP_GUIDE.md`
   - `admin-panel/README.md`

2. **Check Logs:**
   - Browser console (F12)
   - Terminal output
   - Laravel logs

3. **Verify:**
   - Node.js version
   - npm version
   - Laravel API running
   - Database seeded

---

## ✅ Installation Complete!

If all checkboxes are checked, you're ready to go! 🎉

**Access your admin panel at:** http://localhost:3000  
**Login with:** admin@hospital.com / Admin@123

---

**Happy Coding! 🚀**
