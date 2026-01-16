import axios from 'axios'
import { useAuthStore } from '@/stores/auth'
import { useToast } from 'vue-toastification'

const toast = useToast()

const api = axios.create({
  baseURL: 'http://localhost:8000/api/v1',
  headers: {
    'Content-Type': 'application/json',
    'Accept': 'application/json'
  }
})

// Request interceptor
api.interceptors.request.use(
  (config) => {
    const authStore = useAuthStore()
    if (authStore.token) {
      config.headers.Authorization = `Bearer ${authStore.token}`
    }
    return config
  },
  (error) => {
    return Promise.reject(error)
  }
)

// Response interceptor
api.interceptors.response.use(
  (response) => {
    return response
  },
  (error) => {
    if (error.response) {
      const { status, data } = error.response
      
      // Handle 401 Unauthorized
      if (status === 401) {
        const authStore = useAuthStore()
        authStore.logout()
        toast.error('Session expired. Please login again.')
      }
      
      // Handle 403 Forbidden
      else if (status === 403) {
        toast.error('You do not have permission to perform this action.')
      }
      
      // Handle 404 Not Found
      else if (status === 404) {
        toast.error('Resource not found.')
      }
      
      // Handle 422 Validation Error
      else if (status === 422) {
        const errors = data.errors || {}
        const firstError = Object.values(errors)[0]
        if (firstError && firstError[0]) {
          toast.error(firstError[0])
        } else {
          toast.error(data.message || 'Validation error.')
        }
      }
      
      // Handle 500 Server Error
      else if (status === 500) {
        toast.error('Server error. Please try again later.')
      }
      
      // Handle other errors
      else {
        toast.error(data.message || 'An error occurred.')
      }
    } else if (error.request) {
      toast.error('Network error. Please check your connection.')
    } else {
      toast.error('An unexpected error occurred.')
    }
    
    return Promise.reject(error)
  }
)

export default api
