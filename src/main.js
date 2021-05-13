import Vue from 'vue'
import App from './App.vue'

import provider from './provider'

//Vue Router
import router from './routes/router';

//Importando o axios para todo o projeto
import http from "@/http";

import VueSession from 'vue-session'
Vue.use(VueSession)

//Material Design
import VueMaterial from "vue-material"
import 'vue-material/dist/vue-material.min.css'
import './assets/fonts/MIFont.css'
import 'vue-material/dist/theme/default.css'
Vue.use(VueMaterial)

//Animate CSS
import 'animate.css'

//Sidebar
import VueSidebarMenu from 'vue-sidebar-menu'
import 'vue-sidebar-menu/dist/vue-sidebar-menu.css'
Vue.use(VueSidebarMenu)

//Sweetalert
import Swal from 'vue-sweetalert2';
import 'sweetalert2/dist/sweetalert2.min.css';
const options = {
    confirmButtonColor: '#41b882',
    cancelButtonColor: '#ff7674',
};
Vue.use(Swal, options);

import VueCookies from 'vue-cookies'
Vue.use(VueCookies)

Vue.$cookies.set('token', 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJzeXMiOiJNYW5hZy5pbyIsImRlc2MiOiJTaXN0ZW1hIGRlIEdlc3TDo28gZGUgSWdyZWphcyIsImNvbSI6IkVuY29kZSBEZXYiLCJkZXYiOiJDbGViZXIgTGVlIGRhIFJvY2hhIiwidGFyZ2V0IjoiQ2h1cmNoZXMiLCJwc3MiOiJkZXZFbmNMZWU4NDg2MjVAMjAyMSF-In0.ftJpFnt2AbIKeZkfZMyrilQNViLWLuvubepZladuu0Y')

//Estilos CSS
require('@/assets/css/styles.css')

Vue.prototype.$http = http

Vue.config.productionTip = false

new Vue({
    el: '#app',
    store: provider,
    render: h => h(App),
    router
});