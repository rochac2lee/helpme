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
            <div v-if="this.data.length > 0">
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
                  @click="(selected = item), viewFormToEdit(item)"
                >
                  <md-table-cell
                    md-label="Nome Completo"
                    md-sort-by="first_name"
                  >
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
            </div>
            <div class="empty" v-if="add == false && this.data.length == 0">
              <div class="md-layout md-gutter md-content">
                <div class="md-layout-item">
                  <img :src="empty" />
                </div>
                <div class="md-layout-item emptyMessage">
                  <h1>Opa!</h1>
                  <h3>Nada para mostrar aqui</h3>
                </div>
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
        status: true,
      },
      states: {},
      citys: {},
      add: false,
      selected: "",
      viewClients: true,

      //Imagem de retorno quando não houverem dados cadastrados
      empty: require("../../assets/images/undraw_empty_xct9.png"),
    };
  },
  methods: {
    getClients() {
      this.$http.get(
        "clients",
        (res) => (this.data = res.data.data),
        (err) => console.error(err)
      );
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
          (res) => {
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
          (err) => {
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
        );
      } else {
        this.$http.put(
          "clients",
          this.clients.id,
          this.clients,
          (res) => {
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
              this.cancelForm();
          },
          (err) => {
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
        );
      }

      //Atualiza dinamicamente a lista de clientes
      setTimeout(() => {
        this.getClients();
        this.cancelForm();
      }, 1000);
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
            (res) => {
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
            (err) => {
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
          );
          setTimeout(() => {
            this.getClients();
            this.cancelForm();
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

    viewForm() {
      this.title = "Adicionar";
      this.add = true;
      this.viewClients = false;
    },

    viewFormToEdit(data) {
      this.clients = data;
      this.getCity();
      this.title = "Editar";
      this.add = true;
      this.viewClients = false;
    },

    cancelForm() {
      this.title = "Clientes";
      this.add = false;
      this.viewClients = true;
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
    this.title = "Clientes";
    this.getClients();
    this.getStates();
  },
};
</script>

<style scoped>
.btnTitle {
  padding-left: 5px;
  line-height: 42px;
}

.pointer {
  cursor: pointer;
}
</style>