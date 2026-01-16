import api from './api'

export default {
  async getAll(params = {}) {
    const response = await api.get('/admin/doctors', { params })
    return response.data
  },

  async getById(id) {
    const response = await api.get(`/admin/doctors/${id}`)
    return response.data
  },

  async create(data) {
    const response = await api.post('/admin/doctors', data)
    return response.data
  },

  async update(id, data) {
    const response = await api.put(`/admin/doctors/${id}`, data)
    return response.data
  },

  async delete(id) {
    const response = await api.delete(`/admin/doctors/${id}`)
    return response.data
  },

  async activate(id) {
    const response = await api.post(`/admin/doctors/${id}/activate`)
    return response.data
  },

  async deactivate(id) {
    const response = await api.post(`/admin/doctors/${id}/deactivate`)
    return response.data
  },

  async getStatistics() {
    const response = await api.get('/admin/doctors/statistics')
    return response.data
  },

  async getSpecializations() {
    const response = await api.get('/admin/doctors/specializations')
    return response.data
  }
}
