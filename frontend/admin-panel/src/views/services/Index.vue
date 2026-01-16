<template>
  <div class="space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between">
      <div>
        <h2 class="text-2xl font-bold text-gray-900">Services</h2>
        <p class="mt-1 text-sm text-gray-500">Manage all services</p>
      </div>
      <router-link to="/services/create" class="btn btn-primary">
        <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
        </svg>
        Add Service
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
          <label class="label">Status</label>
          <select v-model="filters.status" class="input" @change="fetchServices">
            <option value="">All Status</option>
            <option value="active">Active</option>
            <option value="inactive">Inactive</option>
          </select>
        </div>
        <div>
          <label class="label">Min Price</label>
          <input
            v-model="filters.min_price"
            type="number"
            class="input"
            placeholder="0"
            @change="fetchServices"
          />
        </div>
        <div>
          <label class="label">Max Price</label>
          <input
            v-model="filters.max_price"
            type="number"
            class="input"
            placeholder="1000"
            @change="fetchServices"
          />
        </div>
      </div>
    </div>

    <!-- Table -->
    <div class="card">
      <div v-if="loading" class="text-center py-12">
        <div class="inline-block animate-spin rounded-full h-8 w-8 border-b-2 border-primary-600"></div>
        <p class="mt-2 text-sm text-gray-500">Loading services...</p>
      </div>

      <div v-else-if="services.length === 0" class="text-center py-12">
        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
        </svg>
        <p class="mt-2 text-sm text-gray-500">No services found</p>
      </div>

      <div v-else>
        <div class="overflow-x-auto">
          <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
              <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                  Service
                </th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                  Price
                </th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                  Duration
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
              <tr v-for="service in services" :key="service.id" class="hover:bg-gray-50">
                <td class="px-6 py-4">
                  <div class="text-sm font-medium text-gray-900">{{ service.name }}</div>
                  <div class="text-sm text-gray-500">{{ service.description?.substring(0, 60) }}...</div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                  <div class="text-sm text-gray-900">${{ service.price }}</div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                  <div class="text-sm text-gray-900">{{ service.duration }} min</div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                  <span :class="service.is_active ? 'badge badge-success' : 'badge badge-danger'">
                    {{ service.is_active ? 'Active' : 'Inactive' }}
                  </span>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium space-x-2">
                  <router-link
                    :to="`/services/${service.id}`"
                    class="text-primary-600 hover:text-primary-900"
                  >
                    View
                  </router-link>
                  <router-link
                    :to="`/services/${service.id}/edit`"
                    class="text-blue-600 hover:text-blue-900"
                  >
                    Edit
                  </router-link>
                  <button
                    v-if="service.is_active"
                    @click="deactivateService(service.id)"
                    class="text-orange-600 hover:text-orange-900"
                  >
                    Deactivate
                  </button>
                  <button
                    v-else
                    @click="activateService(service.id)"
                    class="text-green-600 hover:text-green-900"
                  >
                    Activate
                  </button>
                  <button
                    @click="deleteService(service.id)"
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
import serviceService from '@/services/serviceService'
import { useToast } from 'vue-toastification'

const toast = useToast()
const loading = ref(false)
const services = ref([])
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
  min_price: '',
  max_price: ''
})

let searchTimeout = null

const debouncedSearch = () => {
  clearTimeout(searchTimeout)
  searchTimeout = setTimeout(() => {
    fetchServices()
  }, 500)
}

const fetchServices = async () => {
  loading.value = true
  try {
    const params = {
      page: pagination.current_page,
      per_page: pagination.per_page,
      ...filters
    }
    
    const response = await serviceService.getAll(params)
    services.value = response.data.data || []
    
    if (response.data.meta) {
      Object.assign(pagination, response.data.meta)
    }
  } catch (error) {
    console.error('Error fetching services:', error)
  } finally {
    loading.value = false
  }
}

const changePage = (page) => {
  pagination.current_page = page
  fetchServices()
}

const activateService = async (id) => {
  try {
    await serviceService.activate(id)
    toast.success('Service activated successfully')
    fetchServices()
  } catch (error) {
    console.error('Error activating service:', error)
  }
}

const deactivateService = async (id) => {
  if (!confirm('Are you sure you want to deactivate this service?')) return
  
  try {
    await serviceService.deactivate(id)
    toast.success('Service deactivated successfully')
    fetchServices()
  } catch (error) {
    console.error('Error deactivating service:', error)
  }
}

const deleteService = async (id) => {
  if (!confirm('Are you sure you want to delete this service? This action cannot be undone.')) return
  
  try {
    await serviceService.delete(id)
    toast.success('Service deleted successfully')
    fetchServices()
  } catch (error) {
    console.error('Error deleting service:', error)
  }
}

onMounted(() => {
  fetchServices()
})
</script>
