/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */
import './bootstrap';
import { createApp } from 'vue';
import CKEditor from '@ckeditor/ckeditor5-vue'; 
import VueFaqAccordion from 'vue-faq-accordion';
//Routes
import myrouter from './router';

//Notification
import Faq from './components/Faq.vue';
import FaqTest from './components/FaqTest.vue';

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = createApp(Faq)
app.component('FaqTest', FaqTest);
app
    .use(myrouter)
    .use(CKEditor)
    .use(VueFaqAccordion)
    .mount("#app")
