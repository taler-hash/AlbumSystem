import { createRouter, createWebHistory } from 'vue-router'
import Albums from '@/views/Albums.vue'
import Register from '@/views/Register.vue'
import Login from '@/views/Login.vue'
import { useAuthStore } from '@/stores/auth';
import axios from '@/axios'
import type { AxiosError } from 'axios'
import Cookies from 'universal-cookie'
import type { UserTypes } from '@/types/UserTypes';
const cookies = new Cookies(null, { path: '/'});

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/',
      name: 'home',
      redirect: (to) => { return {path:'/albums'}},
    },
    {
      path: '/albums',
      name: 'albums',
      component: Albums,
      meta: {
        requiresAuth: true
      }
    },
    {
      path: '/register',
      name: 'register',
      component: Register,
      meta: {
        requiresAuth: false
      }
    },
    {
      path: '/login',
      name: 'login',
      component: Login,
      meta: {
        requiresAuth: false
      }
    },
  ],
})

router.beforeEach(async (to, from) => {
  const canAccess = !to.meta.requiresAuth ? false : await isUserAuthenticated() 

  if (!canAccess && !['register', 'login'].includes(to.name as string)) {
    return { path: '/login' }
  }
})

async function isUserAuthenticated(): Promise<boolean> {
  const authStore = useAuthStore()
  try {
    if(cookies.get('token') && !axios.defaults.headers.common.Authorization) {
      axios.defaults.headers.common['Authorization'] = `Bearer ${cookies.get('token')}`
    }

    const res = await axios.get('/getuserdetails')

    if(!authStore.getUser()) {
      authStore.setUser(res.data as UserTypes)
    }

    return true
  } catch(err) {
    const axiosError = err as AxiosError

    if(axiosError.response?.status && [401, 500].includes(axiosError.response.status)) {
      return false
    }

    return true
  }
}

export default router
