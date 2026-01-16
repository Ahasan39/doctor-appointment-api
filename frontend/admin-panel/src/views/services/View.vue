<template>
  <div class="max-w-4xl">
    <div class="mb-6">
      <router-link to="/services" class="text-sm text-gray-500 hover:text-gray-700 flex items-center">
        <svg class="h-4 w-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
        </svg>
        Back to Services
      </router-link>
      <h2 class="mt-2 text-2xl font-bold text-gray-900">Service Details</h2>
    </div>

    <div v-if="loading" class="card text-center py-12">
      <div class="inline-block animate-spin rounded-full h-8 w-8 border-b-2 border-primary-600"></div>
      <p class="mt-2 text-sm text-gray-500">Loading...</p>
    </div>

    <div v-else-if="service" class="space-y-6">
      <!-- Status and Actions -->
      <div class="card">
        <div class="flex items-center justify-between">
          <div>
            <span :class="service.is_active ? 'badge badge-success' : 'badge badge-danger'" class="text-lg">
              {{ service.is_active ? 'Active' : 'Inactive' }}
            </span>
          </div>
          <div class="flex space-x-2">
            <router-link :to="`/services/${service.id}/edit`" class="btn btn-primary">Edit</router-link>
            <button v-if="service.is_active" @click="deactivateService" class="btn btn-secondary">Deactivate</button>
            <button v-else @click="activateService" class="btn btn-success">Activate</button>
          </div>
        </div>
      </div>

      <!-- Service Information -->
      <div class="card">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">Service Information</h3>
        <dl class="grid grid-cols-1 gap-4 sm:grid-cols-2">
          <div class="sm:col-span-2">
            <dt class="text-sm font-medium text-gray-500">Service Name</dt>
            <dd class="mt-1 text-sm text-gray-900">{{ service.name }}</dd>
          </div>
          <div>
            <dt class="text-sm font-medium text-gray-500">Price</dt>
            <dd class="mt-1 text-sm text-gray-900">${{ service.price }}</dd>
          </div>
          <div>
            <dt class="text-sm font-medium text-gray-500">Duration</dt>
            <dd class="mt-1 text-sm text-gray-900">{{ service.duration }} minutes</dd>
          </div>
          <div class="sm:col-span-2">
            <dt class="text-sm font-medium text-gray-500">Description</dt>
            <dd class="mt-1 text-sm text-gray-700">{{ service.description }}</dd>
          </div>
        </dl>
      </div>

      <!-- Timestamps -->
      <div class="card">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">Additional Information</h3>
        <dl class="grid grid-cols-1 gap-4 sm:grid-cols-2">
          <div>
            <dt class="text-sm font-medium text-gray-500">Created At</dt>
            <dd class="mt-1 text-sm text-gray-900">{{ formatDate(service.created_at) }}</dd>
          </div>
          <div>
            <dt class="text-sm font-medium text-gray-500">Last Updated</dt>
            <dd class="mt-1 text-sm text-gray-900">{{ formatDate(service.updated_at) }}</dd>
          </div>
        </dl>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import { useRoute, useRouter } from 'vue-router'
import serviceService from '@/services/serviceService'
import { useToast } from 'vue-toastification'
import dayjs from 'dayjs'

const route = useRoute()
const router = useRouter()
const toast = useToast()
const loading = ref(true)
const service = ref(null)

const fetchService = async () => {
  loading.value = true
  try {
    const response = await serviceService.getById(route.params.id)
    service.value = response.data
  } catch (error) {
    console.error('Error fetching service:', error)
    toast.error('Failed to load service details')
    router.push('/services')
  } finally {
    loading.value = false
  }
}

const activateService = async () => {
  try {
    await serviceService.activate(route.params.id)
    toast.success('Service activated successfully')
    fetchService()
  } catch (error) {
    console.error('Error activating service:', error)
  }
}

const deactivateService = async () => {
  if (!confirm('Are you sure you want to deactivate this service?')) return
  try {
    await serviceService.deactivate(route.params.id)
    toast.success('Service deactivated successfully')
    fetchService()
  } catch (error) {
    console.error('Error deactivating service:', error)
  }
}

const formatDate = (date) => {
  return dayjs(date).format('MMMM DD, YYYY HH:mm')
}

onMounted(() => {
  fetchService()
})
</script>
