import './bootstrap';
import '../css/app.css';
import { createApp } from 'vue';
import Quotes from './components/Quotes.vue';


const app = createApp({});

app.component('quotes', Quotes);
app.mount('#app');