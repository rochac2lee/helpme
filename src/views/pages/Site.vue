<template>
  <div>
    <div class="md-20 hidden">
      <sidebar :menuConfig="true" class="sidebarConfig"></sidebar>
    </div>
    <md-tabs
      :class="{ hidden: !data1.length }"
      class="md-primary tabs tabsConfig /*md-80*/"
      ref="tabs"
      md-sync-route
      md-alignment="centered"
    >
      <md-tab id="tab-voltar" to="/home" md-icon="home"> </md-tab>
      <md-tab id="tab-home" to="/config/home" md-label="Home" exact>
        <div class="md-layout md-gutter md-content">
          <div class="md-layout-item md-size-45 contentCard">
            <md-card class="cardConfig">
              <md-card-header>
                <div class="md-title">Informações</div>
              </md-card-header>

              <md-card-content>
                <div class="md-layout md-gutter md-content">
                  <div class="md-layout-item md-size-100">
                    <md-table v-for="config in data1" :key="config.id">
                      <md-table-row>
                        <md-table-head>Nome do Site</md-table-head>
                        <md-table-cell>
                          {{ config.name }}</md-table-cell
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
                        <md-table-cell>{{
                          status(config.status)
                        }}</md-table-cell>
                      </md-table-row>
                    </md-table>
                  </div>
                </div>
              </md-card-content>
            </md-card>
          </div>
        </div>
      </md-tab>
      <md-tab id="tab-pages" to="/config/pages" md-label="Páginas">
        <Pages></Pages>
      </md-tab>
      <md-tab id="tab-files" to="/config/files" md-label="Arquivos"> </md-tab>
      <md-tab id="tab-emails" to="/config/emails" md-label="Emails"> </md-tab>
      <md-tab id="tab-newsletter" to="/config/newsletter" md-label="Newsletter">
      </md-tab>
      <md-tab id="tab-theme" to="/config/themes" md-label="Temas">
        <Themes :rule_type="rule_type"></Themes>
      </md-tab>
      <md-tab id="tab-database" to="/config/advanced" md-label="Avançado">
        <Advanced></Advanced>
      </md-tab>
    </md-tabs>
    <md-tabs
      :class="{ block: !data1.length }"
      class="md-primary hidden tabs /*md-80*/"
      ref="tabs"
      md-alignment="centered"
    >
      <md-tab
        id="tab-config"
        :class="{ block: !data1.length }"
        md-label="Configurações iniciais"
      >
        <md-steppers :md-active-step.sync="active" md-alternative>
          <md-step id="first" md-label="Bem Vindo!" :md-done.sync="first">
            <div class="md-layout md-gutter">
              <div class="md-layout-item">
                <center>
                  <img class="welcome" :src="welcome" alt="" />
                </center>
              </div>
              <div class="md-layout-item textWelcome">
                <h1>Bem Vindo!</h1>
                <h3>
                  Criamos esse espaço para que você administre seu site de forma
                  fácil e rápida, sem precisar ter conhecimento de
                  programação.<br /><br />
                  Mas para começar, precisamos de algumas informações para
                  configurar seu site, vamos lá?
                </h3>
                <md-button
                  type="submit"
                  class="md-raised md-success right"
                  @click="setDone('first', 'second')"
                >
                  Próximo
                </md-button>
              </div>
            </div>
          </md-step>

          <md-step
            id="second"
            md-label="Configurações"
            :md-error="secondStepError"
            :md-done.sync="second"
          >
            <div class="md-layout md-gutter">
              <form
                enctype="multipart/form-data"
                @submit.prevent="sendInitialConfig"
              >
                <div class="md-layout-item">
                  <center>
                    <div class="helper"></div>
                    <div class="drop" @dragover.prevent @drop="onDrop">
                      <div class="helper"></div>

                      <label v-if="!image" class="btn">
                        <img :src="tempLogo" />
                        <br />
                        <label>Logo</label>
                        <br />
                        <br />
                        <input
                          type="file"
                          ref="file"
                          id="file"
                          name="file"
                          @change="selectFile"
                        />
                      </label>

                      <div class="hidden" v-else v-bind:class="{ image: true }">
                        <img :src="image" alt="" class="img" />
                        <br />
                        <br />
                        <md-button
                          class="md-raised md-success"
                          @click="removeFile"
                        >
                          Excluir
                        </md-button>
                      </div>
                    </div>
                  </center>
                </div>
                <div class="md-layout-item">

                  <div class="md-layout-item md-small-size-100 md-size-45">
                    <md-field>
                      <label>Nome do Site</label>
                      <md-input
                        v-model="siteConfig.name"
                        type="text"
                      ></md-input>
                    </md-field>
                  </div>

                  <div class="md-layout-item md-small-size-100 md-size-45">
                    <md-field>
                      <label>Endereço do Site</label>
                      <md-input
                        v-model="siteConfig.domain"
                        type="text"
                      ></md-input>
                    </md-field>
                  </div>

                  <div class="md-layout-item md-small-size-100 md-size-90">
                    <md-field maxlength="5">
                      <label>Descrição</label>
                      <md-textarea
                        v-model="siteConfig.description"
                      ></md-textarea>
                    </md-field>
                  </div>
                  <div class="md-layout-item md-small-size-100 md-size-90">
                    <md-switch v-model="siteConfig.status">{{
                      status(siteConfig.status)
                    }}</md-switch>
                  </div>
                  <div class="md-layout-item md-size-90 textRight">
                    <md-button
                      type="submit"
                      class="md-raised md-success right"
                      @click="setDone('second', 'third')"
                    >
                      Próximo
                    </md-button>
                  </div>
                </div>
              </form>
            </div>
          </md-step>

          <md-step id="third" md-label="Third Step" :md-done.sync="third">
            <div class="md-layout md-gutter">
              <div class="md-layout-item">
                <center>
                  <img class="congrats" :src="congrats" />
                </center>
              </div>
              <div class="md-layout-item textWelcome">
                <h1>Parabéns!</h1>
                <h3>
                  Agora seu site poderá ser personalizado conforme as sua
                  necessidades.
                </h3>
                <md-button
                  class="md-raised md-success right"
                  @click="setDone('third'), finishConfig()"
                >
                  Finalizar
                </md-button>
              </div>
            </div>
          </md-step>
        </md-steppers>
      </md-tab>
    </md-tabs>
  </div>
