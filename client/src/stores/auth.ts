import { ref, computed } from 'vue'
import { defineStore } from 'pinia'
import Cookies from 'universal-cookie'
import axios from '@/axios'
import type { UserTypes } from '@/types/UserTypes';
const cookies = new Cookies(null, { path: '/'});

export const useAuthStore = defineStore('auth', () => {
  const loading = ref<boolean>(true)
  const user = ref<UserTypes>()

  function storeToken(token: string) {
    axios.defaults.headers.common['Authorization'] = `Bearer ${token}`
    cookies.set('token', token)
    loading.value = false
  }

  function setUser(_user?: UserTypes): void {
    user.value = _user
    loading.value = false
  }

  function getUser(): UserTypes|undefined {
    return user.value
  }

  function setLoading(loadState: boolean) {

  }

  
  return { storeToken, loading, setLoading, setUser, getUser, user }
})
