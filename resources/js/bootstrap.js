import axios from "axios";
window.axios = axios;

axios.defaults.withCredentials = true;
axios.defaults.withXSRFToken = true; // Vue 3 + Axios 1.3+
axios.defaults.headers.common["X-Requested-With"] = "XMLHttpRequest";

window.axios.defaults.headers.common["X-Requested-With"] = "XMLHttpRequest";