</template>

<script>
import Sidebar from "../../components/Sidebar";
import Pages from "../pages/sites/Pages";
import Themes from "../pages/sites/Themes";
import Advanced from "../pages/sites/Advanced";

export default {
  name: "home",
  components: {
    Sidebar,
    Pages,
    Themes,
    Advanced,
  },
  props: {
    rule_type: Boolean
  },
  data() {
    return {
      data1: [],
      data2: [],

      file: "",

      welcome: require("../../assets/undraw_welcome_3gvl.png"),
      inConfig: require("../../assets/undraw_Setup_re_y9w8.png"),
      congrats: require("../../assets/undraw_well_done_i2wr.png"),

      active: "first",
      first: false,
      second: false,
      third: false,
      secondStepError: null,

      siteConfig: {
        service_by_client_id: 0,
        logo: "",
        name: "",
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

      image: "",
      tempLogo: require("../../assets/undraw_cabin_hkfr.png"),

      themes: {},
    };
  },
  methods: {
    setDone(id, index) {
      this[id] = true;

      this.secondStepError = null;

      if (index) {
        this.active = index;
      }
    },

    setError() {
      this.secondStepError = "This is an error!";
    },

    finishConfig() {
      this.$router.push("Home");
    },

    status(status) {
      if (status === true) {
        return "Ativo";
      } else {
        return "Inativo";
      }
    },

    sendInitialConfig() {
      (this.siteConfig.logo = this.image),
        (this.siteConfig.service_by_client_id = parseInt(
          this.$cookies.get("service_by_client_id")
        ));

      const formData = new FormData();
      formData.append("file", this.file);
      formData.append(
        "service_by_client_id",
        this.siteConfig.service_by_client_id
      );
      formData.append("logo", this.file.filename);
      formData.append("name", this.siteConfig.name);
      formData.append("hostname", this.siteConfig.hostname);
      formData.append("domain", this.siteConfig.domain);
      formData.append("theme_id", this.siteConfig.theme_id);
      formData.append("ftp_user", this.siteConfig.ftp_user);
      formData.append("ftp_pass", this.siteConfig.ftp_pass);
      formData.append("db_name", this.siteConfig.db_name);
      formData.append("db_user", this.siteConfig.db_user);
      formData.append("db_pass", this.siteConfig.db_pass);
      formData.append("description", this.siteConfig.description);
      formData.append("status", this.siteConfig.status);

      this.$http.post(
        "sitesConfig",
        formData,
        (res) => {
          console.log(res);
        },
        (err) => {
          console.error(err);
        }
      );
    },

    // Drag and drop (Logo do Cliente)
    onDrop: function (e) {
      e.stopPropagation();
      e.preventDefault();
      var files = e.dataTransfer.files;
      this.createFile(files[0]);
    },

    selectFile(e) {
      this.file = this.$refs.file.files[0];
      var files = e.target.files;
      this.createFile(files[0]);
    },

    createFile(file) {
      if (!file.type.match("image.*")) {
        alert("Selecione uma imagem!");
        return;
      }
      var reader = new FileReader();
      var vm = this;

      reader.onload = function (e) {
        vm.image = e.target.result;
      };
      reader.readAsDataURL(file);
    },

    removeFile() {
      this.image = "";
    },

    getSitesConfig() {
      this.$http.get(
        `sitesConfig/${this.$cookies.get("service_by_client_id")}`,
        (res) => {
          this.data1 = res.data.data;
        },
        (err) => {
          console.error(err);
        }
      );
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
  },

  mounted() {
    if (this.$store.state.service)
      this.$cookies.set("service_by_client_id", this.$store.state.service.id);

    this.getSitesConfig();
    this.getThemes();
  },
};
</script>

<style>
.md-tabs.md-theme-default.md-primary .md-tabs-navigation {
  background-color: var(--cor-bg-principal);
}

.sidebarConfig .v-sidebar-menu.vsm_relative {
  height: 100vh;
}

.md-small-size-100 {
  display: inline-flex;
}

.sidebarConfig .vsm--list {
  padding-top: 64px;
}

.tabs .md-tabs-navigation {
  height: 64px;
}
.tabs .md-tab-nav-button {
  height: 64px;
}

.md-layout {
  padding: 15px;
}

.md-tab {
  width: 100%;
  flex: 1 0 100%;
  padding: 16px;
  background: #fff;
}

.md-card-header + .md-card-content {
  padding-top: 16px;
}

.md-tab .cardConfig .md-card-header .md-title {
  font-size: 20px;
  font-weight: 400;
  line-height: 20px;
}

.contentCard .md-layout {
  padding-top: 0 !important;
  padding-bottom: 0 !important;
}

.contentCard .md-layout-item {
  padding-left: 0 !important;
  padding-right: 0 !important;
  padding: 0;
}

.md-tab .cardConfig .md-card-header {
  color: #fff;
  background-color: #616161;
}

.md-tab .cardConfig .md-card-content {
  background-color: #eee;
}
.md-tab .cardConfig .md-card-content table {
  background-color: #eee;
}

.md-tabs-navigation .md-active {
  background: #3e3e3e;
}
.md-steppers-navigation .md-active {
  background: #fff;
}
.md-stepper .md-active {
  background: #fff;
}

.welcome,
.inConfig,
.congrats {
  width: 80%;
  margin: 0;
}

.textWelcome {
  padding-top: 7%;
}

form {
  display: inherit;
}

.md-menu .md-ripple .md-icon {
  color: #fff !important;
}

.md-steppers.md-theme-default .md-stepper-header.md-active .md-stepper-number,
.md-steppers.md-theme-default .md-stepper-header.md-done .md-stepper-number {
  background-color: #3e3e3e;
  color: #fff;
  color: var(--md-theme-default-text-primary-on-primary, #fff);
}
</style>