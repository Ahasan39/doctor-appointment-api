<template>
  <div class="max-w-4xl">
    <div class="mb-6">
      <router-link to="/blogs" class="text-sm text-gray-500 hover:text-gray-700 flex items-center">
        <svg class="h-4 w-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
        </svg>
        Back to Blogs
      </router-link>
      <h2 class="mt-2 text-2xl font-bold text-gray-900">Blog Post Details</h2>
    </div>

    <div v-if="loading" class="card text-center py-12">
      <div class="inline-block animate-spin rounded-full h-8 w-8 border-b-2 border-primary-600"></div>
      <p class="mt-2 text-sm text-gray-500">Loading...</p>
    </div>

    <div v-else-if="blog" class="space-y-6">
      <!-- Status and Actions -->
      <div class="card">
        <div class="flex items-center justify-between">
          <div class="flex items-center space-x-3">
            <span :class="getStatusClass(blog.status)" class="text-lg">
              {{ blog.status }}
            </span>
            <span v-if="blog.is_featured" class="badge badge-warning">Featured</span>
          </div>
          <div class="flex space-x-2">
            <router-link :to="`/blogs/${blog.id}/edit`" class="btn btn-primary">Edit</router-link>
            <button v-if="blog.status === 'draft'" @click="publishBlog" class="btn btn-success">Publish</button>
            <button v-if="blog.status === 'published'" @click="unpublishBlog" class="btn btn-secondary">Unpublish</button>
          </div>
        </div>
      </div>

      <!-- Featured Image -->
      <div v-if="blog.featured_image" class="card">
        <img :src="blog.featured_image" :alt="blog.title" class="w-full h-64 object-cover rounded-lg" />
      </div>

      <!-- Basic Information -->
      <div class="card">
        <h3 class="text-2xl font-bold text-gray-900 mb-4">{{ blog.title }}</h3>
        <dl class="grid grid-cols-1 gap-4 sm:grid-cols-2">
          <div>
            <dt class="text-sm font-medium text-gray-500">Category</dt>
            <dd class="mt-1"><span class="badge badge-info">{{ blog.category }}</span></dd>
          </div>
          <div>
            <dt class="text-sm font-medium text-gray-500">Author</dt>
            <dd class="mt-1 text-sm text-gray-900">
              {{ typeof blog.author === 'object' ? blog.author.name : (blog.author || 'Admin') }}
            </dd>
          </div>
          <div>
            <dt class="text-sm font-medium text-gray-500">Reading Time</dt>
            <dd class="mt-1 text-sm text-gray-900">
              {{ blog.reading_time ? `${blog.reading_time} min${blog.reading_time > 1 ? 's' : ''} read` : 'N/A' }}
            </dd>
          </div>
          <div>
            <dt class="text-sm font-medium text-gray-500">Views</dt>
            <dd class="mt-1 text-sm text-gray-900">{{ blog.views_count || 0 }}</dd>
          </div>
          <div v-if="blog.tags && typeof blog.tags === 'string'" class="sm:col-span-2">
            <dt class="text-sm font-medium text-gray-500">Tags</dt>
            <dd class="mt-1 flex flex-wrap gap-2">
              <span v-for="tag in blog.tags.split(',')" :key="tag" class="badge badge-gray">
                {{ tag.trim() }}
              </span>
            </dd>
          </div>
        </dl>
      </div>

      <!-- Excerpt -->
      <div v-if="blog.excerpt" class="card">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">Excerpt</h3>
        <p class="text-sm text-gray-700">{{ blog.excerpt }}</p>
      </div>

      <!-- Content -->
      <div class="card">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">Content</h3>
        <div class="prose max-w-none text-sm text-gray-700" v-html="blog.content"></div>
      </div>

      <!-- SEO -->
      <div v-if="blog.meta_description" class="card">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">SEO</h3>
        <dl class="grid grid-cols-1 gap-4">
          <div>
            <dt class="text-sm font-medium text-gray-500">Meta Description</dt>
            <dd class="mt-1 text-sm text-gray-700">{{ blog.meta_description }}</dd>
          </div>
        </dl>
      </div>

      <!-- Timestamps -->
      <div class="card">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">Additional Information</h3>
        <dl class="grid grid-cols-1 gap-4 sm:grid-cols-2">
          <div>
            <dt class="text-sm font-medium text-gray-500">Created At</dt>
            <dd class="mt-1 text-sm text-gray-900">{{ formatDate(blog.created_at) }}</dd>
          </div>
          <div>
            <dt class="text-sm font-medium text-gray-500">Last Updated</dt>
            <dd class="mt-1 text-sm text-gray-900">{{ formatDate(blog.updated_at) }}</dd>
          </div>
          <div v-if="blog.published_at">
            <dt class="text-sm font-medium text-gray-500">Published At</dt>
            <dd class="mt-1 text-sm text-gray-900">{{ formatDate(blog.published_at) }}</dd>
          </div>
        </dl>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import { useRoute, useRouter } from 'vue-router'
import blogService from '@/services/blogService'
import { useToast } from 'vue-toastification'
import dayjs from 'dayjs'

const route = useRoute()
const router = useRouter()
const toast = useToast()
const loading = ref(true)
const blog = ref(null)

const fetchBlog = async () => {
  loading.value = true
  try {
    const response = await blogService.getById(route.params.id)
    blog.value = response.data
  } catch (error) {
    console.error('Error fetching blog:', error)
    toast.error('Failed to load blog post')
    router.push('/blogs')
  } finally {
    loading.value = false
  }
}

const publishBlog = async () => {
  try {
    await blogService.publish(route.params.id)
    toast.success('Blog published successfully')
    fetchBlog()
  } catch (error) {
    console.error('Error publishing blog:', error)
  }
}

const unpublishBlog = async () => {
  if (!confirm('Are you sure you want to unpublish this blog?')) return
  try {
    await blogService.unpublish(route.params.id)
    toast.success('Blog unpublished successfully')
    fetchBlog()
  } catch (error) {
    console.error('Error unpublishing blog:', error)
  }
}

const formatDate = (date) => {
  return dayjs(date).format('MMMM DD, YYYY HH:mm')
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
  fetchBlog()
})
</script>
