import { createApp } from 'vue'
import axios from 'axios'
import VueAxios from 'vue-axios'
import App from './App.vue'

const app = createApp(App)
app.use(VueAxios, axios)
app.mount('#app')

// https://stackoverflow.com/questions/64269587/how-to-correctly-import-axios-in-vue-3-after-creating-new-project-with-cli