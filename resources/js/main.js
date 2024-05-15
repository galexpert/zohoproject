import './bootstrap.js';
import { createApp } from 'vue'
import App from './components/App.vue'
import Toast from "vue-toastification"
import "vue-toastification/dist/index.css"

createApp(App).use(Toast).mount('#zohoapp')
