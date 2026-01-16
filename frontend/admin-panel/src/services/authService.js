import api from './api'

export default {
  async login(credentials) {
    const response = await api.post('/admin/login', credentials)
    return response.data
  },

  async logout() {
    const response = await api.post('/admin/logout')
    return response.data
  },

  async logoutAll() {
    const response = await api.post('/admin/logout-all')
    return response.data
  },

  async getMe() {
    const response = await api.get('/admin/me')
    return response.data
  },

  async refreshToken() {
    const response = await api.post('/admin/refresh')
    return response.data
  }
}
