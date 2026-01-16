import api from './api'

export default {
  async getAll(params = {}) {
    const response = await api.get('/admin/appointments', { params })
    return response.data
  },

  async getById(id) {
    const response = await api.get(`/admin/appointments/${id}`)
    return response.data
  },

  async create(data) {
    const response = await api.post('/admin/appointments', data)
    return response.data
  },

  async update(id, data) {
    const response = await api.put(`/admin/appointments/${id}`, data)
    return response.data
  },

  async delete(id) {
    const response = await api.delete(`/admin/appointments/${id}`)
    return response.data
  },

  async approve(id) {
    const response = await api.post(`/admin/appointments/${id}/approve`)
    return response.data
  },

  async cancel(id) {
    const response = await api.post(`/admin/appointments/${id}/cancel`)
    return response.data
  },

  async reject(id) {
    const response = await api.post(`/admin/appointments/${id}/reject`)
    return response.data
  },

  async complete(id) {
    const response = await api.post(`/admin/appointments/${id}/complete`)
    return response.data
  },

  async getStatistics() {
    const response = await api.get('/admin/appointments/statistics')
    return response.data
  }
}
