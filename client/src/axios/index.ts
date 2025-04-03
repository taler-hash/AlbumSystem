import axios from "axios";
import router from "@/router";

axios.defaults.headers.common['Accept'] = 'application/json';
axios.defaults.baseURL = 'http://localhost:8000/api';
axios.defaults.withCredentials = true;
axios.defaults.withXSRFToken = true;

axios.interceptors.response.use(
    function (config) {
        return config
    },
    function (err) {
        if(!err?.config?.params?.noAuth && err.code === "ERR_NETWORK") {
            router.push({name: 'login'})
        } 

        return Promise.reject(err);
    }
)

export default axios