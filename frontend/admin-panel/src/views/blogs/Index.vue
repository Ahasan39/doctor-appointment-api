<template>
  <div class="space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between">
      <div>
        <h2 class="text-2xl font-bold text-gray-900">Blogs</h2>
        <p class="mt-1 text-sm text-gray-500">Manage all blog posts</p>
      </div>
      <router-link to="/blogs/create" class="btn btn-primary">
        <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
        </svg>
        New Blog Post
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
            placeholder="Search by title..."
            class="input"
            @input="debouncedSearch"
          />
        </div>
        <div>
          <label class="label">Status</label>
          <select v-model="filters.status" class="input" @change="fetchBlogs">
            <option value="">All Status</option>
            <option value="published">Published</option>
            <option value="draft">Draft</option>
            <option value="archived">Archived</option>
          </select>
        </div>
        <div>
          <label class="label">Category</label>
          <select v-model="filters.category" class="input" @change="fetchBlogs">
            <option value="">All Categories</option>
            <option v-for="cat in categories" :key="cat" :value="cat">
              {{ cat }}
            </option>
          </select>
        </div>
      </div>
    </div>

    <!-- Table -->
    <div class="card">
      <div v-if="loading" class="text-center py-12">
        <div class="inline-block animate-spin rounded-full h-8 w-8 border-b-2 border-primary-600"></div>
        <p class="mt-2 text-sm text-gray-500">Loading blogs...</p>
      </div>

      <div v-else-if="blogs.length === 0" class="text-center py-12">
        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z" />
        </svg>
        <p class="mt-2 text-sm text-gray-500">No blog posts found</p>
      </div>

      <div v-else>
        <div class="overflow-x-auto">
          <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
              <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                  Title
                </th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                  Category
                </th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                  Author
                </th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                  Status
                </th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                  Views
                </th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                  Actions
                </th>
              </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
              <tr v-for="blog in blogs" :key="blog.id" class="hover:bg-gray-50">
                <td class="px-6 py-4">
                  <div class="text-sm font-medium text-gray-900">{{ blog.title }}</div>
                  <div class="text-sm text-gray-500">{{ formatDate(blog.created_at) }}</div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                  <span class="badge badge-info">{{ blog.category }}</span>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                  <div class="text-sm text-gray-900">{{ blog.author || 'Admin' }}</div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                  <span :class="getStatusClass(blog.status)">
                    {{ blog.status }}
                  </span>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                  <div class="text-sm text-gray-900">{{ blog.views_count || 0 }}</div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium space-x-2">
                  <router-link
                    :to="`/blogs/${blog.id}`"
                    class="text-primary-600 hover:text-primary-900"
                  >
                    View
                  </router-link>
                  <router-link
                    :to="`/blogs/${blog.id}/edit`"
                    class="text-blue-600 hover:text-blue-900"
                  >
                    Edit
                  </router-link>
                  <button
                    v-if="blog.status === 'draft'"
                    @click="publishBlog(blog.id)"
                    class="text-green-600 hover:text-green-900"
                  >
                    Publish
                  </button>
                  <button
                    v-if="blog.status === 'published'"
                    @click="unpublishBlog(blog.id)"
                    class="text-orange-600 hover:text-orange-900"
                  >
                    Unpublish
                  </button>
                  <button
                    @click="deleteBlog(blog.id)"
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
import blogService from '@/services/blogService'
import { useToast } from 'vue-toastification'
import dayjs from 'dayjs'

const toast = useToast()
const loading = ref(false)
const blogs = ref([])
const categories = ref([])
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
  category: ''
})

let searchTimeout = null

const debouncedSearch = () => {
  clearTimeout(searchTimeout)
  searchTimeout = setTimeout(() => {
    fetchBlogs()
  }, 500)
}

const fetchBlogs = async () => {
  loading.value = true
  try {
    const params = {
      page: pagination.current_page,
      per_page: pagination.per_page,
      ...filters
    }
    
    const response = await blogService.getAll(params)
    blogs.value = response.data.data || []
    
    if (response.data.meta) {
      Object.assign(pagination, response.data.meta)
    }
  } catch (error) {
    console.error('Error fetching blogs:', error)
  } finally {
    loading.value = false
  }
}

const fetchCategories = async () => {
  try {
    const response = await blogService.getCategories()
    categories.value = response.data || []
  } catch (error) {
    console.error('Error fetching categories:', error)
  }
}

const changePage = (page) => {
  pagination.current_page = page
  fetchBlogs()
}

const publishBlog = async (id) => {
  try {
    await blogService.publish(id)
    toast.success('Blog published successfully')
    fetchBlogs()
  } catch (error) {
    console.error('Error publishing blog:', error)
  }
}

const unpublishBlog = async (id) => {
  if (!confirm('Are you sure you want to unpublish this blog?')) return
  
  try {
    await blogService.unpublish(id)
    toast.success('Blog unpublished successfully')
    fetchBlogs()
  } catch (error) {
    console.error('Error unpublishing blog:', error)
  }
}

const deleteBlog = async (id) => {
  if (!confirm('Are you sure you want to delete this blog? This action cannot be undone.')) return
  
  try {
    await blogService.delete(id)
    toast.success('Blog deleted successfully')
    fetchBlogs()
  } catch (error) {
    console.error('Error deleting blog:', error)
  }
}

const formatDate = (date) => {
  return dayjs(date).format('MMM DD, YYYY')
}

const getStatusClass = (status) => {
  const classes = {
    published: 'badge badge-success',
    draft: 'badge badge-warning',
    archived: 'badge badge-gray'
  }
  return classes[status] || 'badge badge-gray'
}

onMounted(() => {
  fetchBlogs()
  fetchCategories()
})
</script>
