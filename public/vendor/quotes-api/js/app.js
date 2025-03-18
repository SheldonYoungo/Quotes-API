import './bootstrap';
import { createApp } from 'vue'; // Importa Vue 3
import Quotes from './components/Quotes.vue';


const app = createApp({});

app.component('quotes', Quotes);
app.mount('#app');