<template>
    <div class="container">
        <div class="wrapper">
            <div class="card">
                <div class="card-header">
                    <p class="card-title">Register to Vote</p>
                </div>
                <div class="card-content">
                    <Input v-model="model.name" title="Name" :errors="errors?.name" type="text"/>
                    <Input v-model="model.username" title="Username" :errors="errors?.username" type="text"/>
                    <Input v-model="model.password" title="Password" :errors="errors?.password" type="password"/>
                </div>
                <div class="card-footer">
                    <Button label="Register" @click="register"/>
                </div>
            </div>
        </div>
    </div>
</template>
<script lang="ts" setup>
import Button from '@/components/Button.vue';
import Input from '@/components/Input.vue';
import { useAuthStore } from '@/stores/auth';
import axios from '@/axios';
import { ref } from 'vue';
import router from '@/router';

interface RegisterTypes {
    name: string,
    username: string,
    password: string,
    role: string
}

interface RegisterErrorTypes {
    name?: string[],
    username?: string[],
    password?: string[],
    role?:string[]
}

const model = ref<RegisterTypes>({
    name: '',
    username: '',
    password: '',
    role: 'voter'
})
const errors = ref<RegisterErrorTypes>({})

function register() {
    const authStore = useAuthStore()

    axios.post('/register', model.value)
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
    
}
</script>
<style scoped>

</style>