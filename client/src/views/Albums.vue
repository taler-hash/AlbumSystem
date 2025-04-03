<template>
    <div  class="album-container">
        <template v-if="!loading">
            <AlbumHeader />
            <div  class="card-wrapper">
                <template v-for="album in albums">
                    <CardAlbum :album="album"/>
                </template>
            </div>
            <div class="pagination">
                <vue-awesome-paginate
                    :total-items="filters.total"
                    :items-per-page="filters.per_page"
                    :max-pages-shown="filters.per_page"
                    v-model="filters.page"
                    @click="onPage"
                />
            </div>
        </template>
        <LoadingScreen v-else />
    </div>
</template>
<script lang="ts" setup>
import axios from '@/axios';
import { computed, onMounted, ref } from 'vue';
import { useAuthStore } from '@/stores/auth';
import CardAlbum from '@/components/CardAlbum.vue';
import { provide } from 'vue';
import { getAlbumsKey, filterSearchKey } from '@/types/InjectionKeys';
import LoadingScreen from '@/components/LoadingScreen.vue';
import AlbumHeader from '@/components/AlbumHeader.vue';
const authStore = useAuthStore();

interface FilterTypes {
    page: number,
    search: string,
    total?: number,
    per_page?: number
}

interface AlbumTypes {
    name: string,
    artist_name: string,
    upvotes_count?: string
}

const loading = ref<boolean>(true)
const albums = ref<AlbumTypes[]>([])
const filters = ref<FilterTypes>({
    page: 1,
    search: '',
})

onMounted(() => {
    getAlbums()
})

function onPage(page: number) {
    filters.value.page = page

    getAlbums()
}


function getAlbums(load: boolean = true) {
    loading.value = load && true
    axios.get('/albums', {params: filters.value})
    .then((res) => {
        const {per_page, total, data} = res.data

        filters.value.per_page = per_page
        filters.value.total = total
        albums.value = data
    })
    .catch((err) => {
        console.error(err)
    })
    .finally(() => {
        loading.value = load && false
    })
}

provide(getAlbumsKey, getAlbums)
provide(filterSearchKey, computed({
    get: () => filters.value.search,
    set: (val) => filters.value.search = val
}));
</script>