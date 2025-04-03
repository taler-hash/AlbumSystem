<template>
    <div v-if="!loading" class="container">
        <div class="wrapper">
            <div class="card">
                <div class="card-header">
                    <p class="card-title">Login to Album System</p>
                </div>
                <div class="card-content">
                    <Input v-model="model.username" title="Username" :errors="errors?.username" type="text"/>
                    <Input v-model="model.password" title="Password" :errors="errors?.password" type="password"/>
                </div>
                <div class="card-footer">
                    <Button label="Login" @click="login"/>
                </div>
            </div>
        </div>
    </div>
    <LoadingScreen v-else/>
</template>
<script lang="ts" setup>
import Button from '@/components/Button.vue';
import Input from '@/components/Input.vue';
import axios from '@/axios';
import { useAuthStore } from '@/stores/auth';
import { ref } from 'vue';
import router from '@/router';
import { onBeforeMount } from 'vue';
import type { UserTypes } from '@/types/UserTypes';
import type { AxiosError } from 'axios';
import LoadingScreen from '@/components/LoadingScreen.vue';
import Cookies from 'universal-cookie'
const cookies = new Cookies(null, { path: '/'});

interface LoginTypes {
    username: string,
    password: string
}

interface LoginErrorTypes {
    username?: string[],
    password?: string[],
}

const model = ref<LoginTypes>({
    username: '',
    password: ''
})
const errors = ref<LoginErrorTypes>({})
const loading = ref<boolean>(true)

onBeforeMount(async () => {
    const authenticated = await isUserAuthenticated()

    if(authenticated) {
        router.push('/')
    }
})

async function isUserAuthenticated(): Promise<boolean> {
  const authStore = useAuthStore()
  loading.value = true
  
  try {
    if(cookies.get('token') && !axios.defaults.headers.common.Authorization) {
      axios.defaults.headers.common['Authorization'] = `Bearer ${cookies.get('token')}`
    }

    const res = await axios.get('/getuserdetails', {params: { requiresLogin: false}})

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
  finally {
    loading.value = false
  }
}

function login() {
    axios.get('http://localhost:8000/sanctum/csrf-cookie').then(response => {
        const authStore = useAuthStore()
        axios.post('/login', model.value)
        .then((res) => {
            authStore.storeToken(res.data.token.plainTextToken)
            authStore.setUser(res.data.user)
            router.push({name: 'albums'})
        })
        .catch((err) => {
            if(err.response.status === 422) {
                errors.value = err.response.data.errors
            }
        })
    });
    
}
</script>
<style scoped>

</style>