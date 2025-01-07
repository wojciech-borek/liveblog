import { createApp } from 'vue'
import App from './App.vue'
import router from './router'
import vuetify from './plugins/vuetify';
import 'vuetify/styles'
import './assets/styles/main.css';

import { createPinia } from 'pinia';

const app = createApp(App)
const pinia = createPinia();


app.use(router)
    .use(vuetify)
    .use(pinia)

app.mount('#app')