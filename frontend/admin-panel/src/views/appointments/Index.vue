<template>
  <div class="space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between">
      <div>
        <h2 class="text-2xl font-bold text-gray-900">Appointments</h2>
        <p class="mt-1 text-sm text-gray-500">Manage all patient appointments</p>
      </div>
      <router-link to="/appointments/create" class="btn btn-primary">
        <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
        </svg>
        New Appointment
      </router-link>
    </div>

    <!-- Filters -->
    <div class="card">
      <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-4">
        <div>
          <label class="label">Search</label>
          <input
            v-model="filters.search"
            type="text"
            placeholder="Search by patient name..."
            class="input"
            @input="debouncedSearch"
          />
        </div>
        <div>
          <label class="label">Status</label>
          <select v-model="filters.status" class="input" @change="fetchAppointments">
            <option value="">All Status</option>
            <option value="pending">Pending</option>
            <option value="approved">Approved</option>
            <option value="completed">Completed</option>
            <option value="cancelled">Cancelled</option>
            <option value="rejected">Rejected</option>
          </select>
        </div>
        <div>
          <label class="label">From Date</label>
          <input
            v-model="filters.from_date"
            type="date"
            class="input"
            @change="fetchAppointments"
          />
        </div>
        <div>
          <label class="label">To Date</label>
          <input
            v-model="filters.to_date"
            type="date"
            class="input"
            @change="fetchAppointments"
          />
        </div>
      </div>
    </div>

    <!-- Table -->
    <div class="card">
      <div v-if="loading" class="text-center py-12">
        <div class="inline-block animate-spin rounded-full h-8 w-8 border-b-2 border-primary-600"></div>
        <p class="mt-2 text-sm text-gray-500">Loading appointments...</p>
      </div>

      <div v-else-if="appointments.length === 0" class="text-center py-12">
        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
        </svg>
        <p class="mt-2 text-sm text-gray-500">No appointments found</p>
      </div>

      <div v-else>
        <div class="overflow-x-auto">
          <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
              <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                  Patient
                </th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                  Doctor
                </th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                  Service
                </th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                  Date & Time
                </th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                  Status
                </th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                  Actions
                </th>
              </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
              <tr v-for="appointment in appointments" :key="appointment.id" class="hover:bg-gray-50">
                <td class="px-6 py-4 whitespace-nowrap">
                  <div class="text-sm font-medium text-gray-900">{{ appointment.patient_name }}</div>
                  <div class="text-sm text-gray-500">{{ appointment.patient_email }}</div>
                  <div class="text-sm text-gray-500">{{ appointment.patient_phone }}</div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                  <div class="text-sm text-gray-900">{{ appointment.doctor?.name || 'N/A' }}</div>
                  <div class="text-sm text-gray-500">{{ appointment.doctor?.specialization || '' }}</div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                  <div class="text-sm text-gray-900">{{ appointment.service?.name || 'N/A' }}</div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                  <div class="text-sm text-gray-900">{{ formatDate(appointment.appointment_date) }}</div>
                  <div class="text-sm text-gray-500">{{ appointment.appointment_time }}</div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                  <span :class="getStatusClass(appointment.status)">
                    {{ appointment.status }}
                  </span>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium space-x-2">
                  <router-link
                    :to="`/appointments/${appointment.id}`"
                    class="text-primary-600 hover:text-primary-900"
                  >
                    View
                  </router-link>
                  <button
                    v-if="appointment.status === 'pending'"
                    @click="approveAppointment(appointment.id)"
                    class="text-green-600 hover:text-green-900"
                  >
                    Approve
                  </button>
                  <button
                    @click="deleteAppointment(appointment.id)"
                    class="text-red-600 hover:text-red-900"
                  >
                    Delete
                  </button>
                </td>
              </tr>
            </tbody>
          </table>
        </div>

        <!-- Pagination -->
        <div v-if="pagination.last_page > 1" class="mt-6 flex items-center justify-between border-t border-gray-200 pt-4">
          <div class="text-sm text-gray-700">
            Showing {{ pagination.from }} to {{ pagination.to }} of {{ pagination.total }} results
          </div>
          <div class="flex space-x-2">
            <button
              @click="changePage(pagination.current_page - 1)"
              :disabled="pagination.current_page === 1"
              class="btn btn-secondary"
              :class="{ 'opacity-50 cursor-not-allowed': pagination.current_page === 1 }"
            >
              Previous
            </button>
            <button
              @click="changePage(pagination.current_page + 1)"
              :disabled="pagination.current_page === pagination.last_page"
              class="btn btn-secondary"
              :class="{ 'opacity-50 cursor-not-allowed': pagination.current_page === pagination.last_page }"
            >
              Next
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, reactive, onMounted } from 'vue'
import appointmentService from '@/services/appointmentService'
import { useToast } from 'vue-toastification'
import dayjs from 'dayjs'

const toast = useToast()
const loading = ref(false)
const appointments = ref([])
const pagination = reactive({
  current_page: 1,
  last_page: 1,
  per_page: 10,
  total: 0,
  from: 0,
  to: 0
})

const filters = reactive({
  search: '',
  status: '',
  from_date: '',
  to_date: ''
})

let searchTimeout = null

const debouncedSearch = () => {
  clearTimeout(searchTimeout)
  searchTimeout = setTimeout(() => {
    fetchAppointments()
  }, 500)
}

const fetchAppointments = async () => {
  loading.value = true
  try {
    const params = {
      page: pagination.current_page,
      per_page: pagination.per_page,
      ...filters
    }
    
    const response = await appointmentService.getAll(params)
    appointments.value = response.data.data || []
    
    if (response.data.meta) {
      Object.assign(pagination, response.data.meta)
    }
  } catch (error) {
    console.error('Error fetching appointments:', error)
  } finally {
    loading.value = false
  }
}

const changePage = (page) => {
  pagination.current_page = page
  fetchAppointments()
}

const approveAppointment = async (id) => {
  if (!confirm('Are you sure you want to approve this appointment?')) return
  
  try {
    await appointmentService.approve(id)
    toast.success('Appointment approved successfully')
    fetchAppointments()
  } catch (error) {
    console.error('Error approving appointment:', error)
  }
}

const deleteAppointment = async (id) => {
  if (!confirm('Are you sure you want to delete this appointment?')) return
  
  try {
    await appointmentService.delete(id)
    toast.success('Appointment deleted successfully')
    fetchAppointments()
  } catch (error) {
    console.error('Error deleting appointment:', error)
  }
}

const formatDate = (date) => {
  return dayjs(date).format('MMM DD, YYYY')
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
  fetchAppointments()
})
</script>
