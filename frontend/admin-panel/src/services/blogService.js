import api from './api'

export default {
  async getAll(params = {}) {
    const response = await api.get('/admin/blogs', { params })
    return response.data
  },

  async getById(id) {
    const response = await api.get(`/admin/blogs/${id}`)
    return response.data
  },

  async create(data) {
    const response = await api.post('/admin/blogs', data)
    return response.data
  },

  async update(id, data) {
    const response = await api.put(`/admin/blogs/${id}`, data)
    return response.data
  },

  async delete(id) {
    const response = await api.delete(`/admin/blogs/${id}`)
    return response.data
  },

  async publish(id) {
    const response = await api.post(`/admin/blogs/${id}/publish`)
    return response.data
  },

  async unpublish(id) {
    const response = await api.post(`/admin/blogs/${id}/unpublish`)
    return response.data
  },

  async archive(id) {
    const response = await api.post(`/admin/blogs/${id}/archive`)
    return response.data
  },

  async getStatistics() {
    const response = await api.get('/admin/blogs/statistics')
    return response.data
  },

  async getCategories() {
    const response = await api.get('/admin/blogs/categories')
    return response.data
  },

  async getTags() {
    const response = await api.get('/admin/blogs/tags')
    return response.data
  }
}
