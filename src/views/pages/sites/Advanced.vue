<template>
  <div>
    <!-- Atualização das configurações -->
    <md-dialog :md-active.sync="newConfig">
      <md-dialog-title>{{ titleConfig }}</md-dialog-title>

      <form @submit.prevent="sendConfig">
        <div class="md-layout">
          <div class="md-layout-item md-small-size-100 md-size-25">
            <md-field>
              <label>Nome</label>
              <md-input v-model="config.first_name" type="text"></md-input>
            </md-field>
          </div>
          <div class="md-layout-item md-small-size-100 md-size-25">
            <md-field>
              <label>Sobrenome</label>
              <md-input v-model="config.last_name" type="text"></md-input>
            </md-field>
          </div>
          <div class="md-layout-item md-small-size-100 md-size-30">
            <md-field>
              <label>Endereço do Site</label>
              <md-input
                v-model="config.domain"
                placeholder="https://"
                type="text"
              ></md-input>
            </md-field>
          </div>
          <div class="md-layout-item md-small-size-100 md-size-100">
            <h4>Banco de Dados</h4>
          </div>
          <div class="md-layout-item md-small-size-100 md-size-25">
            <md-field>
              <label>Nome</label>
              <md-input v-model="config.db_name" type="text"></md-input>
            </md-field>
          </div>
          <div class="md-layout-item md-small-size-100 md-size-25">
            <md-field>
              <label>Usuário</label>
              <md-input v-model="config.db_user" type="text"></md-input>
            </md-field>
          </div>
          <div class="md-layout-item md-small-size-100 md-size-25">
            <md-field>
              <label>Senha</label>
              <md-input v-model="config.db_pass" type="password"></md-input>
            </md-field>
          </div>
          <div class="md-layout-item md-small-size-100 md-size-100">
            <h4>FTP</h4>
          </div>
          <div class="md-layout-item md-small-size-100 md-size-25">
            <md-field>
              <label>Usuário</label>
              <md-input v-model="config.ftp_user" type="text"></md-input>
            </md-field>
          </div>
          <div class="md-layout-item md-small-size-100 md-size-25">
            <md-field>
              <label>Senha</label>
              <md-input v-model="config.ftp_pass" type="password"></md-input>
            </md-field>
          </div>
          <div class="md-layout-item md-small-size-100 md-size-100">
            <md-switch v-model="config.status">{{
              status(config.status)
            }}</md-switch>
          </div>

          <div class="md-layout-item md-size-100">
            <md-button
              class="md-raised md-success left"
              @click="newConfig = false"
              >Fechar</md-button
            >
            <md-button
              class="md-raised md-success right"
              type="submit"
              @click="newConfig = false"
              >Salvar</md-button
            >
          </div>
        </div>
      </form>
    </md-dialog>

    <!-- Atualização dos dados pessoais -->
    <md-dialog :md-active.sync="newClient">
      <md-dialog-title>{{ titleClient }}</md-dialog-title>

      <form @submit.prevent="sendClient">
        <div class="md-layout">
          <div class="md-layout-item md-small-size-100 md-size-25">
            <md-field>
              <label>Nome</label>
              <md-input v-model="client.first_name" type="text"></md-input>
            </md-field>
          </div>
          <div class="md-layout-item md-small-size-100 md-size-25">
            <md-field>
              <label>Sobrenome</label>
              <md-input v-model="client.last_name" type="text"></md-input>
            </md-field>
          </div>
          <div class="md-layout-item md-small-size-100 md-size-30">
            <md-field>
              <the-mask
                class="md-input"
                v-model="client.phone"
                placeholder="Telefone"
                :mask="['(##) #####-####', '(##) ####-####']"
                trim
              />
            </md-field>
          </div>
          <div class="md-layout-item md-small-size-100 md-size-66">
            <md-field>
              <label>Email</label>
              <md-input v-model="client.email" type="text"></md-input>
            </md-field>
          </div>
          <div class="md-layout-item md-small-size-100 md-size-33">
            <md-field>
              <the-mask
                class="md-input"
                v-model="client.cnpj_cpf"
                placeholder="CNPJ/CPF"
                :mask="['###.###.###-##', '##.###.###/####-##']"
              />
            </md-field>
          </div>
          <div class="md-layout-item md-small-size-100 md-size-100">
            <md-field>
              <label>Endereço</label>
              <md-input v-model="client.address" type="text"></md-input>
            </md-field>
          </div>
          <div class="md-layout-item md-small-size-100 md-size-33">
            <md-field>
              <label>Estado</label>
              <md-select v-model="client.state" name="state" id="state">
                <md-option
                  v-for="state in states"
                  :key="state.sigla"
                  :value="state.sigla"
                  @click.native="getCity()"
                  >{{ state.nome }}</md-option
                >
              </md-select>
            </md-field>
          </div>
          <div class="md-layout-item md-small-size-100 md-size-33">
            <md-field>
              <label>Cidade</label>
              <md-select v-model="client.city" name="city" id="city">
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
                v-model="client.cep"
                placeholder="CEP"
                :mask="['##.###-###']"
              />
            </md-field>
          </div>
          <div class="md-layout-item md-size-100">
            <md-field maxlength="5">
              <label>Descrição</label>
              <md-textarea v-model="client.description"></md-textarea>
            </md-field>
          </div>

          <div class="md-layout-item md-size-100">
            <md-button
              class="md-raised md-success left"
              @click="newClient = false"
              >Fechar</md-button
            >
            <md-button
              class="md-raised md-success right"
              type="submit"
              @click="newClient = false"
              >Salvar</md-button
            >
          </div>
        </div>
      </form>
    </md-dialog>

    <div class="md-layout md-gutter md-content">
      <!-- Visualização das configurações -->
      <div
        class="md-layout-item md-size-50 contentCard"
        v-for="config in configs"
        :key="config.id"
      >
        <md-card class="cardConfig">
          <md-card-header>
            <md-card-header-text>
              <div class="md-title">Configurações Avançadas</div>
              <div class="md-subhead">Informações de gestão do site</div>
            </md-card-header-text>

            <md-menu md-size="big" md-direction="bottom-end">
              <md-button
                class="md-icon-button"
                @click="editConfig(config)"
                md-menu-trigger
              >
                <md-icon>edit</md-icon>
              </md-button>
            </md-menu>
          </md-card-header>

          <md-card-content>
            <div class="md-layout md-gutter md-content">
              <div class="md-layout-item md-size-100">
                <md-table>
                  <md-table-row>
                    <md-table-head>Nome</md-table-head>
                    <md-table-cell>
                      {{ config.first_name }}
                      {{ config.last_name }}</md-table-cell
                    >
                  </md-table-row>

                  <md-table-row v-if="config.hostname">
                    <md-table-head>Servidor</md-table-head>
                    <md-table-cell> {{ config.hostname }}</md-table-cell>
                  </md-table-row>

                  <md-table-row>
                    <md-table-head>Domínio</md-table-head>
                    <md-table-cell
                      ><a :href="config.domain" target="_blank">{{
                        config.domain
                      }}</a></md-table-cell
                    >
                  </md-table-row>

                  <md-table-row>
                    <md-table-head>Status</md-table-head>
                    <md-table-cell>{{ status(config.status) }}</md-table-cell>
                  </md-table-row>

                  <md-table-row>
                    <md-table-head>Tema</md-table-head>
                    <md-table-cell>
                      {{
                        config.theme_id != null
                          ? config.theme_title
                          : "Nenhum tema aplicado"
                      }}</md-table-cell
                    >
                  </md-table-row>

                  <div class="md-subhead">Banco de Dados</div>

                  <md-table-row>
                    <md-table-head>Nome do Banco</md-table-head>
                    <md-table-cell>
                      {{
                        config.db_name != null
                          ? config.db_name
                          : "Não informado"
                      }}</md-table-cell
                    >
                  </md-table-row>

                  <md-table-row>
                    <md-table-head>Usuário</md-table-head>
                    <md-table-cell>
                      {{
                        config.db_user != null
                          ? config.db_user
                          : "Não informado"
                      }}</md-table-cell
                    >
                  </md-table-row>

                  <md-table-row>
                    <md-table-head>Senha</md-table-head>
                    <md-table-cell>
                      <md-field v-if="config.db_pass != null">
                        <md-input
                          :value="config.db_pass"
                          disabled
                          type="password"
                        ></md-input>
                      </md-field>
                      <span v-else>Não Informado</span>
                    </md-table-cell>
                  </md-table-row>

                  <div class="md-subhead">FTP</div>

                  <md-table-row>
                    <md-table-head>Host</md-table-head>
                    <md-table-cell>
                      {{
                        config.hostname != null
                          ? config.hostname
                          : "Não informado"
                      }}</md-table-cell
                    >
                  </md-table-row>

                  <md-table-row>
                    <md-table-head>Usuário</md-table-head>
                    <md-table-cell>
                      {{
                        config.ftp_user != null
                          ? config.ftp_user
                          : "Não informado"
                      }}</md-table-cell
                    >
                  </md-table-row>

                  <md-table-row>
                    <md-table-head>Senha</md-table-head>
                    <md-table-cell>
                      <md-field v-if="config.ftp_pass != null">
                        <md-input
                          :value="config.ftp_pass"
                          disabled
                          type="password"
                        ></md-input>
                      </md-field>
                      <span v-else>Não Informado</span>
                    </md-table-cell>
                  </md-table-row>
                </md-table>
              </div>
            </div>
          </md-card-content>
        </md-card>
      </div>

      <!-- Visualização dos dados pessoais -->
      <div
        class="md-layout-item md-size-50 contentCard"
        v-for="client in clients"
        :key="client.id"
      >
        <md-card class="cardConfig">
          <md-card-header>
            <md-card-header-text>
              <div class="md-title">Dados Pessoais</div>
              <div class="md-subhead">Informações de contato e endereço</div>
            </md-card-header-text>

            <md-menu md-size="big" md-direction="bottom-end">
              <md-button
                class="md-icon-button"
                @click="editClient(client)"
                md-menu-trigger
              >
                <md-icon>edit</md-icon>
              </md-button>
            </md-menu>
          </md-card-header>

          <md-card-content>
            <div class="md-layout md-gutter md-content">
              <div class="md-layout-item md-size-100">
                <md-table>
                  <md-table-row>
                    <md-table-head>Nome</md-table-head>
                    <md-table-cell>
                      {{ client.first_name }}
                      {{ client.last_name }}</md-table-cell
                    >
                  </md-table-row>

                  <md-table-row>
                    <md-table-head>CPF/CNPJ</md-table-head>
                    <md-table-cell>
                      {{
                        client.cnpj_cpf ? client.cnpj_cpf : "Não Informado"
                      }}</md-table-cell
                    >
                  </md-table-row>

                  <md-table-row>
                    <md-table-head>Telefone</md-table-head>
                    <md-table-cell>
                      <the-mask
                        class="md-input hidden"
                        v-model="client.phone"
                        placeholder="Telefone"
                        :mask="['(##) #####-####', '(##) ####-####']"
                        masked
                      />
                      {{ client.phone }}
                    </md-table-cell>
                  </md-table-row>

                  <md-table-row>
                    <md-table-head>Email</md-table-head>
                    <md-table-cell> {{ client.email }}</md-table-cell>
                  </md-table-row>

                  <md-table-row>
                    <md-table-head>Endereço</md-table-head>
                    <md-table-cell>
                      {{ client.address ? client.address + ", " : "" }}
                      {{ client.cep ? client.cep + ", " : "" }}
                      {{ client.city ? client.city + " - " : "" }}
                      {{ client.state ? client.state : "" }}
                    </md-table-cell>
                  </md-table-row>
                </md-table>
              </div>
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
  name: "Advanced",
  data() {
    return {
      titleConfig: "Configurações",
      newConfig: false,
      configs: [],
      config: {
        first_name: "",
        last_name: "",
        service_by_client_id: 0,
        logo: "",
        hostname: "",
        theme_id: "",
        domain: "",
        ftp_user: "",
        ftp_pass: "",
        db_name: "",
        db_user: "",
        db_pass: "",
        description: "",
        status: true,
      },

      themes: [],

      titleClient: "Dados Pessoais",
      newClient: false,
      clients: [],
      client: {
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
    };
  },
  methods: {
    /**
     * Cadastro, edição e exclusão da configuração atual
     */

    getConfigs() {
      this.$http.get(
        `sitesConfig/${this.$cookies.get("service_by_client_id")}`,
        (res) => {
          this.configs = res.data.data;
        },
        (err) => {
          console.error(err);
        }
      );
    },

    status(status) {
      if (status === true) {
        return "Ativo";
      } else {
        return "Inativo";
      }
    },

    viewFormConfig() {
      this.newConfig = true;
      this.config = {
        theme_id: "",
        title: "",
      };
    },

    sendConfig() {
      this.$http.put(
        "sitesConfig",
        this.config.id,
        this.config,
        (res) => {
          this.$swal({
            icon: "success",
            title: "Sucesso!",
            html:
              '<div style="padding-bottom: 2.3em">Configuração atualizada com sucesso!</div>',
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
              '<div style="padding-bottom: 2.3em">Não foi possível alterar a configuração!</div>',
            showConfirmButton: false,
            timerProgressBar: true,
            timer: 3000,
          }),
            console.error(err);
        }
      );

      //Atualiza dinamicamente a lista de páginas
      setTimeout(() => {
        this.getConfigs();
      }, 1000);
    },

    editConfig(config) {
      this.config = config;
      this.newConfig = true;
    },

    removeConfig(config) {
      this.$swal({
        title: "Exclusão",
        html: "Deseja realmente remover a configuração atual?",
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
            "SitesConfig",
            config.id,
            (res) => {
              this.$swal({
                icon: "success",
                title: "Sucesso!",
                html:
                  '<div style="padding-bottom: 2.3em">Configuração removida com sucesso!</div>',
                showConfirmButton: false,
                timerProgressBar: true,
                timer: 3000,
              });
              console.log(res);
            },
            (err) => {
              this.$swal({
                icon: "error",
                title: "Atenção!",
                html:
                  '<div style="padding-bottom: 2.3em">Não foi possível remover a configuração atual!</div>',
                showConfirmButton: false,
                timerProgressBar: true,
                timer: 3000,
              });
              console.error(err);
            }
          );

          setTimeout(() => {
            this.getConfigs();
          }, 1000);
        } else if (result.isDenied) {
          this.$swal({
            icon: "info",
            title: "Tudo Bem!",
            html:
              '<div style="padding-bottom: 2.3em">A configuração atual não foi alterada!</div>',
            showConfirmButton: false,
            timerProgressBar: true,
            timer: 3000,
          });
        }
      });
    },

    getClient() {
      this.$http.get(
        `clientsByServices/${this.$cookies.get("service_by_client_id")}`,
        (res) => {
          this.clients = res.data.data;
        },
        (err) => {
          console.error(err);
        }
      );
    },

    sendClient() {
      this.$http.put(
        "clients",
        this.client.client_id,
        this.client,
        (res) => {
          this.$swal({
            icon: "success",
            title: "Sucesso!",
            html:
              '<div style="padding-bottom: 2.3em">Informações atualizadas com sucesso!</div>',
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
              '<div style="padding-bottom: 2.3em">Não foi possível alterar as informações!</div>',
            showConfirmButton: false,
            timerProgressBar: true,
            timer: 3000,
          }),
            console.error(err);
        }
      );

      //Atualiza dinamicamente a lista de páginas
      setTimeout(() => {
        this.getClient();
      }, 1000);
    },

    editClient(client) {
      this.client = client;
      this.getCity();
      this.newClient = true;
    },

    getThemes() {
      this.$http.get(
        "themes",
        (res) => {
          this.themes = res.data.data;
        },
        (err) => {
          console.error(err);
        }
      );
    },

    getCity() {
      axios
        .get(
          "https://servicodados.ibge.gov.br/api/v1/localidades/estados/" +
            this.client.state +
            "/municipios"
        )
        .then((response) => {
          this.citys = response.data;
        })
        .catch((error) => console.error(error));
    },

    getStates() {
      axios
        .get(
          "https://servicodados.ibge.gov.br/api/v1/localidades/estados?orderBy=nome"
        )
        .then((response) => {
          this.states = response.data;
        })
        .catch((error) => console.error(error));
    },
  },
  mounted() {
    this.getConfigs();
    this.getThemes();
    this.getStates();
    this.getClient();
  },
};
</script>

<style scoped>
.card-theme {
  background-color: #eee;
}

.addTheme {
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
