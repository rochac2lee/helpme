  <template>
  <div>
    <div class="md-layout md-gutter md-content">
      <div class="md-layout-item">
        <md-card>
          <md-card-header>
            <div class="md-title">{{ title }}</div>

            <div class="right">
              <md-button
                class="md-icon-button inline-flex"
                v-if="viewServices == true"
                @click="viewFormToEdit(selected)"
              >
                <md-icon>edit</md-icon>
              </md-button>

              <md-button
                class="md-icon-button inline-flex"
                v-if="add == false && viewClients == true"
                @click="
                  viewForm();
                  clearForm();
                "
              >
                <md-icon>add_circle_outline</md-icon>
              </md-button>

              <md-button
                class="md-icon-button inline-flex"
                v-if="viewClients == false"
                @click="cancelForm()"
              >
                <md-icon>keyboard_return</md-icon>
              </md-button>
            </div>
          </md-card-header>
          <md-card-content>
            <!-- Listagem -->
            <md-table
              v-model="data"
              md-sort="first_name"
              md-sort-order="asc"
              md-card
              md-fixed-header
              v-if="viewClients == true"
            >
              <md-table-row
                slot="md-table-row"
                slot-scope="{ item }"
                @click="(selected = item), viewServicesByClients(item)"
              >
                <md-table-cell md-label="Nome Completo" md-sort-by="first_name">
                  {{ item.first_name }} {{ item.last_name }}
                </md-table-cell>
                <md-table-cell md-label="Email" md-sort-by="email">{{
                  item.email
                }}</md-table-cell>
                <md-table-cell md-label="Telefone" md-sort-by="phone">
                  <the-mask
                    class="hide"
                    v-model="item.phone"
                    :masked="true"
                    :mask="['(##) ####-####', '(##) #####-####']"
                  />
                  {{ item.phone }}</md-table-cell
                >
              </md-table-row>
            </md-table>

            <!-- Serviços por Cliente -->
            <div
              class="md-layout md-gutter md-content"
              v-if="viewServices == true"
            >
              <div
                class="md-layout-item md-size-33"
                v-for="service in data2"
                :key="service.id"
              >
                <md-card class="card-service">
                  <md-card-header>
                    <div class="md-title">{{ service.title }}</div>
                  </md-card-header>

                  <md-card-content>
                    <div>{{ service.service }} | {{ status(service.status) }}</div>
                    <div>{{ service.description }}</div>
                  </md-card-content>
                  <md-card-actions>
                    <md-button
                      class="md-icon-button inline-flex"
                      @click="editService(service)"
                    >
                      <md-icon>open_in_new</md-icon>
                    </md-button>
                    <md-button
                      class="md-icon-button inline-flex"
                      @click="removeService(service)"
                    >
                      <md-icon>delete</md-icon>
                    </md-button>
                  </md-card-actions>
                </md-card>
              </div>
              <div class="md-layout-item md-size-33">
                <md-card
                  class="card-service pointer addService"
                  @click.native="viewFormService()"
                >
                  <md-card-header>
                    <md-button class="md-icon-button inline-flex">
                      <md-icon>add_circle_outline</md-icon>
                    </md-button>
                    <div class="md-title btnTitle">Novo Serviço</div>
                  </md-card-header>

                  <md-card-content> </md-card-content>
                </md-card>
              </div>
            </div>

            <!-- Cadastro de clientes -->
            <div class="md-layout" v-if="add == true">
              <form @submit.prevent="sendForm">
                <div class="md-layout-item md-small-size-100 md-size-33">
                  <md-field>
                    <label>Nome</label>
                    <md-input
                      v-model="clients.first_name"
                      type="text"
                    ></md-input>
                  </md-field>
                </div>
                <div class="md-layout-item md-small-size-100 md-size-33">
                  <md-field>
                    <label>Sobrenome</label>
                    <md-input
                      v-model="clients.last_name"
                      type="text"
                    ></md-input>
                  </md-field>
                </div>
                <div class="md-layout-item md-small-size-100 md-size-33">
                  <md-field>
                    <the-mask
                      class="md-input"
                      v-model="clients.phone"
                      placeholder="Telefone"
                      :mask="['(##) #####-####', '(##) ####-####']"
                      trim
                    />
                  </md-field>
                </div>
                <div class="md-layout-item md-small-size-100 md-size-66">
                  <md-field>
                    <label>Email</label>
                    <md-input v-model="clients.email" type="text"></md-input>
                  </md-field>
                </div>
                <div class="md-layout-item md-small-size-100 md-size-33">
                  <md-field>
                    <the-mask
                      class="md-input"
                      v-model="clients.cnpj_cpf"
                      placeholder="CNPJ/CPF"
                      :mask="['###.###.###-##', '##.###.###/####-##']"
                    />
                  </md-field>
                </div>
                <div class="md-layout-item md-small-size-100 md-size-100">
                  <md-field>
                    <label>Endereço</label>
                    <md-input v-model="clients.address" type="text"></md-input>
                  </md-field>
                </div>
                <div class="md-layout-item md-small-size-100 md-size-33">
                  <md-field>
                    <label>Estado</label>
                    <md-select v-model="clients.state" name="state" id="state">
                      <md-option
                        v-for="state in states"
                        :key="state.sigla"
                        :value="state.sigla"
                        @click.native="getCity(clients.state)"
                        >{{ state.nome }}</md-option
                      >
                    </md-select>
                  </md-field>
                </div>
                <div class="md-layout-item md-small-size-100 md-size-33">
                  <md-field>
                    <label>Cidade</label>
                    <md-select v-model="clients.city" name="city" id="city">
                      <md-option
                        v-for="city in citys"
                        :key="city.id"
                        :value="city.nome"
                        >{{ city.nome }}</md-option
                      >
                    </md-select>
                  </md-field>
                </div>
                <div class="md-layout-item md-small-size-100 md-size-33">
                  <md-field>
                    <the-mask
                      class="md-input"
                      v-model="clients.cep"
                      placeholder="CEP"
                      :mask="['##.###-###']"
                    />
                  </md-field>
                </div>
                <div class="md-layout-item md-size-100">
                  <md-field maxlength="5">
                    <label>Descrição</label>
                    <md-textarea v-model="clients.description"></md-textarea>
                  </md-field>
                </div>
                <div class="md-layout-item md-size-100">
                  <md-switch v-model="clients.status">{{
                    status(clients.status)
                  }}</md-switch>
                </div>
                <div class="md-layout-item md-size-100 textRight">
                  <md-button
                    @click="remove(clients)"
                    class="md-raised md-danger left"
                    >Excluir</md-button
                  >
                  <md-button type="submit" class="md-raised md-success"
                    >Salvar</md-button
                  >
                </div>
              </form>
            </div>

            <!-- Vincular serviço ao cliente selecionado -->
            <div class="md-layout" v-if="addService == true">
              <form @submit.prevent="sendFormService">
                <div class="md-layout-item md-small-size-100 md-size-33">
                  <md-field>
                    <label>Título</label>
                    <md-input
                      v-model="servicesByClients.title"
                      type="text"
                    ></md-input>
                  </md-field>
                </div>
                <div class="md-layout-item md-small-size-100 md-size-33">
                  <md-field>
                    <md-select
                      v-model="servicesByClients.service_id"
                      placeholder="Serviço"
                    >
                      <md-option v-for="service in services" :key="service.id" :value="service.id">{{ service.service }}</md-option> 
                    </md-select>
                  </md-field>
                </div>
                <div class="md-layout-item md-size-100">
                  <md-field maxlength="5">
                    <label>Descrição</label>
                    <md-textarea
                      v-model="servicesByClients.description"
                    ></md-textarea>
                  </md-field>
                </div>
                <div class="md-layout-item md-size-100">
                  <md-switch v-model="servicesByClients.status">{{
                    status(servicesByClients.status)
                  }}</md-switch>
                </div>
                <div class="md-layout-item md-size-100 textRight">
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
  name: "clients",
  data() {
    return {
      title: "",
      data: [],
      data2: [],
      clients: {
        first_name: "",
        last_name: "",
        phone: "",
        email: "",
        cnpj_cpf: "",
        address: "",
        state: "",
        city: "",
        cep: "",
        description: "",
        status: true
      },
      states: {},
      citys: {},
      servicesByClients: {
        title: "",
        client_id: "",
        service_id: "",
        description: "",
        status: true
      },
      add: false,
      addService: false,
      selected: "",
      viewClients: true,
      viewServices: false,
    };
  },
  methods: {
    getClients() {
      this.$http.get(
        "clients",
        res => this.data = res.data.data,
        err => console.error(err)
      ) 
    },

    getServices() {
      this.$http.get(
        "services",
        res => this.services = res.data.data,
        err => console.error(err)
      ) 
    },

    getCity() {
      axios
        .get(
          "https://servicodados.ibge.gov.br/api/v1/localidades/estados/" +
            this.clients.state +
            "/municipios"
        )
        .then((response) => {
          (this.citys = response.data), console.log(this.citys);
        })
        .catch((error) => console.error(error));
    },

    getStates() {
      axios
        .get(
          "https://servicodados.ibge.gov.br/api/v1/localidades/estados?orderBy=nome"
        )
        .then((response) => {
          (this.states = response.data), console.log(this.states);
        })
        .catch((error) => console.error(error));
    },

    sendForm() {
      if (!this.clients.id) {
        this.$http.post(
          "clients",
          this.clients,
          res => {
            this.$swal({
              icon: "success",
              title: "Sucesso!",
              html:
                '<div style="padding-bottom: 2.3em">Cliente cadastrado com sucesso!</div>',
              showConfirmButton: false,
              timerProgressBar: true,
              timer: 3000,
            }),
            console.log(res);
          },
          err => {
            this.$swal({
              icon: "error",
              title: "Atenção!",
              html:
                '<div style="padding-bottom: 2.3em">Não foi possível cadastrar o cliente!</div>',
              showConfirmButton: false,
              timerProgressBar: true,
              timer: 3000,
            }),
            console.error(err);
          }
        ) 

      } else {

        this.$http.put(
          "clients",
          this.clients,
          this.clients.id,
          res => {
            this.$swal({
              icon: "success",
              title: "Sucesso!",
              html:
                '<div style="padding-bottom: 2.3em">Cliente atualizado com sucesso!</div>',
              showConfirmButton: false,
              timerProgressBar: true,
              timer: 3000,
            }),
            console.log(res),
            this.cancelForm()
          },
          err => {
            this.$swal({
              icon: "error",
              title: "Atenção!",
              html:
                '<div style="padding-bottom: 2.3em">Não foi possível alterar o cliente!</div>',
              showConfirmButton: false,
              timerProgressBar: true,
              timer: 3000,
            }),
            console.error(err);
          }
        ) 
      }

      //Atualiza dinamicamente a lista de clientes
      setTimeout(() => {
        this.getClients();
        this.cancelForm();
      }, 1000);
    },

    sendFormService() {

      this.servicesByClients.client_id = this.selected.id;

      if (!this.servicesByClients.id) {

        this.$http.post(
          "servicesByClients",
          this.servicesByClients,
          res => {
            this.$swal({
              icon: "success",
              title: "Sucesso!",
              html:
                '<div style="padding-bottom: 2.3em">Serviço vinculado ao cliente com sucesso!</div>',
              showConfirmButton: false,
              timerProgressBar: true,
              timer: 3000,
            }),
            console.log(res)
          },
          err => {
            this.$swal({
              icon: "error",
              title: "Atenção!",
              html:
                '<div style="padding-bottom: 2.3em">Não foi possível vincular o serviço ao cliente!</div>',
              showConfirmButton: false,
              timerProgressBar: true,
              timer: 3000,
            }),
            console.error(err)
          }
        )

      } else {

        this.$http.put(
          "servicesByClients",
          this.servicesByClients,
          this.servicesByClients.id,
          res => {
            this.$swal({
              icon: "success",
              title: "Sucesso!",
              html:
                '<div style="padding-bottom: 2.3em">Serviço atualizado com sucesso!</div>',
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
                '<div style="padding-bottom: 2.3em">Não foi possível alterar o serviço!</div>',
              showConfirmButton: false,
              timerProgressBar: true,
              timer: 3000,
            }),
            console.error(err);
          },
        )
      }

      //Atualiza dinamicamente a lista de clientes
      setTimeout(() => {
        this.getClients()
        this.cancelForm()
      }, 1000)

    },

    editService(service) {
      switch (service.service_id) {
        case 1:

          this.$router.push({ name: "Home" });
          this.$store.commit("SITE", {
            service: service
          });
          
          break;
      }
    },

    remove(data) {
      this.$swal({
        title: "Exclusão",
        html: "Deseja realmente excluir esse Cliente?",
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
            "clients",
            `${data.id}`,
            res => {
              this.$swal({
                icon: "success",
                title: "Sucesso!",
                html:
                  '<div style="padding-bottom: 2.3em">Cliente removido com sucesso!</div>',
                showConfirmButton: false,
                timerProgressBar: true,
                timer: 3000,
              }),
              console.log(res);
            },
            err => {
              this.$swal({
                icon: "error",
                title: "Atenção!",
                html:
                  '<div style="padding-bottom: 2.3em">Não foi possível excluir o cliente!</div>',
                showConfirmButton: false,
                timerProgressBar: true,
                timer: 3000,
              }),
              console.error(err);
            }
          )
          setTimeout(() => {
            this.getClients()
            this.cancelForm()
          }, 1000);
        } else if (result.isDenied) {
          this.$swal({
            icon: "info",
            title: "Tudo Bem!",
            html:
              '<div style="padding-bottom: 2.3em">O cliente permanece cadastrado!</div>',
            showConfirmButton: false,
            timerProgressBar: true,
            timer: 3000,
          });
        }
      });
    },

    removeService(data) {
      this.$swal({
        title: "Exclusão",
        html: "Deseja realmente desvincular o serviço desse cliente?",
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
            "servicesByClients",
            `${data.id}`,
            res => {
              this.$swal({
                icon: "success",
                title: "Sucesso!",
                html:
                  '<div style="padding-bottom: 2.3em">Serviço desvinculado do cliente com sucesso!</div>',
                showConfirmButton: false,
                timerProgressBar: true,
                timer: 3000,
              }),
              console.log(res);
            },
            err => {
              this.$swal({
                icon: "error",
                title: "Atenção!",
                html:
                  '<div style="padding-bottom: 2.3em">Não foi possível desvincular o serviço desse cliente!</div>',
                showConfirmButton: false,
                timerProgressBar: true,
                timer: 3000,
              }),
              console.error(err);
            }
          )
          setTimeout(() => {
            this.getClients();
            this.cancelForm();
          }, 1000);
        } else if (result.isDenied) {
          this.$swal({
            icon: "info",
            title: "Tudo Bem!",
            html:
              '<div style="padding-bottom: 2.3em">O serviço permanece vinculado ao cliente!</div>',
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
      this.viewClients = false;
      this.viewServices = false;
    },

    viewFormService() {
      this.title = "Adicionar Serviço",
      this.add = false,
      this.addService = true,
      this.viewClients = false,
      this.viewServices = false
    },

    viewServicesByClients(client) {
      this.title = client.first_name + " " + client.last_name,
      this.viewClients = false,
      this.viewServices = true,

      this.$http.get(
        `servicesByClients/${client.id}`,
        res => this.data2 = res.data.data,
        err => console.error(err)
      )
    },

    viewFormToEdit(data) {
      this.clients = data
      this.getCity()
      this.title = "Editar"
      this.add = true
      this.viewServices = false
    },

    cancelForm() {
      this.title = "Clientes"
      this.add = false
      this.viewClients = true
      this.viewServices = false
      this.addService = false
    },

    clearForm() {
      this.clients = {
        first_name: "",
        last_name: "",
        phone: "",
        email: "",
        cnpj_cpf: "",
        address: "",
        state: "",
        city: "",
        cep: "",
        description: "",
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
    this.title = "Clientes"
    this.getClients()
    this.getStates()
    this.getServices()
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