<template>
    <div class="card-list">
        <div class="card-list-cover">
            <span>
                <Library />
            </span>
        </div>
        <div class="card-list-content-wrapper">
            <div class="card-list-header">{{ props?.album?.name }}</div>
            <div class="card-list-content">
                <div class="details">
                    <div class="details-key">Artist Name:</div>
                    <div class="detauls-value">{{ props?.album?.artist_name }}</div>
                </div>
            </div>
            <div class="card-list-footer">
                <div class="card-list-footer-vote">
                    <button class="upvote-button" @click="vote(true ,props?.album?.name, props?.album?.id)">
                        <Heart />
                    </button>
                    <div class="upvotes">{{ props?.album?.upvotes_count }}</div>
                    <button class="downvote-button" @click="vote(false ,props?.album?.name, props?.album?.id)">
                        <Frown />
                    </button>
                </div>
                <div v-if="authStore.user?.roles?.some((role) => role.name === 'admin')" class="card-list-footer-delete">
                    <button class="delete-button" @click="deleteAlbum(props?.album?.name, props?.album?.id)">
                        <Trash2 />
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>
<script lang="ts" setup>
import axios from 'axios';
import { Heart, Frown, Library, Trash2 } from 'lucide-vue-next';
import { toast} from 'vue3-toastify';
import { useAuthStore } from '@/stores/auth';
import { inject } from 'vue';
import { getAlbumsKey } from '@/types/InjectionKeys';
import { onBeforeMount } from 'vue';

const authStore = useAuthStore()
const getAlbums = inject<(load: boolean) => void>(getAlbumsKey)

const props = defineProps({
    album: {
        type: Object
    }
})

function vote(_vote: boolean,album: string, album_id: number) {
    axios.post('/album/vote', {
        vote: _vote,
        album_id: album_id,
        user_id: authStore?.user?.id
    })
    .then(res => {
        toast(`You ${_vote ? 'upvoted' : 'downvoted'} ${album}!`);
        getAlbums && getAlbums(false);
    })
    .catch(err => {
        if(err.status === 422) {
            toast(`You already ${_vote ? 'upvoted' : 'downvoted'} ${album}!`);
        } else {
            console.error(err)
        }
    })
}

function deleteAlbum(album:string, id: number) {
    axios.delete('/album/delete', {
        data: {id: id}
    })
    .then(res => {
        toast(`Deleted ${album} Album!`)
        getAlbums && getAlbums(false)
    })
    .catch(err => {
        console.error(err)
    })
}

</script>