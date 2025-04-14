import './bootstrap';

import { createApp } from "vue";
import App from "./App.vue";
import router from './router';
import { createPinia, setActivePinia } from 'pinia'
import piniaPluginPersistedstate from 'pinia-plugin-persistedstate'

const app = createApp(App)

const pinia = createPinia()
pinia.use(piniaPluginPersistedstate)

setActivePinia(pinia) 

app.use(pinia)
app.use(router)
app.mount("#app");