<template>
  <div class="space-y-6">
    <!-- Stats Grid -->
    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-4">
      <div
        v-for="stat in stats"
        :key="stat.name"
        class="card hover:shadow-md transition-shadow"
      >
        <div class="flex items-center">
          <div class="flex-shrink-0">
            <div
              :class="[
                'h-12 w-12 rounded-lg flex items-center justify-center',
                stat.bgColor
              ]"
            >
              <svg
                class="h-6 w-6"
                :class="stat.iconColor"
                fill="none"
                stroke="currentColor"
                viewBox="0 0 24 24"
              >
                <path
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  stroke-width="2"
                  :d="stat.icon"
                />
              </svg>
            </div>
          </div>
          <div class="ml-5 w-0 flex-1">
            <dl>
              <dt class="text-sm font-medium text-gray-500 truncate">
                {{ stat.name }}
              </dt>
              <dd class="flex items-baseline">
                <div class="text-2xl font-semibold text-gray-900">
                  {{ stat.value }}
                </div>
                <div
                  v-if="stat.change"
                  :class="[
                    'ml-2 flex items-baseline text-sm font-semibold',
                    stat.changeType === 'increase' ? 'text-green-600' : 'text-red-600'
                  ]"
                >
                  <svg
                    v-if="stat.changeType === 'increase'"
                    class="h-4 w-4 flex-shrink-0"
                    fill="currentColor"
                    viewBox="0 0 20 20"
                  >
                    <path
                      fill-rule="evenodd"
                      d="M5.293 9.707a1 1 0 010-1.414l4-4a1 1 0 011.414 0l4 4a1 1 0 01-1.414 1.414L11 7.414V15a1 1 0 11-2 0V7.414L6.707 9.707a1 1 0 01-1.414 0z"
                      clip-rule="evenodd"
                    />
                  </svg>
                  <svg
                    v-else
                    class="h-4 w-4 flex-shrink-0"
                    fill="currentColor"
                    viewBox="0 0 20 20"
                  >
                    <path
                      fill-rule="evenodd"
                      d="M14.707 10.293a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 111.414-1.414L9 12.586V5a1 1 0 012 0v7.586l2.293-2.293a1 1 0 011.414 0z"
                      clip-rule="evenodd"
                    />
                  </svg>
                  {{ stat.change }}
                </div>
              </dd>
            </dl>
          </div>
        </div>
      </div>
    </div>

    <!-- Charts Row -->
    <div class="grid grid-cols-1 gap-6 lg:grid-cols-2">
      <!-- Appointments Chart -->
      <div class="card">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">Appointments Overview</h3>
        <div class="h-64">
          <canvas ref="appointmentsChart"></canvas>
        </div>
      </div>

      <!-- Status Distribution -->
      <div class="card">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">Status Distribution</h3>
        <div class="h-64">
          <canvas ref="statusChart"></canvas>
        </div>
      </div>
    </div>

    <!-- Recent Appointments -->
    <div class="card">
      <div class="flex items-center justify-between mb-6">
        <h3 class="text-lg font-semibold text-gray-900">Recent Appointments</h3>
        <router-link
          to="/appointments"
          class="text-sm font-medium text-primary-600 hover:text-primary-700"
        >
          View all
        </router-link>
      </div>

      <div v-if="loading" class="text-center py-12">
        <div class="inline-block animate-spin rounded-full h-8 w-8 border-b-2 border-primary-600"></div>
        <p class="mt-2 text-sm text-gray-500">Loading...</p>
      </div>

      <div v-else-if="recentAppointments.length === 0" class="text-center py-12">
        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
        </svg>
        <p class="mt-2 text-sm text-gray-500">No appointments found</p>
      </div>

      <div v-else class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
          <thead class="bg-gray-50">
            <tr>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                Patient
              </th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                Doctor
              </th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                Date & Time
              </th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                Status
              </th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                Actions
              </th>
            </tr>
          </thead>
          <tbody class="bg-white divide-y divide-gray-200">
            <tr v-for="appointment in recentAppointments" :key="appointment.id" class="hover:bg-gray-50">
              <td class="px-6 py-4 whitespace-nowrap">
                <div class="text-sm font-medium text-gray-900">{{ appointment.patient_name }}</div>
                <div class="text-sm text-gray-500">{{ appointment.patient_email }}</div>
              </td>
              <td class="px-6 py-4 whitespace-nowrap">
                <div class="text-sm text-gray-900">{{ appointment.doctor?.name || 'N/A' }}</div>
              </td>
              <td class="px-6 py-4 whitespace-nowrap">
                <div class="text-sm text-gray-900">{{ formatDate(appointment.appointment_date) }}</div>
                <div class="text-sm text-gray-500">{{ appointment.appointment_time }}</div>
              </td>
              <td class="px-6 py-4 whitespace-nowrap">
                <span :class="getStatusClass(appointment.status)">
                  {{ appointment.status }}
                </span>
              </td>
              <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                <router-link
                  :to="`/appointments/${appointment.id}`"
                  class="text-primary-600 hover:text-primary-900"
                >
                  View
                </router-link>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import { Chart, registerables } from 'chart.js'
