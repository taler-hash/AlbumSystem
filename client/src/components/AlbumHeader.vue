<template>
    <div class="album-header">
        <div class="album-header-wrapper">
            <div class="searchbrar-wrapper">
                <div class="input-wrapper">
                    <input type="text" v-model="filterSearch" @input="keypress" placeholder="Type to search...">
                </div>
            </div>
            <div class="account-wrapper">
                <p class="profile" @click="onshowSettings">{{ getFirstLetter(authStore.user?.name ?? '') }}</p>
                <div v-if="showSettings" class="account-settings"> 
                    <div class="account-settings-wrapper">
                        <div class="account-settings-wrapper-option-name">
                            <p>{{ authStore.user?.name }}</p>
                        </div>
                        <div class="account-settings-wrapper-option-logout">
                            <button @click="logout">
                                <LogOut /> 
                                Logout
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script setup lang="ts">
import { useAuthStore } from '@/stores/auth';
import { inject, ref, type WritableComputedRef } from 'vue';
import { getAlbumsKey, filterSearchKey } from '@/types/InjectionKeys';
import { useDebounceFn } from '@vueuse/core'
import { LogOut } from 'lucide-vue-next';
import axios from 'axios';
import router from '@/router';

const filterSearch = inject<WritableComputedRef<string>>(filterSearchKey)
const getAlbums = inject<(load: boolean) => void>(getAlbumsKey)
const authStore = useAuthStore()
const showSettings = ref<boolean>(false)

const keypress = useDebounceFn(() => {
    getAlbums && getAlbums(true)
}, 1000)

function getFirstLetter(value: string) {
    return value.charAt(0).toUpperCase()
}

function onshowSettings() {
    showSettings.value = !showSettings.value
}

function logout() {
    axios.post('/logout')
    .then(() => {
        router.push({name: 'login'})
    })
    .catch(err => {
        console.error(err)
    })
}

</script>