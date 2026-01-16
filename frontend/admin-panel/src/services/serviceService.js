import api from './api'

export default {
  async getAll(params = {}) {
    const response = await api.get('/admin/services', { params })
    return response.data
  },

  async getById(id) {
    const response = await api.get(`/admin/services/${id}`)
    return response.data
  },

  async create(data) {
    const response = await api.post('/admin/services', data)
    return response.data
  },

  async update(id, data) {
    const response = await api.put(`/admin/services/${id}`, data)
    return response.data
  },

  async delete(id) {
    const response = await api.delete(`/admin/services/${id}`)
    return response.data
  },

  async activate(id) {
    const response = await api.post(`/admin/services/${id}/activate`)
    return response.data
  },

  async deactivate(id) {
    const response = await api.post(`/admin/services/${id}/deactivate`)
    return response.data
  },

  async reorder(data) {
    const response = await api.post('/admin/services/reorder', data)
    return response.data
  },

  async getStatistics() {
    const response = await api.get('/admin/services/statistics')
    return response.data
  }
}