import appointmentService from '@/services/appointmentService'
import dayjs from 'dayjs'

Chart.register(...registerables)

const loading = ref(true)
const recentAppointments = ref([])
const appointmentsChart = ref(null)
const statusChart = ref(null)

const stats = ref([
  {
    name: 'Total Appointments',
    value: '0',
    icon: 'M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2',
    bgColor: 'bg-blue-100',
    iconColor: 'text-blue-600',
    change: '+12%',
    changeType: 'increase'
  },
  {
    name: 'Pending',
    value: '0',
    icon: 'M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z',
    bgColor: 'bg-yellow-100',
    iconColor: 'text-yellow-600',
    change: '+5%',
    changeType: 'increase'
  },
  {
    name: 'Approved',
    value: '0',
    icon: 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z',
    bgColor: 'bg-green-100',
    iconColor: 'text-green-600',
    change: '+8%',
    changeType: 'increase'
  },
  {
    name: 'Completed',
    value: '0',
    icon: 'M5 13l4 4L19 7',
    bgColor: 'bg-purple-100',
    iconColor: 'text-purple-600',
    change: '+3%',
    changeType: 'increase'
  }
])

const fetchDashboardData = async () => {
  loading.value = true
  try {
    const [appointmentsRes, statsRes] = await Promise.all([
      appointmentService.getAll({ per_page: 5, sort_by: 'created_at', sort_order: 'desc' }),
      appointmentService.getStatistics()
    ])

    recentAppointments.value = appointmentsRes.data.data || []
    
    if (statsRes.data) {
      stats.value[0].value = statsRes.data.total || '0'
      stats.value[1].value = statsRes.data.pending || '0'
      stats.value[2].value = statsRes.data.approved || '0'
      stats.value[3].value = statsRes.data.completed || '0'
    }

    initCharts(statsRes.data)
  } catch (error) {
    console.error('Error fetching dashboard data:', error)
  } finally {
    loading.value = false
  }
}

const initCharts = (data) => {
  // Appointments Chart
  if (appointmentsChart.value) {
    new Chart(appointmentsChart.value, {
      type: 'line',
      data: {
        labels: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
        datasets: [{
          label: 'Appointments',
          data: [12, 19, 15, 25, 22, 30, 28],
          borderColor: 'rgb(59, 130, 246)',
          backgroundColor: 'rgba(59, 130, 246, 0.1)',
          tension: 0.4
        }]
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
          legend: {
            display: false
          }
        }
      }
    })
  }

  // Status Chart
  if (statusChart.value) {
    new Chart(statusChart.value, {
      type: 'doughnut',
      data: {
        labels: ['Pending', 'Approved', 'Completed', 'Cancelled'],
        datasets: [{
          data: [
            data?.pending || 0,
            data?.approved || 0,
            data?.completed || 0,
            data?.cancelled || 0
          ],
          backgroundColor: [
            'rgb(251, 191, 36)',
            'rgb(16, 185, 129)',
            'rgb(139, 92, 246)',
            'rgb(239, 68, 68)'
          ]
        }]
      },
      options: {
        responsive: true,
        maintainAspectRatio: false
      }
    })
  }
}

const formatDate = (date) => {
  return dayjs(date).format('MMM DD, YYYY')
}

const getStatusClass = (status) => {
  const classes = {
    pending: 'badge badge-warning',
    approved: 'badge badge-success',
    completed: 'badge badge-info',
    cancelled: 'badge badge-danger',
    rejected: 'badge badge-danger'
  }
  return classes[status] || 'badge badge-gray'
}

onMounted(() => {
  fetchDashboardData()
})
</script>
