<template>
  <div class="max-w-3xl">
    <div class="mb-6">
      <router-link to="/services" class="text-sm text-gray-500 hover:text-gray-700 flex items-center">
        <svg class="h-4 w-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
        </svg>
        Back to Services
      </router-link>
      <h2 class="mt-2 text-2xl font-bold text-gray-900">Edit Service</h2>
    </div>

    <div v-if="loading" class="card text-center py-12">
      <div class="inline-block animate-spin rounded-full h-8 w-8 border-b-2 border-primary-600"></div>
      <p class="mt-2 text-sm text-gray-500">Loading...</p>
    </div>

    <div v-else-if="form.name" class="card">
      <form @submit.prevent="handleSubmit" class="space-y-6">
        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
          <div class="sm:col-span-2">
            <label class="label">Service Name *</label>
            <input v-model="form.name" type="text" required class="input" placeholder="General Consultation" />
          </div>
          <div>
            <label class="label">Price *</label>
            <input v-model="form.price" type="number" required class="input" placeholder="500" min="0" step="0.01" />
          </div>
          <div>
            <label class="label">Duration (minutes) *</label>
            <input v-model="form.duration" type="number" required class="input" placeholder="30" min="1" />
          </div>
          <div class="sm:col-span-2">
            <label class="label">Description *</label>
            <textarea v-model="form.description" rows="4" required class="input" placeholder="Service description..."></textarea>
          </div>
          <div>
            <label class="label">Status *</label>
            <select v-model="form.is_active" required class="input">
              <option :value="true">Active</option>
              <option :value="false">Inactive</option>
            </select>
          </div>
        </div>

        <div class="flex justify-end space-x-4">
          <router-link to="/services" class="btn btn-secondary">Cancel</router-link>
          <button type="submit" :disabled="submitting" class="btn btn-primary">
            <span v-if="!submitting">Update Service</span>
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
import serviceService from '@/services/serviceService'
import { useToast } from 'vue-toastification'

const route = useRoute()
const router = useRouter()
const toast = useToast()
const loading = ref(true)
const submitting = ref(false)

const form = reactive({
  name: '',
  description: '',
  price: '',
  duration: '',
  is_active: true
})

const fetchService = async () => {
  loading.value = true
  try {
    const response = await serviceService.getById(route.params.id)
    const service = response.data
    
    form.name = service.name
    form.description = service.description
    form.price = service.price
    form.duration = service.duration
    form.is_active = service.is_active
  } catch (error) {
    console.error('Error fetching service:', error)
    toast.error('Failed to load service')
    router.push('/services')
  } finally {
    loading.value = false
  }
}

const handleSubmit = async () => {
  submitting.value = true
  try {
    await serviceService.update(route.params.id, form)
    toast.success('Service updated successfully')
    router.push('/services')
  } catch (error) {
    console.error('Error updating service:', error)
  } finally {
    submitting.value = false
  }
}

onMounted(() => {
  fetchService()
})
</script>
