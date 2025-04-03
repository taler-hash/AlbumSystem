import './assets/main.css'

import { createApp } from 'vue'
import { createPinia } from 'pinia'
import Vue3Toastify, { type ToastContainerOptions } from 'vue3-toastify';
import 'vue3-toastify/dist/index.css';
import VueAwesomePaginate from "vue-awesome-paginate";
import "vue-awesome-paginate/dist/style.css";
import axios from '@/axios'
import Cookies from 'universal-cookie'
const cookies = new Cookies(null, { path: '/'});
import { useAuthStore } from './stores/auth';

import App from './App.vue'
import router from './router'

const app = createApp(App)
const pinia = createPinia()

app.use(pinia)
app.use(router)
  app.use(VueAwesomePaginate)
  app.use(
      Vue3Toastify,
      {
        autoClose: 3000,
        transition: 'slide',
        hideProgressBar: true,
        position: "bottom-center",
      } as ToastContainerOptions,
    )
  app.mount('#app')
  
export { pinia }
