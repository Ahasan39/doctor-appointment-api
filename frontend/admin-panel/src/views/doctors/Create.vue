<template>
  <div class="max-w-3xl">
    <div class="mb-6">
      <router-link to="/doctors" class="text-sm text-gray-500 hover:text-gray-700 flex items-center">
        <svg class="h-4 w-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
        </svg>
        Back to Doctors
      </router-link>
      <h2 class="mt-2 text-2xl font-bold text-gray-900">Add New Doctor</h2>
    </div>

    <div class="card">
      <form @submit.prevent="handleSubmit" class="space-y-6">
        <!-- Basic Information -->
        <div>
          <h3 class="text-lg font-semibold text-gray-900 mb-4">Basic Information</h3>
          <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
            <div>
              <label class="label">Full Name *</label>
              <input
                v-model="form.name"
                type="text"
                required
                class="input"
                placeholder="Dr. John Doe"
              />
            </div>
            <div>
              <label class="label">Email *</label>
              <input
                v-model="form.email"
                type="email"
                required
                class="input"
                placeholder="doctor@example.com"
              />
            </div>
            <div>
              <label class="label">Phone *</label>
              <input
                v-model="form.phone"
                type="tel"
                required
                class="input"
                placeholder="+1234567890"
              />
            </div>
            <div>
              <label class="label">Specialization *</label>
              <input
                v-model="form.specialization"
                type="text"
                required
                class="input"
                placeholder="Cardiologist"
              />
            </div>
          </div>
        </div>

        <!-- Professional Details -->
        <div>
          <h3 class="text-lg font-semibold text-gray-900 mb-4">Professional Details</h3>
          <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
            <div>
              <label class="label">Qualification *</label>
              <input
                v-model="form.qualification"
                type="text"
                required
                class="input"
                placeholder="MBBS, MD"
              />
            </div>
            <div>
              <label class="label">Experience (Years) *</label>
              <input
                v-model="form.experience_years"
                type="number"
                required
                class="input"
                placeholder="10"
                min="0"
              />
            </div>
            <div>
              <label class="label">Consultation Fee *</label>
              <input
                v-model="form.consultation_fee"
                type="number"
                required
                class="input"
                placeholder="500"
                min="0"
                step="0.01"
              />
            </div>
            <div>
              <label class="label">Status *</label>
              <select v-model="form.is_active" required class="input">
                <option :value="true">Active</option>
                <option :value="false">Inactive</option>
              </select>
            </div>
          </div>
        </div>

        <!-- Bio -->
        <div>
          <label class="label">Bio</label>
          <textarea
            v-model="form.bio"
            rows="4"
            class="input"
            placeholder="Brief description about the doctor..."
          ></textarea>
        </div>

        <!-- Actions -->
        <div class="flex justify-end space-x-4">
          <router-link to="/doctors" class="btn btn-secondary">
            Cancel
          </router-link>
          <button type="submit" :disabled="loading" class="btn btn-primary">
            <span v-if="!loading">Add Doctor</span>
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
import doctorService from '@/services/doctorService'
import { useToast } from 'vue-toastification'

const router = useRouter()
const toast = useToast()
const loading = ref(false)

const form = reactive({
  name: '',
  email: '',
  phone: '',
  specialization: '',
  qualification: '',
  experience_years: '',
  consultation_fee: '',
  bio: '',
  is_active: true
})

const handleSubmit = async () => {
  loading.value = true
  try {
    await doctorService.create(form)
    toast.success('Doctor added successfully')
    router.push('/doctors')
  } catch (error) {
    console.error('Error creating doctor:', error)
  } finally {
    loading.value = false
  }
}
</script>
