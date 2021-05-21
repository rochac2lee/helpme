import Vue from "vue"

import Vuex from 'vuex'
Vue.use(Vuex)

var md5 = require("md5")

import http from "@/http"

import VueCookies from 'vue-cookies'
Vue.use(VueCookies)

const state = {
    token: Vue.$cookies.get('token') || '',
    user: ""
}

const mutations = {

    DEFINIR_USUARIO_LOGADO(state, { token, user }) {
        state.token = token
        state.user = user
    },
    DESLOGAR_USUARIO(state) {
        state.user = {}
        Vue.$cookies.set('user_id', "")
    },
    SITE(state, { service }) {
        state.service = service
    }

}

const actions = {
    efetuarLogin({ commit }, user) {
        return new Promise((resolve, reject) => {
            http.post(
                "auth/login",
                user,
                res => {
                    if (res.status === 200 && res.data.data.token) {
                        this.user = res.data.data
                        Vue.$cookies.set('user_id', this.user.id)
                        Vue.$cookies.set('client_id', this.user.client_id)
                        Vue.$cookies.set('first_name', this.user.first_name)
                        Vue.$cookies.set('last_name', this.user.last_name)
                        Vue.$cookies.set('rule_type', md5(this.user.permission_id))
                        Vue.$cookies.set('user_token', res.data.data.token)
                        resolve(res.data.data)

                        commit('DEFINIR_USUARIO_LOGADO', {
                            token: res.data.data.token,
                            user: res.data.data
                        })
                    }
                },
                err => {
                    console.error(err)
                    reject(err)
                }
            )
        })
    }
}

const getters = {
    usuarioEstaLogado: state => Boolean(state.token)
}

export default new Vuex.Store({

    state,
    mutations,
    actions,
    getters

})