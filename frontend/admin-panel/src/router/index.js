import { createRouter, createWebHistory } from 'vue-router'
import { useAuthStore } from '@/stores/auth'

const routes = [
  {
    path: '/login',
    name: 'Login',
    component: () => import('@/views/Login.vue'),
    meta: { requiresAuth: false }
  },
  {
    path: '/',
    component: () => import('@/layouts/MainLayout.vue'),
    meta: { requiresAuth: true },
    children: [
      {
        path: '',
        redirect: '/dashboard'
      },
      {
        path: 'dashboard',
        name: 'Dashboard',
        component: () => import('@/views/Dashboard.vue')
      },
      {
        path: 'appointments',
        name: 'Appointments',
        component: () => import('@/views/appointments/Index.vue')
      },
      {
        path: 'appointments/create',
        name: 'CreateAppointment',
        component: () => import('@/views/appointments/Create.vue')
      },
      {
        path: 'appointments/:id',
        name: 'ViewAppointment',
        component: () => import('@/views/appointments/View.vue')
      },
      {
        path: 'appointments/:id/edit',
        name: 'EditAppointment',
        component: () => import('@/views/appointments/Edit.vue')
      },
      {
        path: 'doctors',
        name: 'Doctors',
        component: () => import('@/views/doctors/Index.vue')
      },
      {
        path: 'doctors/create',
        name: 'CreateDoctor',
        component: () => import('@/views/doctors/Create.vue')
      },
      {
        path: 'doctors/:id',
        name: 'ViewDoctor',
        component: () => import('@/views/doctors/View.vue')
      },
      {
        path: 'doctors/:id/edit',
        name: 'EditDoctor',
        component: () => import('@/views/doctors/Edit.vue')
      },
      {
        path: 'services',
        name: 'Services',
        component: () => import('@/views/services/Index.vue')
      },
      {
        path: 'services/create',
        name: 'CreateService',
        component: () => import('@/views/services/Create.vue')
      },
      {
        path: 'services/:id',
        name: 'ViewService',
        component: () => import('@/views/services/View.vue')
      },
      {
        path: 'services/:id/edit',
        name: 'EditService',
        component: () => import('@/views/services/Edit.vue')
      },
      {
        path: 'blogs',
        name: 'Blogs',
        component: () => import('@/views/blogs/Index.vue')
      },
      {
        path: 'blogs/create',
        name: 'CreateBlog',
        component: () => import('@/views/blogs/Create.vue')
      },
      {
        path: 'blogs/:id',
        name: 'ViewBlog',
        component: () => import('@/views/blogs/View.vue')
      },
      {
        path: 'blogs/:id/edit',
        name: 'EditBlog',
        component: () => import('@/views/blogs/Edit.vue')
      }
    ]
  }
]

const router = createRouter({
  history: createWebHistory(),
  routes
})

router.beforeEach(async (to, from, next) => {
  const authStore = useAuthStore()
  const requiresAuth = to.matched.some(record => record.meta.requiresAuth)

  if (requiresAuth && !authStore.isAuthenticated) {
    next('/login')
  } else if (to.path === '/login' && authStore.isAuthenticated) {
    next('/dashboard')
  } else {
    next()
  }
})

export default router
