# 🎨 Frontend Integration Guide

**Doctor Appointment API - Complete Frontend Integration Guide**  
**Version:** 1.0  
**Last Updated:** December 30, 2025

---

## 📋 Table of Contents

1. [Overview](#overview)
2. [Getting Started](#getting-started)
3. [React/Next.js Integration](#reactnextjs-integration)
4. [Vue.js Integration](#vuejs-integration)
5. [Angular Integration](#angular-integration)
6. [Vanilla JavaScript](#vanilla-javascript)
7. [Common Use Cases](#common-use-cases)
8. [Error Handling](#error-handling)
9. [Best Practices](#best-practices)

---

## Overview

The Doctor Appointment API provides 21 public endpoints that don't require authentication, making it easy to integrate with any frontend framework.

### Base URL
```
http://localhost:8000/api/v1
```

### Response Format
All responses follow this structure:
```json
{
  "status": "success",
  "message": "Operation successful",
  "data": { ... }
}
```

---

## Getting Started

### Prerequisites
- API server running on `http://localhost:8000`
- CORS configured (if frontend is on different domain)
- Basic understanding of HTTP requests

### Quick Test
```bash
curl http://localhost:8000/api/v1/services
```

---

## React/Next.js Integration

### Setup

#### 1. Install Axios (Recommended)
```bash
npm install axios
```

#### 2. Create API Service (`services/api.js`)
```javascript
import axios from 'axios';

const API_BASE_URL = 'http://localhost:8000/api/v1';

const api = axios.create({
  baseURL: API_BASE_URL,
  headers: {
    'Content-Type': 'application/json',
  },
});

// Response interceptor for error handling
api.interceptors.response.use(
  (response) => response.data,
  (error) => {
    console.error('API Error:', error.response?.data || error.message);
    return Promise.reject(error.response?.data || error);
  }
);

export default api;
```

### Services API

#### Fetch Services
```javascript
// services/serviceService.js
import api from './api';

export const serviceService = {
  // Get all services
  getAll: async (params = {}) => {
    const response = await api.get('/services', { params });
    return response.data;
  },

  // Get featured services
  getFeatured: async () => {
    const response = await api.get('/services/featured');
    return response.data;
  },

  // Get service by slug
  getBySlug: async (slug) => {
    const response = await api.get(`/services/${slug}`);
    return response.data;
  },

  // Search services
  search: async (searchTerm, filters = {}) => {
    const response = await api.get('/services', {
      params: { search: searchTerm, ...filters },
    });
    return response.data;
  },
};
```

#### React Component Example
```jsx
// components/ServiceList.jsx
import React, { useState, useEffect } from 'react';
import { serviceService } from '../services/serviceService';

const ServiceList = () => {
  const [services, setServices] = useState([]);
  const [loading, setLoading] = useState(true);
  const [error, setError] = useState(null);

  useEffect(() => {
    fetchServices();
  }, []);

  const fetchServices = async () => {
    try {
      setLoading(true);
      const data = await serviceService.getAll({ per_page: 12 });
      setServices(data.data);
    } catch (err) {
      setError(err.message);
    } finally {
      setLoading(false);
    }
  };

  if (loading) return <div>Loading services...</div>;
  if (error) return <div>Error: {error}</div>;

  return (
    <div className="service-list">
      <h2>Our Services</h2>
      <div className="grid">
        {services.map((service) => (
          <div key={service.id} className="service-card">
            <h3>{service.name}</h3>
            <p>{service.description}</p>
            <p className="price">${service.price}</p>
            <p className="duration">{service.duration} minutes</p>
          </div>
        ))}
      </div>
    </div>
  );
};

export default ServiceList;
```

### Doctors API

#### Fetch Doctors
```javascript
// services/doctorService.js
import api from './api';

export const doctorService = {
  getAll: async (params = {}) => {
    const response = await api.get('/doctors', { params });
    return response.data;
  },

  getFeatured: async () => {
    const response = await api.get('/doctors/featured');
    return response.data;
  },

  getById: async (id) => {
    const response = await api.get(`/doctors/${id}`);
    return response.data;
  },

  getSpecializations: async () => {
    const response = await api.get('/doctors/specializations');
    return response.data;
  },
};
```

#### React Component Example
```jsx
// components/DoctorProfile.jsx
import React, { useState, useEffect } from 'react';
import { useParams } from 'react-router-dom';
import { doctorService } from '../services/doctorService';

const DoctorProfile = () => {
  const { id } = useParams();
  const [doctor, setDoctor] = useState(null);
  const [loading, setLoading] = useState(true);

  useEffect(() => {
    fetchDoctor();
  }, [id]);

  const fetchDoctor = async () => {
    try {
      const data = await doctorService.getById(id);
      setDoctor(data);
    } catch (err) {
      console.error('Error fetching doctor:', err);
    } finally {
      setLoading(false);
    }
  };

  if (loading) return <div>Loading...</div>;
  if (!doctor) return <div>Doctor not found</div>;

  return (
    <div className="doctor-profile">
      <h1>{doctor.name}</h1>
      <p className="specialization">{doctor.specialization}</p>
      <p className="qualification">{doctor.qualification}</p>
      <p className="bio">{doctor.bio}</p>
      <p className="fee">Consultation Fee: ${doctor.consultation_fee}</p>
    </div>
  );
};

export default DoctorProfile;
```

### Appointment Booking

#### Appointment Service
```javascript
// services/appointmentService.js
import api from './api';

export const appointmentService = {
  // Check available slots
  getAvailableSlots: async (doctorId, date) => {
    const response = await api.get('/appointments/available-slots', {
      params: { doctor_id: doctorId, date },
    });
    return response.data;
  },

  // Book appointment
  book: async (appointmentData) => {
    const response = await api.post('/appointments', appointmentData);
    return response.data;
  },

  // Check status
  checkStatus: async (email, phone) => {
    const response = await api.post('/appointments/check-status', {
      patient_email: email,
      patient_phone: phone,
    });
    return response.data;
  },
};
```

#### Booking Form Component
```jsx
// components/AppointmentBooking.jsx
import React, { useState, useEffect } from 'react';
import { appointmentService } from '../services/appointmentService';
import { doctorService } from '../services/doctorService';
import { serviceService } from '../services/serviceService';

const AppointmentBooking = () => {
  const [formData, setFormData] = useState({
    patient_name: '',
    patient_email: '',
    patient_phone: '',
    doctor_id: '',
    service_id: '',
    appointment_date: '',
    appointment_time: '',
    notes: '',
  });

  const [doctors, setDoctors] = useState([]);
  const [services, setServices] = useState([]);
  const [availableSlots, setAvailableSlots] = useState([]);
  const [loading, setLoading] = useState(false);
  const [success, setSuccess] = useState(false);

  useEffect(() => {
    fetchDoctors();
    fetchServices();
  }, []);

  useEffect(() => {
    if (formData.doctor_id && formData.appointment_date) {
      fetchAvailableSlots();
    }
  }, [formData.doctor_id, formData.appointment_date]);

  const fetchDoctors = async () => {
    const data = await doctorService.getAll();
    setDoctors(data.data);
  };

  const fetchServices = async () => {
    const data = await serviceService.getAll();
    setServices(data.data);
  };

  const fetchAvailableSlots = async () => {
    try {
      const data = await appointmentService.getAvailableSlots(
        formData.doctor_id,
        formData.appointment_date
      );
      setAvailableSlots(data.slots);
    } catch (err) {
      console.error('Error fetching slots:', err);
    }
  };

  const handleSubmit = async (e) => {
    e.preventDefault();
    setLoading(true);

    try {
      await appointmentService.book(formData);
      setSuccess(true);
      // Reset form
      setFormData({
        patient_name: '',
        patient_email: '',
        patient_phone: '',
        doctor_id: '',
        service_id: '',
        appointment_date: '',
        appointment_time: '',
        notes: '',
      });
    } catch (err) {
      alert('Error booking appointment: ' + err.message);
    } finally {
      setLoading(false);
    }
  };

  const handleChange = (e) => {
    setFormData({
      ...formData,
      [e.target.name]: e.target.value,
    });
  };

  if (success) {
    return (
      <div className="success-message">
        <h2>Appointment Booked Successfully!</h2>
        <p>You will receive a confirmation email shortly.</p>
        <button onClick={() => setSuccess(false)}>Book Another</button>
      </div>
    );
  }

  return (
    <form onSubmit={handleSubmit} className="appointment-form">
      <h2>Book an Appointment</h2>

      <input
        type="text"
        name="patient_name"
        placeholder="Your Name"
        value={formData.patient_name}
        onChange={handleChange}
        required
      />

      <input
        type="email"
        name="patient_email"
        placeholder="Your Email"
        value={formData.patient_email}
        onChange={handleChange}
        required
      />

      <input
        type="tel"
        name="patient_phone"
        placeholder="Your Phone"
        value={formData.patient_phone}
        onChange={handleChange}
        required
      />

      <select
        name="doctor_id"
        value={formData.doctor_id}
        onChange={handleChange}
        required
      >
        <option value="">Select Doctor</option>
        {doctors.map((doctor) => (
          <option key={doctor.id} value={doctor.id}>
            {doctor.name} - {doctor.specialization}
          </option>
        ))}
      </select>

      <select
        name="service_id"
        value={formData.service_id}
        onChange={handleChange}
      >
        <option value="">Select Service (Optional)</option>
        {services.map((service) => (
          <option key={service.id} value={service.id}>
            {service.name} - ${service.price}
          </option>
        ))}
      </select>

      <input
        type="date"
        name="appointment_date"
        value={formData.appointment_date}
        onChange={handleChange}
        min={new Date().toISOString().split('T')[0]}
        required
      />

      {availableSlots.length > 0 && (
        <select
          name="appointment_time"
          value={formData.appointment_time}
          onChange={handleChange}
          required
        >
          <option value="">Select Time</option>
          {availableSlots
            .filter((slot) => slot.available)
            .map((slot) => (
              <option key={slot.time} value={slot.time}>
                {slot.time}
              </option>
            ))}
        </select>
      )}

      <textarea
        name="notes"
        placeholder="Additional Notes (Optional)"
        value={formData.notes}
        onChange={handleChange}
        rows="4"
      />

      <button type="submit" disabled={loading}>
        {loading ? 'Booking...' : 'Book Appointment'}
      </button>
    </form>
  );
};

export default AppointmentBooking;
```

---

## Vue.js Integration

### Setup

#### Install Axios
```bash
npm install axios
```

#### Create API Service (`services/api.js`)
```javascript
import axios from 'axios';

const apiClient = axios.create({
  baseURL: 'http://localhost:8000/api/v1',
  headers: {
    'Content-Type': 'application/json',
  },
});

export default {
  // Services
  getServices(params) {
    return apiClient.get('/services', { params });
  },
  getServiceBySlug(slug) {
    return apiClient.get(`/services/${slug}`);
  },

  // Doctors
  getDoctors(params) {
    return apiClient.get('/doctors', { params });
  },
  getDoctorById(id) {
    return apiClient.get(`/doctors/${id}`);
  },

  // Blogs
  getBlogs(params) {
    return apiClient.get('/blogs', { params });
  },
  getBlogBySlug(slug) {
    return apiClient.get(`/blogs/${slug}`);
  },

  // Appointments
  getAvailableSlots(doctorId, date) {
    return apiClient.get('/appointments/available-slots', {
      params: { doctor_id: doctorId, date },
    });
  },
  bookAppointment(data) {
    return apiClient.post('/appointments', data);
  },

  // Contact
  submitContact(data) {
    return apiClient.post('/contact', data);
  },
};
```

#### Vue Component Example
```vue
<!-- components/ServiceList.vue -->
<template>
  <div class="service-list">
    <h2>Our Services</h2>
    
    <div v-if="loading">Loading services...</div>
    <div v-else-if="error">Error: {{ error }}</div>
    
    <div v-else class="grid">
      <div
        v-for="service in services"
        :key="service.id"
        class="service-card"
      >
        <h3>{{ service.name }}</h3>
        <p>{{ service.description }}</p>
        <p class="price">${{ service.price }}</p>
        <p class="duration">{{ service.duration }} minutes</p>
      </div>
    </div>
  </div>
</template>

<script>
import api from '../services/api';

export default {
  name: 'ServiceList',
  data() {
    return {
      services: [],
      loading: true,
      error: null,
    };
  },
  async mounted() {
    await this.fetchServices();
  },
  methods: {
    async fetchServices() {
      try {
        this.loading = true;
        const response = await api.getServices({ per_page: 12 });
        this.services = response.data.data.data;
      } catch (err) {
        this.error = err.message;
      } finally {
        this.loading = false;
      }
    },
  },
};
</script>
```

---

## Angular Integration

### Setup

#### Create API Service
```typescript
// services/api.service.ts
import { Injectable } from '@angular/core';
import { HttpClient, HttpParams } from '@angular/common/http';
import { Observable } from 'rxjs';
import { map } from 'rxjs/operators';

@Injectable({
  providedIn: 'root'
})
export class ApiService {
  private baseUrl = 'http://localhost:8000/api/v1';

  constructor(private http: HttpClient) {}

  // Services
  getServices(params?: any): Observable<any> {
    let httpParams = new HttpParams();
    if (params) {
      Object.keys(params).forEach(key => {
        httpParams = httpParams.set(key, params[key]);
      });
    }
    return this.http.get(`${this.baseUrl}/services`, { params: httpParams })
      .pipe(map((response: any) => response.data));
  }

  getServiceBySlug(slug: string): Observable<any> {
    return this.http.get(`${this.baseUrl}/services/${slug}`)
      .pipe(map((response: any) => response.data));
  }

  // Doctors
  getDoctors(params?: any): Observable<any> {
    let httpParams = new HttpParams();
    if (params) {
      Object.keys(params).forEach(key => {
        httpParams = httpParams.set(key, params[key]);
      });
    }
    return this.http.get(`${this.baseUrl}/doctors`, { params: httpParams })
      .pipe(map((response: any) => response.data));
  }

  // Appointments
  bookAppointment(data: any): Observable<any> {
    return this.http.post(`${this.baseUrl}/appointments`, data)
      .pipe(map((response: any) => response.data));
  }
}
```

#### Component Example
```typescript
// components/service-list/service-list.component.ts
import { Component, OnInit } from '@angular/core';
import { ApiService } from '../../services/api.service';

@Component({
  selector: 'app-service-list',
  templateUrl: './service-list.component.html',
  styleUrls: ['./service-list.component.css']
})
export class ServiceListComponent implements OnInit {
  services: any[] = [];
  loading = true;
  error: string | null = null;

  constructor(private apiService: ApiService) {}

  ngOnInit(): void {
    this.fetchServices();
  }

  fetchServices(): void {
    this.apiService.getServices({ per_page: 12 }).subscribe({
      next: (data) => {
        this.services = data.data;
        this.loading = false;
      },
      error: (err) => {
        this.error = err.message;
        this.loading = false;
      }
    });
  }
}
```

---

## Vanilla JavaScript

### Fetch API Example
```javascript
// Fetch services
async function fetchServices() {
  try {
    const response = await fetch('http://localhost:8000/api/v1/services');
    const data = await response.json();
    
    if (data.status === 'success') {
      displayServices(data.data.data);
    }
  } catch (error) {
    console.error('Error:', error);
  }
}

function displayServices(services) {
  const container = document.getElementById('services-container');
  container.innerHTML = services.map(service => `
    <div class="service-card">
      <h3>${service.name}</h3>
      <p>${service.description}</p>
      <p class="price">$${service.price}</p>
    </div>
  `).join('');
}

// Book appointment
async function bookAppointment(formData) {
  try {
    const response = await fetch('http://localhost:8000/api/v1/appointments', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
      },
      body: JSON.stringify(formData),
    });
    
    const data = await response.json();
    
    if (data.status === 'success') {
      alert('Appointment booked successfully!');
    } else {
      alert('Error: ' + data.message);
    }
  } catch (error) {
    console.error('Error:', error);
    alert('Failed to book appointment');
  }
}
```

---

## Common Use Cases

### 1. Search with Filters
```javascript
const searchServices = async (searchTerm, filters) => {
  const params = new URLSearchParams({
    search: searchTerm,
    ...filters,
  });
  
  const response = await fetch(
    `http://localhost:8000/api/v1/services?${params}`
  );
  return await response.json();
};

// Usage
const results = await searchServices('consultation', {
  min_price: 50,
  max_price: 200,
  sort_by: 'price',
  sort_order: 'asc',
});
```

### 2. Pagination
```javascript
const fetchServicesPage = async (page = 1, perPage = 10) => {
  const response = await fetch(
    `http://localhost:8000/api/v1/services?page=${page}&per_page=${perPage}`
  );
  const data = await response.json();
  
  return {
    services: data.data.data,
    currentPage: data.data.current_page,
    totalPages: data.data.last_page,
    total: data.data.total,
  };
};
```

### 3. Check Appointment Availability
```javascript
const checkAvailability = async (doctorId, date) => {
  const response = await fetch(
    `http://localhost:8000/api/v1/appointments/available-slots?doctor_id=${doctorId}&date=${date}`
  );
  const data = await response.json();
  
  return data.data.slots.filter(slot => slot.available);
};
```

---

## Error Handling

### Centralized Error Handler
```javascript
const handleApiError = (error) => {
  if (error.response) {
    // Server responded with error
    const { status, data } = error.response;
    
    switch (status) {
      case 404:
        return 'Resource not found';
      case 422:
        return data.errors || 'Validation failed';
      case 409:
        return data.message || 'Conflict occurred';
      default:
        return data.message || 'An error occurred';
    }
  } else if (error.request) {
    // Request made but no response
    return 'No response from server';
  } else {
    // Error in request setup
    return error.message;
  }
};
```

---

## Best Practices

### 1. Environment Variables
```javascript
// .env
REACT_APP_API_URL=http://localhost:8000/api/v1

// Usage
const API_URL = process.env.REACT_APP_API_URL;
```

### 2. Request Caching
```javascript
const cache = new Map();

const fetchWithCache = async (url, ttl = 60000) => {
  const cached = cache.get(url);
  
  if (cached && Date.now() - cached.timestamp < ttl) {
    return cached.data;
  }
  
  const response = await fetch(url);
  const data = await response.json();
  
  cache.set(url, {
    data,
    timestamp: Date.now(),
  });
  
  return data;
};
```

### 3. Loading States
```javascript
const [state, setState] = useState({
  data: null,
  loading: true,
  error: null,
});

// Update states appropriately
setState({ data: result, loading: false, error: null });
```

### 4. Debounced Search
```javascript
import { debounce } from 'lodash';

const debouncedSearch = debounce(async (searchTerm) => {
  const results = await searchServices(searchTerm);
  setSearchResults(results);
}, 300);
```

---

## 🎉 You're Ready!

Your frontend is now ready to integrate with the Doctor Appointment API. Use the examples above as a starting point and customize them to fit your needs.

### Next Steps:
1. Set up CORS on the backend
2. Implement authentication for admin features
3. Add loading states and error handling
4. Optimize with caching and debouncing
5. Test thoroughly before production

---

**Happy Coding!** 🚀
