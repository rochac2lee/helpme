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

Vue.$cookies.set('token', 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJzeXMiOiJoZWxwbWUiLCJkZXNjIjoiU2lzdGVtYSBkZSBHZXN0w6NvIGRlIENoYW1hZG9zIiwiY29tIjoiRW5jb2RlIERldiIsImRldiI6IkNsZWJlciBMZWUgZGEgUm9jaGEiLCJ0YXJnZXQiOiJUaWNrZXRzIiwicHNzIjoiZGV2RW5jTGVlODQ4NjI1QDIwMjEhfiJ9.vr_fR8zPw194nlvjntglILAYOgPALjPRPA794eZ6yKc')

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