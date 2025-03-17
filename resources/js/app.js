import './bootstrap';
import { createApp } from 'vue'; // Importa Vue 3
import Ejemplo from './components/ejemplo.vue';


const app = createApp({});

app.component('ejemplo', Ejemplo);
app.mount('#app');