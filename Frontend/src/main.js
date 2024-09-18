/**
 * main.js
 *
 * Bootstraps Vuetify and other plugins then mounts the App`
 */

// Plugins
import { registerPlugins } from '@/plugins'

// Components
import App from './App.vue'

// Composables
import { createApp } from 'vue'
import store from './store'
import "@/scss/style.scss";

const app = createApp(App)

app.use(store);
registerPlugins(app)

app.mount('#app')
