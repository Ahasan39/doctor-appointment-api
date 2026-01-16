<template>
  <div class="max-w-3xl">
    <div class="mb-6">
      <router-link to="/services" class="text-sm text-gray-500 hover:text-gray-700 flex items-center">
        <svg class="h-4 w-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
        </svg>
        Back to Services
      </router-link>
      <h2 class="mt-2 text-2xl font-bold text-gray-900">Add New Service</h2>
    </div>

    <div class="card">
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
          <button type="submit" :disabled="loading" class="btn btn-primary">
            <span v-if="!loading">Add Service</span>
            <span v-else>Adding...</span>
          </button>
        </div>
      </form>
    </div>
  </div>
</template>

<script setup>
import { ref, reactive } from 'vue'
import { useRouter } from 'vue-router'
import serviceService from '@/services/serviceService'
import { useToast } from 'vue-toastification'

const router = useRouter()
const toast = useToast()
const loading = ref(false)

const form = reactive({
  name: '',
  description: '',
  price: '',
  duration: '',
  is_active: true
})

const handleSubmit = async () => {
  loading.value = true
  try {
    await serviceService.create(form)
    toast.success('Service added successfully')
    router.push('/services')
  } catch (error) {
    console.error('Error creating service:', error)
  } finally {
    loading.value = false
  }
}
</script>
