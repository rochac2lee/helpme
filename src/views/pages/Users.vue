<template>
  <div class="systemContent">
    <div class="md-layout md-content container-fluid">
      <div class="md-layout-item">
        <md-card>
          <md-card-header>
            <div class="md-title">{{ title }}</div>

            <div class="right">
              <md-button
                class="md-icon-button inline-flex"
                v-if="add == false && viewUsers == true"
                @click="
                  viewForm();
                  clearForm();
                "
              >
                <md-icon>add_circle_outline</md-icon>
              </md-button>

              <md-button
                class="md-icon-button inline-flex"
                v-if="viewUsers == false"
                @click="cancelForm()"
              >
                <md-icon>keyboard_return</md-icon>
              </md-button>
            </div>
          </md-card-header>
          <md-card-content>
            <div v-if="this.users.length > 0">
              <!-- Listagem -->
              <md-table
                v-model="users"
                md-sort="first_name"
                md-sort-order="asc"
                md-card
                md-fixed-header
                v-if="viewUsers == true"
              >
                <md-table-row
                  slot="md-table-row"
                  slot-scope="{ item }"
                  @click="edit(item)"
                >
                  <md-table-cell md-label="Nome Completo">
                    {{ item.first_name }} {{ item.last_name }}
                  </md-table-cell>
                  <md-table-cell md-label="Perfil">{{
                    item.permission
                  }}</md-table-cell>
                  <md-table-cell md-label="Usuário">{{
                    item.username
                  }}</md-table-cell>
                  <md-table-cell md-label="Email">{{
                    item.email
                  }}</md-table-cell>
                </md-table-row>
              </md-table>
            </div>
            <!-- <div class="empty" v-if="add == false && this.users.length == 0">
              <div class="md-layout md-gutter md-content">
                <div class="md-layout-item">
                  <img :src="empty" />
                </div>
                <div class="md-layout-item emptyMessage">
                  <h1>Opa!</h1>
                  <h3>Nada para mostrar aqui</h3>
                </div>
              </div>
            </div> -->

            <!-- Cadastro de usuários -->
            <div class="md-layout" v-if="add == true">
              <form @submit.prevent="sendForm">
                <div class="md-layout-item md-small-size-100 md-size-20">
                  <md-field>
                    <label>Nome</label>
                    <md-input v-model="user.first_name" type="text"></md-input>
                  </md-field>
                </div>
                <div class="md-layout-item md-small-size-100 md-size-20">
                  <md-field>
                    <label>Sobrenome</label>
                    <md-input v-model="user.last_name" type="text"></md-input>
                  </md-field>
                </div>
                <div
                  class="md-layout-item md-small-size-100 md-size-30"
                  v-if="rule_type == true"
                >
                  <md-field>
                    <label>Perfil</label>
                    <md-select
                      v-model="user.permission_id"
                      name="city"
                      id="city"
                    >
                      <md-option value="1">Administrador</md-option>
                      <md-option value="2">Cliente</md-option>
                    </md-select>
                  </md-field>
                </div>
                <div class="md-layout-item md-small-size-100 md-size-30" v-if="user.permission_id == 2">
                  <md-field>
                    <label>Cliente</label>
                    <md-select
                      v-model="user.client_id"
                      name="state"
                      id="state"
                    >
                      <md-option
                        v-for="client in clients"
                        :key="client.id"
                        :value="client.id"
                        >{{ client.first_name }} {{ client.last_name}}</md-option
                      >
                    </md-select>
                  </md-field>
                </div>
                <div class="md-layout-item md-small-size-100 md-size-33">
                  <md-field>
                    <label>Email</label>
                    <md-input v-model="user.email" type="text"></md-input>
                  </md-field>
                </div>
                <div class="md-layout-item md-small-size-100 md-size-33">
                  <md-field>
                    <label>Usuário</label>
                    <md-input v-model="user.username" type="text"></md-input>
                  </md-field>
                </div>
                <div class="md-layout-item md-small-size-100 md-size-33">
                  <md-field>
                    <label>Senha</label>
                    <md-input
                      v-model="user.password"
                      type="password"
                    ></md-input>
                  </md-field>
                </div>
                <div class="switch md-layout-item md-small-size-100 md-size-20">
                  <label>Status</label><br />
                  <md-switch v-model="user.status">{{
                    status(user.status)
                  }}</md-switch>
                </div>
                <div class="switch md-layout-item md-small-size-100 md-size-20">
                  <label>Receber notificações</label>
                  <md-switch v-model="user.notification">{{
                    status(user.notification)
                  }}</md-switch>
                </div>
                <div class="md-layout-item md-size-100 textRight">
                  <md-button
                    @click="remove(user)"
                    class="md-raised md-danger left"
                    >Excluir</md-button
                  >
                  <md-button type="submit" class="md-raised md-success"
                    >Salvar</md-button
                  >
                </div>
              </form>
            </div>
          </md-card-content>
        </md-card>
      </div>
    </div>
  </div>
</template>

  <script>
import Vue from "vue";

import VueTheMask from "vue-the-mask";
Vue.use(VueTheMask);

