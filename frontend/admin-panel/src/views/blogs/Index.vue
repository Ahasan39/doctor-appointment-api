<template>
  <div class="space-y-6">
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
    <div class="card">
      <p class="text-gray-500">Blogs list</p>
    </div>
  </div>
</template>
