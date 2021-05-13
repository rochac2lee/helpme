<template>
  <div>
    <div class="md-layout md-gutter md-content">
      <div class="md-layout-item">
        <md-card>
          <md-card-header>
            <div class="md-title">{{ title }}</div>
            <md-button
              class="md-icon-button inline-flex right"
              v-if="add == false"
              @click="viewForm(); clearForm()"
            >
              <md-icon>add_circle_outline</md-icon>
            </md-button>

            <md-button
              class="md-icon-button inline-flex right"
              v-else
              @click="cancelForm();"
            >
              <md-icon>keyboard_return</md-icon>
            </md-button>
          </md-card-header>
          <md-card-content>
            <md-table
              v-model="data"
              md-sort="service"
              md-sort-order="asc"
              md-fixed-header
              v-if="add == false"
            >
              <md-table-row
                slot="md-table-row"
                slot-scope="{ item }"
                @click="viewFormToEdit(item)"
              >
                <md-table-cell md-label="Serviço" md-sort-by="service">
                  {{ item.service }}
                </md-table-cell>
                <md-table-cell md-label="Status" md-sort-by="email">{{
                  item.status == true ? "Ativo" : "Inativo"
                }}</md-table-cell>
              </md-table-row>
            </md-table>

            <!-- Cadastro -->
            <div class="md-layout" v-if="add == true">
              <form @submit.prevent="sendForm">
                <div class="md-layout-item md-small-size-100 md-size-33">
                  <md-field>
                    <label>Serviço</label>
                    <md-input
                      v-model="services.service"
                      type="text"
                    ></md-input>
                  </md-field>
                </div>
                <div class="md-layout-item md-small-size-100 md-size-33">
                  <md-switch v-model="services.status">{{ status }}</md-switch>
                </div>
                <div class="md-layout-item md-size-100 textRight">
                  <md-button @click="remove(services)" class="md-raised md-danger left"
                    >Excluir</md-button>
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
import axios from "axios";

import VueTheMask from "vue-the-mask";
Vue.use(VueTheMask);

export default {
  name: "services",
  data() {
    return {
      title: "",
      data: [],
      services: {
        service: "",
        status: true,
      },
      add: false,
    };
  },
  methods: {
    getservices() {
      this.$http.get(
        "services",
        res => {
          this.data = res.data.data
        },
        err => {
          console.error(err)
        }
      )
    },

    sendForm() {
      if (!this.services.id) {

        this.$http.post(
          "services",
          this.services,
          res => {
            this.$swal({
              icon: "success",
              title: "Sucesso!",
              html:
                '<div style="padding-bottom: 2.3em">Serviço cadastrado com Sucesso!</div>',
              showConfirmButton: false,
              timerProgressBar: true,
              timer: 3000,
            })
            console.log(res);            
          },
          err => {
            this.$swal({
              icon: "error",
              title: "Atenção!",
              html:
                '<div style="padding-bottom: 2.3em">Não foi possível cadastrar o Serviço!</div>',
              showConfirmButton: false,
              timerProgressBar: true,
              timer: 3000,
            })
            console.error(err);            
          }
        )
      } else {

        this.$http.put(
          "services",
          this.services.id,
          this.services,
          res => {
            this.$swal({
              icon: "success",
              title: "Sucesso!",
              html:
                '<div style="padding-bottom: 2.3em">Serviço atualizado com Sucesso!</div>',
              showConfirmButton: false,
              timerProgressBar: true,
              timer: 3000,
            }),
              console.log(res),
              this.cancelForm();  
          },
          err => {
            this.$swal({
              icon: "error",
              title: "Atenção!",
              html:
                '<div style="padding-bottom: 2.3em">Não foi possível alterar o Serviço!</div>',
              showConfirmButton: false,
              timerProgressBar: true,
              timer: 3000,
            }),
              console.error(err);
          }
        )
      }

      //Atualiza dinamicamente a lista de Serviços
      setTimeout(() => {
        this.cancelForm();
        this.getservices();
      }, 1000);
    },

    remove(data) {
      this.$swal({
        title: "Exclusão",
        html: "Deseja realmente excluir esse Serviço?",
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
          axios
            .delete("http://localhost:8000/api/services/" + data.id, this.config)
            .then((response) => {
              this.$swal({
                icon: "success",
                title: "Sucesso!",
                html:
                  '<div style="padding-bottom: 2.3em">Serviço removido com Sucesso!</div>',
                showConfirmButton: false,
                timerProgressBar: true,
                timer: 3000,
              }),
                console.log(response);
            })
            .catch((error) => {
              this.$swal({
                icon: "error",
                title: "Atenção!",
                html:
                  '<div style="padding-bottom: 2.3em">Não foi possível excluir o Serviço!</div>',
                showConfirmButton: false,
                timerProgressBar: true,
                timer: 3000,
              }),
                console.error(error);
            });

          setTimeout(() => {
            this.getservices();
            this.cancelForm();
          }, 1000);
        } else if (result.isDenied) {
          this.$swal({
            icon: "info",
            title: "Tudo Bem!",
            html:
              '<div style="padding-bottom: 2.3em">O Serviço permanece cadastrado!</div>',
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
    },
    viewFormToEdit(data) {
      (this.services = data),
        (this.title = "Editar"),
        (this.add = true);
    },
    cancelForm() {
      (this.title = "Serviços"), (this.add = false);
    },
    clearForm() {
      this.services = {
        service: "",
        status: true,
      }
    }
  },
  computed: {
    status() {
      if (this.services.status === true) {
        return "Ativo";
      } else {
        return "Inativo";
      }
    },
    config() {
      const config = {
        headers: {
          Authorization: `Bearer ${this.$cookies.get("token")}`,
        },
      };
      return config;
    },
  },
  mounted() {
    (this.title = "Serviços"), this.getservices();
  },
};
</script>