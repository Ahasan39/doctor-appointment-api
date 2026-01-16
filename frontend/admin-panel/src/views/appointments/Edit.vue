<template>
  <div class="max-w-3xl">
    <div class="mb-6">
      <router-link to="/appointments" class="text-sm text-gray-500 hover:text-gray-700 flex items-center">
        <svg class="h-4 w-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
        </svg>
        Back to Appointments
      </router-link>
      <h2 class="mt-2 text-2xl font-bold text-gray-900">Edit Appointment</h2>
    </div>

    <div v-if="loading" class="card text-center py-12">
      <div class="inline-block animate-spin rounded-full h-8 w-8 border-b-2 border-primary-600"></div>
      <p class="mt-2 text-sm text-gray-500">Loading...</p>
    </div>

    <div v-else-if="form.patient_name" class="card">
      <form @submit.prevent="handleSubmit" class="space-y-6">
        <!-- Patient Information -->
        <div>
          <h3 class="text-lg font-semibold text-gray-900 mb-4">Patient Information</h3>
          <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
            <div>
              <label class="label">Patient Name *</label>
              <input
                v-model="form.patient_name"
                type="text"
                required
                class="input"
                placeholder="John Doe"
              />
            </div>
            <div>
              <label class="label">Email *</label>
              <input
                v-model="form.patient_email"
                type="email"
                required
                class="input"
                placeholder="john@example.com"
              />
            </div>
            <div>
              <label class="label">Phone *</label>
              <input
                v-model="form.patient_phone"
                type="tel"
                required
                class="input"
                placeholder="+1234567890"
              />
            </div>
            <div>
              <label class="label">Age</label>
              <input
                v-model="form.patient_age"
                type="number"
                class="input"
                placeholder="30"
              />
            </div>
          </div>
        </div>

        <!-- Appointment Details -->
        <div>
          <h3 class="text-lg font-semibold text-gray-900 mb-4">Appointment Details</h3>
          <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
            <div>
              <label class="label">Doctor *</label>
              <select v-model="form.doctor_id" required class="input">
                <option value="">Select Doctor</option>
                <option v-for="doctor in doctors" :key="doctor.id" :value="doctor.id">
                  {{ doctor.name }} - {{ doctor.specialization }}
                </option>
              </select>
            </div>
            <div>
              <label class="label">Service *</label>
              <select v-model="form.service_id" required class="input">
                <option value="">Select Service</option>
                <option v-for="service in services" :key="service.id" :value="service.id">
                  {{ service.name }}
                </option>
              </select>
            </div>
            <div>
              <label class="label">Date *</label>
              <input
                v-model="form.appointment_date"
                type="date"
                required
                class="input"
                :min="minDate"
              />
            </div>
            <div>
              <label class="label">Time *</label>
              <input
                v-model="form.appointment_time"
                type="time"
                required
                class="input"
              />
            </div>
          </div>
        </div>

        <!-- Notes -->
        <div>
          <label class="label">Notes</label>
          <textarea
            v-model="form.notes"
            rows="4"
            class="input"
            placeholder="Additional notes or symptoms..."
          ></textarea>
        </div>

        <!-- Actions -->
        <div class="flex justify-end space-x-4">
          <router-link to="/appointments" class="btn btn-secondary">
            Cancel
          </router-link>
          <button type="submit" :disabled="submitting" class="btn btn-primary">
            <span v-if="!submitting">Update Appointment</span>
            <span v-else>Updating...</span>
          </button>
        </div>
      </form>
    </div>
  </div>
</template>

<script setup>
import { ref, reactive, onMounted } from 'vue'
import { useRoute, useRouter } from 'vue-router'
import appointmentService from '@/services/appointmentService'
import doctorService from '@/services/doctorService'
import serviceService from '@/services/serviceService'
import { useToast } from 'vue-toastification'
import dayjs from 'dayjs'

const route = useRoute()
const router = useRouter()
const toast = useToast()
const loading = ref(true)
const submitting = ref(false)
const doctors = ref([])
const services = ref([])

const minDate = dayjs().format('YYYY-MM-DD')

const form = reactive({
  patient_name: '',
  patient_email: '',
  patient_phone: '',
  patient_age: '',
  doctor_id: '',
  service_id: '',
  appointment_date: '',
  appointment_time: '',
  notes: ''
})

const fetchAppointment = async () => {
  loading.value = true
  try {
    const response = await appointmentService.getById(route.params.id)
    const appointment = response.data
    
    // Pre-fill form with existing data
    form.patient_name = appointment.patient_name
    form.patient_email = appointment.patient_email
    form.patient_phone = appointment.patient_phone
    form.patient_age = appointment.patient_age || ''
    form.doctor_id = appointment.doctor_id
    form.service_id = appointment.service_id
    form.appointment_date = appointment.appointment_date
    form.appointment_time = appointment.appointment_time
    form.notes = appointment.notes || ''
  } catch (error) {
    console.error('Error fetching appointment:', error)
    toast.error('Failed to load appointment')
    router.push('/appointments')
  } finally {
    loading.value = false
  }
}

const fetchDoctors = async () => {
  try {
    const response = await doctorService.getAll({ status: 'active', per_page: 100 })
    doctors.value = response.data.data || []
  } catch (error) {
    console.error('Error fetching doctors:', error)
  }
}

const fetchServices = async () => {
  try {
    const response = await serviceService.getAll({ status: 'active', per_page: 100 })
    services.value = response.data.data || []
  } catch (error) {
    console.error('Error fetching services:', error)
  }
}

const handleSubmit = async () => {
  submitting.value = true
  try {
    await appointmentService.update(route.params.id, form)
    toast.success('Appointment updated successfully')
    router.push('/appointments')
  } catch (error) {
    console.error('Error updating appointment:', error)
  } finally {
    submitting.value = false
  }
}

onMounted(() => {
  fetchAppointment()
  fetchDoctors()
  fetchServices()
})
</script>
