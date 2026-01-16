<template>
  <div class="max-w-4xl">
    <div class="mb-6">
      <router-link to="/blogs" class="text-sm text-gray-500 hover:text-gray-700 flex items-center">
        <svg class="h-4 w-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
        </svg>
        Back to Blogs
      </router-link>
      <h2 class="mt-2 text-2xl font-bold text-gray-900">Create New Blog Post</h2>
    </div>

    <div class="card">
      <form @submit.prevent="handleSubmit" class="space-y-6">
        <!-- Basic Information -->
        <div>
          <h3 class="text-lg font-semibold text-gray-900 mb-4">Basic Information</h3>
          <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
            <div class="sm:col-span-2">
              <label class="label">Title *</label>
              <input
                v-model="form.title"
                type="text"
                required
                class="input"
                placeholder="Enter blog title..."
              />
            </div>
            <div>
              <label class="label">Category *</label>
              <input
                v-model="form.category"
                type="text"
                required
                class="input"
                placeholder="Health Tips, Medical News, etc."
              />
            </div>
            <div>
              <label class="label">Author</label>
              <input
                v-model="form.author"
                type="text"
                class="input"
                placeholder="Author name"
              />
            </div>
            <div class="sm:col-span-2">
              <label class="label">Tags (comma separated)</label>
              <input
                v-model="form.tags"
                type="text"
                class="input"
                placeholder="health, wellness, tips"
              />
            </div>
          </div>
        </div>

        <!-- Content -->
        <div>
          <h3 class="text-lg font-semibold text-gray-900 mb-4">Content</h3>
          <div class="space-y-4">
            <div>
              <label class="label">Excerpt *</label>
              <textarea
                v-model="form.excerpt"
                rows="3"
                required
                class="input"
                placeholder="Brief summary of the blog post..."
              ></textarea>
              <p class="mt-1 text-xs text-gray-500">Short description that appears in listings</p>
            </div>
            <div>
              <label class="label">Content *</label>
              <textarea
                v-model="form.content"
                rows="12"
                required
                class="input"
                placeholder="Write your blog content here..."
              ></textarea>
              <p class="mt-1 text-xs text-gray-500">Full blog post content (supports HTML)</p>
            </div>
          </div>
        </div>

        <!-- SEO & Settings -->
        <div>
          <h3 class="text-lg font-semibold text-gray-900 mb-4">SEO & Settings</h3>
          <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
            <div class="sm:col-span-2">
              <label class="label">Meta Description</label>
              <textarea
                v-model="form.meta_description"
                rows="2"
                class="input"
                placeholder="SEO meta description..."
              ></textarea>
            </div>
            <div>
              <label class="label">Featured Image URL</label>
              <input
                v-model="form.featured_image"
                type="url"
                class="input"
                placeholder="https://example.com/image.jpg"
              />
            </div>
            <div>
              <label class="label">Status *</label>
              <select v-model="form.status" required class="input">
                <option value="draft">Draft</option>
                <option value="published">Published</option>
              </select>
            </div>
            <div>
              <label class="label">Reading Time (minutes)</label>
              <input
                v-model="form.reading_time"
                type="number"
                class="input"
                placeholder="5"
                min="1"
              />
            </div>
            <div>
              <label class="label">Is Featured</label>
              <select v-model="form.is_featured" class="input">
                <option :value="false">No</option>
                <option :value="true">Yes</option>
              </select>
            </div>
          </div>
        </div>

        <!-- Actions -->
        <div class="flex justify-end space-x-4">
          <router-link to="/blogs" class="btn btn-secondary">
            Cancel
          </router-link>
          <button type="submit" :disabled="loading" class="btn btn-primary">
            <span v-if="!loading">Create Blog Post</span>
            <span v-else>Creating...</span>
          </button>
        </div>
      </form>
    </div>
  </div>
</template>

<script setup>
import { ref, reactive } from 'vue'
import { useRouter } from 'vue-router'
import blogService from '@/services/blogService'
import { useToast } from 'vue-toastification'

const router = useRouter()
const toast = useToast()
const loading = ref(false)

const form = reactive({
  title: '',
  excerpt: '',
  content: '',
  category: '',
  tags: '',
  author: '',
  featured_image: '',
  meta_description: '',
  reading_time: '',
  status: 'draft',
  is_featured: false
})

const handleSubmit = async () => {
  loading.value = true
  try {
    await blogService.create(form)
    toast.success('Blog post created successfully')
    router.push('/blogs')
  } catch (error) {
    console.error('Error creating blog:', error)
  } finally {
    loading.value = false
  }
}
</script>