export default {
  name: "users",
  props: {
    rule_type: Boolean,
  },
  data() {
    return {
      title: "",
      users: [],
      clients: [],

      user: {
        client_id: "",
        first_name: "",
        last_name: "",
        username: "",
        email: "",
        password: "",
        notification: true,
        status: true,
      },

      add: false,
      selected: "",
      viewUsers: true,

      //Imagem de retorno quando não houverem dados cadastrados
      empty: require("../../assets/images/undraw_empty_xct9.png"),
    };
  },
  methods: {
    getUsers() {
      this.$http.get(
        "users",
        (res) => {
          console.log(res.data.data);
          this.users = res.data.data;
        },
        (err) => console.error(err)
      );
    },

    getClients() {
      this.$http.get(
        "clients",
        (res) => (this.clients = res.data.data),
        (err) => console.error(err)
      );
    },

    sendForm() {
      if (!this.user.id) {
        this.$http.post(
          "users",
          this.user,
          (res) => {
            this.$swal({
              icon: "success",
              title: "Sucesso!",
              html:
                '<div style="padding-bottom: 2.3em">Usuário cadastrado com sucesso!</div>',
              showConfirmButton: false,
              timerProgressBar: true,
              timer: 3000,
            }),
              console.log(res);
          },
          (err) => {
            this.$swal({
              icon: "error",
              title: "Atenção!",
              html:
                '<div style="padding-bottom: 2.3em">Não foi possível cadastrar o usuário!</div>',
              showConfirmButton: false,
              timerProgressBar: true,
              timer: 3000,
            }),
              console.error(err);
          }
        );
      } else {
        this.$http.put(
          "users",
          this.user.id,
          this.user,
          (res) => {
            this.$swal({
              icon: "success",
              title: "Sucesso!",
              html:
                '<div style="padding-bottom: 2.3em">Usuário atualizado com sucesso!</div>',
              showConfirmButton: false,
              timerProgressBar: true,
              timer: 3000,
            }),
              console.log(res),
              this.cancelForm();
          },
          (err) => {
            this.$swal({
              icon: "error",
              title: "Atenção!",
              html:
                '<div style="padding-bottom: 2.3em">Não foi possível alterar o usuário!</div>',
              showConfirmButton: false,
              timerProgressBar: true,
              timer: 3000,
            }),
              console.error(err);
          }
        );
      }

      //Atualiza dinamicamente a lista de usuários
      setTimeout(() => {
        this.getUsers();
        this.cancelForm();
      }, 1000);
    },

    remove(data) {
      this.$swal({
        title: "Exclusão",
        html: "Deseja realmente excluir esse usuário?",
        showDenyButton: true,
        reverseButtons: true,
        showClass: {
          popup: "animate__animated animate__fadeIn",
        },
        hideClass: {
          popup: "animate__animated animate__fadeOut",
        },
        denyButtonText: `Cancelar`,
        confirmButtonText: `Excluir`,
      }).then((result) => {
        if (result.isConfirmed) {
          this.$http.delete(
            "users",
            `${data.id}`,
            (res) => {
              this.$swal({
                icon: "success",
                title: "Sucesso!",
                html:
                  '<div style="padding-bottom: 2.3em">Usuário removido com sucesso!</div>',
                showConfirmButton: false,
                timerProgressBar: true,
                timer: 3000,
              }),
                console.log(res);
            },
            (err) => {
              this.$swal({
                icon: "error",
                title: "Atenção!",
                html:
                  '<div style="padding-bottom: 2.3em">Não foi possível excluir o usuário!</div>',
                showConfirmButton: false,
                timerProgressBar: true,
                timer: 3000,
              }),
                console.error(err);
            }
          );
          setTimeout(() => {
            this.getUsers();
            this.cancelForm();
          }, 1000);
        } else if (result.isDenied) {
          this.$swal({
            icon: "info",
            title: "Tudo Bem!",
            html:
              '<div style="padding-bottom: 2.3em">O usuário permanece cadastrado!</div>',
            showConfirmButton: false,
            timerProgressBar: true,
            timer: 3000,
          });
        }
      });
    },

    viewForm() {
      this.title = "Adicionar";
      this.add = true;
      this.viewUsers = false;
    },

    edit(data) {
      console.log(data);
      this.user = data;
      this.viewUsers = false;
      this.title = "Editar";
      this.add = true;
    },

    cancelForm() {
      this.title = "Usuários";
      this.add = false;
      this.viewUsers = true;
    },

    clearForm() {
      this.user = {
        client_id: "",
        first_name: "",
        last_name: "",
        username: "",
        email: "",
        notification: true,
        status: true,
      };
    },

    status(status) {
      if (status === true) {
        return "Ativo";
      } else {
        return "Inativo";
      }
    },
  },

  mounted() {
    this.title = "Usuários";
    this.getClients();
    this.getUsers();
  },
};
</script>

<style scoped>
.card-service {
  background-color: #e9ecef;
}

.addService {
  background-color: #f3f3f3;
  color: #757575;
}

.btnTitle {
  padding-left: 5px;
  line-height: 42px;
}

.pointer {
  cursor: pointer;
}
</style>