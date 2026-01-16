<template>
  <div class="max-w-3xl">
    <div class="mb-6">
      <router-link to="/doctors" class="text-sm text-gray-500 hover:text-gray-700 flex items-center">
        <svg class="h-4 w-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
        </svg>
        Back to Doctors
      </router-link>
      <h2 class="mt-2 text-2xl font-bold text-gray-900">Edit Doctor</h2>
    </div>

    <div v-if="loading" class="card text-center py-12">
      <div class="inline-block animate-spin rounded-full h-8 w-8 border-b-2 border-primary-600"></div>
      <p class="mt-2 text-sm text-gray-500">Loading...</p>
    </div>

    <div v-else-if="form.name" class="card">
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
          <button type="submit" :disabled="submitting" class="btn btn-primary">
            <span v-if="!submitting">Update Doctor</span>
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
import doctorService from '@/services/doctorService'
import { useToast } from 'vue-toastification'

const route = useRoute()
const router = useRouter()
const toast = useToast()
const loading = ref(true)
const submitting = ref(false)

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

const fetchDoctor = async () => {
  loading.value = true
  try {
    const response = await doctorService.getById(route.params.id)
    const doctor = response.data
    
    // Pre-fill form
    form.name = doctor.name
    form.email = doctor.email
    form.phone = doctor.phone
    form.specialization = doctor.specialization
    form.qualification = doctor.qualification
    form.experience_years = doctor.experience_years
    form.consultation_fee = doctor.consultation_fee
    form.bio = doctor.bio || ''
    form.is_active = doctor.is_active
  } catch (error) {
    console.error('Error fetching doctor:', error)
    toast.error('Failed to load doctor')
    router.push('/doctors')
  } finally {
    loading.value = false
  }
}

const handleSubmit = async () => {
  submitting.value = true
  try {
    await doctorService.update(route.params.id, form)
    toast.success('Doctor updated successfully')
    router.push('/doctors')
  } catch (error) {
    console.error('Error updating doctor:', error)
  } finally {
    submitting.value = false
  }
}

onMounted(() => {
  fetchDoctor()
})
</script>
