<template>
  <div class="max-w-4xl">
    <div class="mb-6">
      <router-link to="/appointments" class="text-sm text-gray-500 hover:text-gray-700 flex items-center">
        <svg class="h-4 w-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
        </svg>
        Back to Appointments
      </router-link>
      <h2 class="mt-2 text-2xl font-bold text-gray-900">Appointment Details</h2>
    </div>

    <div v-if="loading" class="card text-center py-12">
      <div class="inline-block animate-spin rounded-full h-8 w-8 border-b-2 border-primary-600"></div>
      <p class="mt-2 text-sm text-gray-500">Loading...</p>
    </div>

    <div v-else-if="appointment" class="space-y-6">
      <!-- Status and Actions -->
      <div class="card">
        <div class="flex items-center justify-between">
          <div>
            <span :class="getStatusClass(appointment.status)" class="text-lg">
              {{ appointment.status }}
            </span>
          </div>
          <div class="flex space-x-2">
            <button
              v-if="appointment.status === 'pending'"
              @click="approveAppointment"
              class="btn btn-success"
            >
              Approve
            </button>
            <button
              v-if="appointment.status === 'approved'"
              @click="completeAppointment"
              class="btn btn-primary"
            >
              Mark Complete
            </button>
            <button
              v-if="['pending', 'approved'].includes(appointment.status)"
              @click="cancelAppointment"
              class="btn btn-danger"
            >
              Cancel
            </button>
          </div>
        </div>
      </div>

      <!-- Patient Information -->
      <div class="card">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">Patient Information</h3>
        <dl class="grid grid-cols-1 gap-4 sm:grid-cols-2">
          <div>
            <dt class="text-sm font-medium text-gray-500">Name</dt>
            <dd class="mt-1 text-sm text-gray-900">{{ appointment.patient_name }}</dd>
          </div>
          <div>
            <dt class="text-sm font-medium text-gray-500">Email</dt>
            <dd class="mt-1 text-sm text-gray-900">{{ appointment.patient_email }}</dd>
          </div>
          <div>
            <dt class="text-sm font-medium text-gray-500">Phone</dt>
            <dd class="mt-1 text-sm text-gray-900">{{ appointment.patient_phone }}</dd>
          </div>
          <div v-if="appointment.patient_age">
            <dt class="text-sm font-medium text-gray-500">Age</dt>
            <dd class="mt-1 text-sm text-gray-900">{{ appointment.patient_age }}</dd>
          </div>
        </dl>
      </div>

      <!-- Appointment Details -->
      <div class="card">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">Appointment Details</h3>
        <dl class="grid grid-cols-1 gap-4 sm:grid-cols-2">
          <div>
            <dt class="text-sm font-medium text-gray-500">Doctor</dt>
            <dd class="mt-1 text-sm text-gray-900">{{ appointment.doctor?.name || 'N/A' }}</dd>
          </div>
          <div>
            <dt class="text-sm font-medium text-gray-500">Service</dt>
            <dd class="mt-1 text-sm text-gray-900">{{ appointment.service?.name || 'N/A' }}</dd>
          </div>
          <div>
            <dt class="text-sm font-medium text-gray-500">Date</dt>
            <dd class="mt-1 text-sm text-gray-900">{{ formatDate(appointment.appointment_date) }}</dd>
          </div>
          <div>
            <dt class="text-sm font-medium text-gray-500">Time</dt>
            <dd class="mt-1 text-sm text-gray-900">{{ appointment.appointment_time }}</dd>
          </div>
        </dl>
      </div>

      <!-- Notes -->
      <div v-if="appointment.notes" class="card">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">Notes</h3>
        <p class="text-sm text-gray-700">{{ appointment.notes }}</p>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import { useRoute, useRouter } from 'vue-router'
import appointmentService from '@/services/appointmentService'
import { useToast } from 'vue-toastification'
import dayjs from 'dayjs'

const route = useRoute()
const router = useRouter()
const toast = useToast()
const loading = ref(true)
const appointment = ref(null)

const fetchAppointment = async () => {
  loading.value = true
  try {
    const response = await appointmentService.getById(route.params.id)
    appointment.value = response.data
  } catch (error) {
    console.error('Error fetching appointment:', error)
    router.push('/appointments')
  } finally {
    loading.value = false
  }
}

const approveAppointment = async () => {
  try {
    await appointmentService.approve(route.params.id)
    toast.success('Appointment approved')
    fetchAppointment()
  } catch (error) {
    console.error('Error approving appointment:', error)
  }
}

const completeAppointment = async () => {
  try {
    await appointmentService.complete(route.params.id)
    toast.success('Appointment marked as complete')
    fetchAppointment()
  } catch (error) {
    console.error('Error completing appointment:', error)
  }
}

const cancelAppointment = async () => {
  if (!confirm('Are you sure you want to cancel this appointment?')) return
  try {
    await appointmentService.cancel(route.params.id)
    toast.success('Appointment cancelled')
    fetchAppointment()
  } catch (error) {
    console.error('Error cancelling appointment:', error)
  }
}

const formatDate = (date) => {
  return dayjs(date).format('MMMM DD, YYYY')
}

const getStatusClass = (status) => {
  const classes = {
    pending: 'badge badge-warning',
    approved: 'badge badge-success',
    completed: 'badge badge-info',
    cancelled: 'badge badge-danger',
    rejected: 'badge badge-danger'
  }
  return classes[status] || 'badge badge-gray'
}

onMounted(() => {
  fetchAppointment()
})
</script>
