<template>
  <div class="space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between">
      <div>
        <h2 class="text-2xl font-bold text-gray-900">Doctors</h2>
        <p class="mt-1 text-sm text-gray-500">Manage all doctors</p>
      </div>
      <router-link to="/doctors/create" class="btn btn-primary">
        <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
        </svg>
        Add Doctor
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
            placeholder="Search by name..."
            class="input"
            @input="debouncedSearch"
          />
        </div>
        <div>
          <label class="label">Specialization</label>
          <select v-model="filters.specialization" class="input" @change="fetchDoctors">
            <option value="">All Specializations</option>
            <option v-for="spec in specializations" :key="spec" :value="spec">
              {{ spec }}
            </option>
          </select>
        </div>
        <div>
          <label class="label">Status</label>
          <select v-model="filters.status" class="input" @change="fetchDoctors">
            <option value="">All Status</option>
            <option value="active">Active</option>
            <option value="inactive">Inactive</option>
          </select>
        </div>
      </div>
    </div>

    <!-- Table -->
    <div class="card">
      <div v-if="loading" class="text-center py-12">
        <div class="inline-block animate-spin rounded-full h-8 w-8 border-b-2 border-primary-600"></div>
        <p class="mt-2 text-sm text-gray-500">Loading doctors...</p>
      </div>

      <div v-else-if="doctors.length === 0" class="text-center py-12">
        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
        </svg>
        <p class="mt-2 text-sm text-gray-500">No doctors found</p>
      </div>

      <div v-else>
        <div class="overflow-x-auto">
          <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
              <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                  Doctor
                </th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                  Specialization
                </th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                  Contact
                </th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                  Experience
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
              <tr v-for="doctor in doctors" :key="doctor.id" class="hover:bg-gray-50">
                <td class="px-6 py-4 whitespace-nowrap">
                  <div class="flex items-center">
                    <div class="h-10 w-10 flex-shrink-0">
                      <div class="h-10 w-10 rounded-full bg-primary-100 flex items-center justify-center">
                        <span class="text-primary-700 font-semibold text-sm">
                          {{ doctor.name.charAt(0) }}
                        </span>
                      </div>
                    </div>
                    <div class="ml-4">
                      <div class="text-sm font-medium text-gray-900">{{ doctor.name }}</div>
                      <div class="text-sm text-gray-500">{{ doctor.email }}</div>
                    </div>
                  </div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                  <div class="text-sm text-gray-900">{{ doctor.specialization }}</div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                  <div class="text-sm text-gray-900">{{ doctor.phone }}</div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                  <div class="text-sm text-gray-900">{{ doctor.experience_years }} years</div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                  <span :class="doctor.is_active ? 'badge badge-success' : 'badge badge-danger'">
                    {{ doctor.is_active ? 'Active' : 'Inactive' }}
                  </span>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium space-x-2">
                  <router-link
                    :to="`/doctors/${doctor.id}`"
                    class="text-primary-600 hover:text-primary-900"
                  >
                    View
                  </router-link>
                  <router-link
                    :to="`/doctors/${doctor.id}/edit`"
                    class="text-blue-600 hover:text-blue-900"
                  >
                    Edit
                  </router-link>
                  <button
                    v-if="doctor.is_active"
                    @click="deactivateDoctor(doctor.id)"
                    class="text-orange-600 hover:text-orange-900"
                  >
                    Deactivate
                  </button>
                  <button
                    v-else
                    @click="activateDoctor(doctor.id)"
                    class="text-green-600 hover:text-green-900"
                  >
                    Activate
                  </button>
                  <button
                    @click="deleteDoctor(doctor.id)"
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
import doctorService from '@/services/doctorService'
import { useToast } from 'vue-toastification'

const toast = useToast()
const loading = ref(false)
const doctors = ref([])
const specializations = ref([])
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
  specialization: '',
  status: ''
})

let searchTimeout = null

const debouncedSearch = () => {
  clearTimeout(searchTimeout)
  searchTimeout = setTimeout(() => {
    fetchDoctors()
  }, 500)
}

const fetchDoctors = async () => {
  loading.value = true
  try {
    const params = {
      page: pagination.current_page,
      per_page: pagination.per_page,
      ...filters
    }
    
    const response = await doctorService.getAll(params)
    doctors.value = response.data.data || []
    
    if (response.data.meta) {
      Object.assign(pagination, response.data.meta)
    }
  } catch (error) {
    console.error('Error fetching doctors:', error)
  } finally {
    loading.value = false
  }
}

const fetchSpecializations = async () => {
  try {
    const response = await doctorService.getSpecializations()
    specializations.value = response.data || []
  } catch (error) {
    console.error('Error fetching specializations:', error)
  }
}

const changePage = (page) => {
  pagination.current_page = page
  fetchDoctors()
}

const activateDoctor = async (id) => {
  try {
    await doctorService.activate(id)
    toast.success('Doctor activated successfully')
    fetchDoctors()
  } catch (error) {
    console.error('Error activating doctor:', error)
  }
}

const deactivateDoctor = async (id) => {
  if (!confirm('Are you sure you want to deactivate this doctor?')) return
  
  try {
    await doctorService.deactivate(id)
    toast.success('Doctor deactivated successfully')
    fetchDoctors()
  } catch (error) {
    console.error('Error deactivating doctor:', error)
  }
}

const deleteDoctor = async (id) => {
  if (!confirm('Are you sure you want to delete this doctor? This action cannot be undone.')) return
  
  try {
    await doctorService.delete(id)
    toast.success('Doctor deleted successfully')
    fetchDoctors()
  } catch (error) {
    console.error('Error deleting doctor:', error)
  }
}

onMounted(() => {
  fetchDoctors()
  fetchSpecializations()
})
</script>
