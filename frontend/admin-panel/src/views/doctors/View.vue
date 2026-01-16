<template>
  <div class="max-w-4xl">
    <div class="mb-6">
      <router-link to="/doctors" class="text-sm text-gray-500 hover:text-gray-700 flex items-center">
        <svg class="h-4 w-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
        </svg>
        Back to Doctors
      </router-link>
      <h2 class="mt-2 text-2xl font-bold text-gray-900">Doctor Details</h2>
    </div>

    <div v-if="loading" class="card text-center py-12">
      <div class="inline-block animate-spin rounded-full h-8 w-8 border-b-2 border-primary-600"></div>
      <p class="mt-2 text-sm text-gray-500">Loading...</p>
    </div>

    <div v-else-if="doctor" class="space-y-6">
      <!-- Status and Actions -->
      <div class="card">
        <div class="flex items-center justify-between">
          <div>
            <span :class="doctor.is_active ? 'badge badge-success' : 'badge badge-danger'" class="text-lg">
              {{ doctor.is_active ? 'Active' : 'Inactive' }}
            </span>
          </div>
          <div class="flex space-x-2">
            <router-link
              :to="`/doctors/${doctor.id}/edit`"
              class="btn btn-primary"
            >
              Edit
            </router-link>
            <button
              v-if="doctor.is_active"
              @click="deactivateDoctor"
              class="btn btn-secondary"
            >
              Deactivate
            </button>
            <button
              v-else
              @click="activateDoctor"
              class="btn btn-success"
            >
              Activate
            </button>
          </div>
        </div>
      </div>

      <!-- Basic Information -->
      <div class="card">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">Basic Information</h3>
        <dl class="grid grid-cols-1 gap-4 sm:grid-cols-2">
          <div>
            <dt class="text-sm font-medium text-gray-500">Full Name</dt>
            <dd class="mt-1 text-sm text-gray-900">{{ doctor.name }}</dd>
          </div>
          <div>
            <dt class="text-sm font-medium text-gray-500">Email</dt>
            <dd class="mt-1 text-sm text-gray-900">{{ doctor.email }}</dd>
          </div>
          <div>
            <dt class="text-sm font-medium text-gray-500">Phone</dt>
            <dd class="mt-1 text-sm text-gray-900">{{ doctor.phone }}</dd>
          </div>
          <div>
            <dt class="text-sm font-medium text-gray-500">Specialization</dt>
            <dd class="mt-1 text-sm text-gray-900">{{ doctor.specialization }}</dd>
          </div>
        </dl>
      </div>

      <!-- Professional Details -->
      <div class="card">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">Professional Details</h3>
        <dl class="grid grid-cols-1 gap-4 sm:grid-cols-2">
          <div>
            <dt class="text-sm font-medium text-gray-500">Qualification</dt>
            <dd class="mt-1 text-sm text-gray-900">{{ doctor.qualification }}</dd>
          </div>
          <div>
            <dt class="text-sm font-medium text-gray-500">Experience</dt>
            <dd class="mt-1 text-sm text-gray-900">{{ doctor.experience_years }} years</dd>
          </div>
          <div>
            <dt class="text-sm font-medium text-gray-500">Consultation Fee</dt>
            <dd class="mt-1 text-sm text-gray-900">${{ doctor.consultation_fee }}</dd>
          </div>
          <div>
            <dt class="text-sm font-medium text-gray-500">Total Appointments</dt>
            <dd class="mt-1 text-sm text-gray-900">{{ doctor.appointments_count || 0 }}</dd>
          </div>
        </dl>
      </div>

      <!-- Bio -->
      <div v-if="doctor.bio" class="card">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">Bio</h3>
        <p class="text-sm text-gray-700">{{ doctor.bio }}</p>
      </div>

      <!-- Timestamps -->
      <div class="card">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">Additional Information</h3>
        <dl class="grid grid-cols-1 gap-4 sm:grid-cols-2">
          <div>
            <dt class="text-sm font-medium text-gray-500">Created At</dt>
            <dd class="mt-1 text-sm text-gray-900">{{ formatDate(doctor.created_at) }}</dd>
          </div>
          <div>
            <dt class="text-sm font-medium text-gray-500">Last Updated</dt>
            <dd class="mt-1 text-sm text-gray-900">{{ formatDate(doctor.updated_at) }}</dd>
          </div>
        </dl>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import { useRoute, useRouter } from 'vue-router'
import doctorService from '@/services/doctorService'
import { useToast } from 'vue-toastification'
import dayjs from 'dayjs'

const route = useRoute()
const router = useRouter()
const toast = useToast()
const loading = ref(true)
const doctor = ref(null)

const fetchDoctor = async () => {
  loading.value = true
  try {
    const response = await doctorService.getById(route.params.id)
    doctor.value = response.data
  } catch (error) {
    console.error('Error fetching doctor:', error)
    toast.error('Failed to load doctor details')
    router.push('/doctors')
  } finally {
    loading.value = false
  }
}

const activateDoctor = async () => {
  try {
    await doctorService.activate(route.params.id)
    toast.success('Doctor activated successfully')
    fetchDoctor()
  } catch (error) {
    console.error('Error activating doctor:', error)
  }
}

const deactivateDoctor = async () => {
  if (!confirm('Are you sure you want to deactivate this doctor?')) return
  
  try {
    await doctorService.deactivate(route.params.id)
    toast.success('Doctor deactivated successfully')
    fetchDoctor()
  } catch (error) {
    console.error('Error deactivating doctor:', error)
  }
}

const formatDate = (date) => {
  return dayjs(date).format('MMMM DD, YYYY HH:mm')
}

onMounted(() => {
  fetchDoctor()
})
</script>
