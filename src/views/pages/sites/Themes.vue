<template>
  <div>
    <div class="md-layout md-gutter md-content">
      <md-dialog :md-active.sync="newTheme">
        <md-dialog-title>{{ titleTheme }}</md-dialog-title>

        <form enctype="multipart/form-data" @submit.prevent="sendTheme">
          <div class="md-layout">
            <div class="md-layout-item md-small-size-100 md-size-30">
              <center>
                <div class="helper"></div>
                <div class="drop" @dragover.prevent @drop="onDrop">
                  <div class="helper"></div>

                  <label v-if="!image" class="btn">
                    <img :src="tempImage" />
                    <br />
                    <label>Banner</label>
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
                    <md-button class="md-raised md-success" @click="removeFile">
                      Excluir
                    </md-button>
                  </div>
                </div>
              </center>
            </div>
            <div class="md-layout-item md-small-size-100 md-size-20">
              <md-field>
                <label>Título do Tema</label>
                <md-input v-model="theme.title" type="text"></md-input>
              </md-field>
            </div>
            <div class="md-layout-item md-small-size-100 md-size-25">
              <md-field>
                <label>Endereço</label>
                <md-input
                  v-model="theme.src"
                  placeholder="http://"
                  type="text"
                ></md-input>
              </md-field>
            </div>
            <div class="md-layout-item md-small-size-100 md-size-25">
              <md-field>
                <label>Endereço no servidor</label>
                <md-input
                  v-model="theme.src_dir"
                  placeholder="/var/www/NOME_DO_TEMA"
                  type="text"
                ></md-input>
              </md-field>
            </div>
            <div class="md-layout-item md-size-100">
              <md-button
                class="md-raised md-success left"
                @click="newTheme = false"
                >Fechar</md-button
              >
              <md-button
                class="md-raised md-success right"
                type="submit"
                @click="newTheme = false"
                >Salvar</md-button
              >
            </div>
          </div>
        </form>
      </md-dialog>

      <div
        class="md-layout-item md-size-25"
        v-for="theme in themes"
        :key="theme.id"
      >
        <md-card class="card-theme">
          <md-card-media>
            <img :src="getBanner(theme.banner)" />
          </md-card-media>
          <md-card-header>
            <div class="md-title">{{ theme.title }}</div>
            <div class="md-subhead">
              <a class="link" :href="theme.src" target="_blank">
                {{ theme.src }}
              </a>
            </div>
          </md-card-header>
          <md-card-actions>
            <md-switch v-model="configs.theme_id" :value="theme.id" @change="activeTheme(theme.id)">{{configs.theme_id == theme.id ? "Ativo" : "Ativar"}}</md-switch>
            <md-button
              v-if="rule_type == true"
              class="md-icon-button inline-flex"
              @click="editTheme(theme)"
            >
              <md-icon>edit</md-icon>
            </md-button>
            <md-button
              v-if="rule_type == true"
              class="md-icon-button inline-flex"
              @click="removeTheme(theme)"
            >
              <md-icon>delete</md-icon>
            </md-button>
          </md-card-actions>
        </md-card>
      </div>
      <div
        class="md-layout-item md-size-25"
        v-if="rule_type == true"
      >
        <md-card
          class="card-theme pointer addTheme"
          @click.native="viewFormThemes()"
        >
          <md-card-header>
            <md-button class="md-icon-button inline-flex">
              <md-icon>add_circle_outline</md-icon>
            </md-button>
            <div class="md-title btnTitle">Novo Tema</div>
          </md-card-header>

          <md-card-content> </md-card-content>
        </md-card>
      </div>
    </div>

    <div class="md-layout md-gutter md-content" v-if="rule_type == true">
      <div class="md-layout-item md-size-100 contentCard">
        <md-card class="cardConfig">
          <md-card-header>
            <md-card-header-text>
              <div class="md-title">Componentes</div>
              <div class="md-subhead">Componentes para páginas</div>
            </md-card-header-text>

            <md-menu md-size="big" md-direction="bottom-end">
              <md-button
                class="md-icon-button"
                @click="viewFormComponents()"
                md-menu-trigger
              >
                <md-icon>add_circle_outline</md-icon>
              </md-button>
            </md-menu>
          </md-card-header>

          <md-card-content>
            <md-dialog :md-active.sync="newComponent">
              <md-dialog-title>{{ titleComponent }}</md-dialog-title>

              <form @submit.prevent="sendComponent">
                <div class="md-layout">
                  <div class="md-layout-item md-small-size-100 md-size-30">
                    <md-field>
                      <label>Tema</label>
                      <md-select v-model="component.theme_id">
                        <md-option
                          v-for="theme in themes"
                          :key="theme.id"
                          :value="theme.id"
                          >{{ theme.title }}</md-option
                        >
                      </md-select>
                    </md-field>
                  </div>
                  <div class="md-layout-item md-small-size-100 md-size-50">
                    <md-field>
                      <label>Título do Componente</label>
                      <md-input
                        v-model="component.title"
                        type="text"
                      ></md-input>
                    </md-field>
                  </div>
                  <div class="md-layout-item md-size-100">
                    <md-button
                      class="md-raised md-success left"
                      @click="newComponent = false"
                      >Fechar</md-button
                    >
                    <md-button
                      class="md-raised md-success right"
                      type="submit"
                      @click="newComponent = false"
                      >Salvar</md-button
                    >
                  </div>
                </div>
              </form>
            </md-dialog>

            <div class="md-layout md-gutter md-content">
              <div class="md-layout-item md-size-100">
                <md-table>
                  <md-table-row>
                    <md-table-head>Tema</md-table-head>
                    <md-table-head>Componente</md-table-head>
                    <md-table-head class="textCenter">Ações</md-table-head>
                  </md-table-row>
                  <md-table-row
                    v-for="component in components"
                    :key="component.id"
                  >
                    <md-table-cell>{{ component.theme_title }}</md-table-cell>
                    <md-table-cell>{{ component.title }}</md-table-cell>
                    <md-table-cell class="textCenter">
                      <md-button
                        class="md-icon-button"
                        md-menu-trigger
                        @click="editComponent(component)"
                      >
                        <md-icon>edit</md-icon>
                      </md-button>
                      <md-button
                        class="md-icon-button"
                        md-menu-trigger
                        @click="removeComponent(component)"
                      >
                        <md-icon>delete</md-icon>
                      </md-button>
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
export default {
  name: "Themes",
  props: {
    rule_type: Boolean
  },
  data() {
    return {
      newComponent: false,

      titleComponent: "Novo Componente",

      components: [],

      component: {
        theme_id: "",
        title: "",
      },

      titleTheme: "Novo Tema",

      newTheme: false,
      themes: [],
      theme: {
        title: "",
        banner: "",
        src: "",
        src_dir: "",
      },

      file: "",
      image: "",
      tempImage: require("../../../assets/undraw_cabin_hkfr.png"),

      configs: [],
    };
  },
  methods: {

    getConfigs() {
      this.$http.get(
        `sitesConfig/${this.$cookies.get("service_by_client_id")}`,
        (res) => {
          if(res.data.data.length > 0) {
            this.configs = res.data.data[0];
          }
          
        },
        (err) => {
          console.error(err);
        }
      );
    },

    /**
     * Métodos para upload do banner dos temas
     */

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

    /**
     * Cadastro, edição e exclusão de componentes
     */

    getComponents() {
      this.$http.get(
        "components",
        (res) => {
          this.components = res.data.data;
        },
        (err) => {
          console.error(err);
        }
      );
    },

    viewFormComponents() {
      this.newComponent = true;
      this.component = {
        theme_id: "",
        title: "",
      };
    },

    sendComponent() {
      if (!this.component.id) {
        this.$http.post(
          "components",
          this.component,
          (res) => {
            this.$swal({
              icon: "success",
              title: "Sucesso!",
              html:
                '<div style="padding-bottom: 2.3em">Componente criado com sucesso!</div>',
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
                '<div style="padding-bottom: 2.3em">Não foi possível criar o componente!</div>',
              showConfirmButton: false,
              timerProgressBar: true,
              timer: 3000,
            }),
              console.error(err);
          }
        );
      } else {
        this.$http.put(
          "components",
          this.component.id,
          this.component,
          (res) => {
            this.$swal({
              icon: "success",
              title: "Sucesso!",
              html:
                '<div style="padding-bottom: 2.3em">Componente atualizado com sucesso!</div>',
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
                '<div style="padding-bottom: 2.3em">Não foi possível alterar o componente!</div>',
              showConfirmButton: false,
              timerProgressBar: true,
              timer: 3000,
            }),
              console.error(err);
          }
        );
      }

      //Atualiza dinamicamente a lista de páginas
      setTimeout(() => {
        this.getComponents();
      }, 1000);
    },

    editComponent(component) {
      (this.component = component), (this.newComponent = true);
    },

    removeComponent(component) {
      this.$swal({
        title: "Exclusão",
        html: "Deseja realmente remover esse componente?",
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
            "components",
            component.id,
            (res) => {
              this.$swal({
                icon: "success",
                title: "Sucesso!",
                html:
                  '<div style="padding-bottom: 2.3em">Componente removido com sucesso!</div>',
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
                  '<div style="padding-bottom: 2.3em">Não foi possível remover o componente!</div>',
                showConfirmButton: false,
                timerProgressBar: true,
                timer: 3000,
              });
              console.error(err);
            }
          );

          setTimeout(() => {
            this.getComponents();
          }, 1000);
        } else if (result.isDenied) {
          this.$swal({
            icon: "info",
            title: "Tudo Bem!",
            html:
              '<div style="padding-bottom: 2.3em">O componente permanece cadastrado!</div>',
            showConfirmButton: false,
            timerProgressBar: true,
            timer: 3000,
          });
        }
      });
    },

    /**
     * Cadastro, edição e exclusão de temas
     */

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

    getBanner(banner) {
      console.log(this.$http.baseUrl);
      if (banner != "themes/") return `${this.$http.baseUrl}/storage/${banner}`;
      else return "";
    },

    viewFormThemes() {
      this.newTheme = true;
      this.theme = {
        title: "",
        banner: "",
        src: "",
        src_dir: "",
      };
    },

    sendTheme() {
      if (!this.theme.id) {
        this.theme.banner = this.image;

        const formData = new FormData();
        formData.append("file", this.file);
        formData.append("banner", this.file.filename);
        formData.append("title", this.theme.title);
        formData.append("src", this.theme.src);
        formData.append("src_dir", this.theme.src_dir);

        this.$http.post(
          "themes",
          formData,
          (res) => {
            this.$swal({
              icon: "success",
              title: "Sucesso!",
              html:
                '<div style="padding-bottom: 2.3em">Tema criado com sucesso!</div>',
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
                '<div style="padding-bottom: 2.3em">Não foi possível criar o tema!</div>',
              showConfirmButton: false,
              timerProgressBar: true,
              timer: 3000,
            }),
              console.error(err);
          }
        );
      } else {
        this.theme.banner = this.image;

        const formDataPut = new FormData();
        formDataPut.append("file", this.file);
        formDataPut.append("banner", this.file.name);
        formDataPut.append("title", this.theme.title);
        formDataPut.append("src", this.theme.src);
        formDataPut.append("src_dir", this.theme.src_dir);

        this.$http.post(
          `themes/${this.theme.id}`,
          formDataPut,
          (res) => {
            this.$swal({
              icon: "success",
              title: "Sucesso!",
              html:
                '<div style="padding-bottom: 2.3em">Tema atualizado com sucesso!</div>',
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
                '<div style="padding-bottom: 2.3em">Não foi possível alterar o tema!</div>',
              showConfirmButton: false,
              timerProgressBar: true,
              timer: 3000,
            }),
              console.error(err);
          }
        );
      }

      //Atualiza dinamicamente a lista de páginas
      setTimeout(() => {
        this.getThemes();
      }, 1000);
    },

    editTheme(theme) {
      this.theme = theme;
      this.newTheme = true;
    },

    removeTheme(theme) {
      this.$swal({
        title: "Exclusão",
        html: "Deseja realmente remover esse tema?",
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
            "themes",
            theme.id,
            (res) => {
              this.$swal({
                icon: "success",
                title: "Sucesso!",
                html:
                  '<div style="padding-bottom: 2.3em">Tema removido com sucesso!</div>',
                showConfirmButton: false,
                timerProgressBar: true,
                timer: 3000,
              });
              console.log(res);
            },
            (err) => {
              if (err.response.status == 409) {
                var msg = "<br>" + err.response.data.message;
              }
              this.$swal({
                icon: "error",
                title: "Atenção!",
                html: `<div style="padding-bottom: 2.3em">${msg}</div>`,
                showConfirmButton: false,
                timerProgressBar: true,
                timer: 3000,
              });
              console.error(err);
            }
          );

          setTimeout(() => {
            this.getThemes();
          }, 1000);
        } else if (result.isDenied) {
          this.$swal({
            icon: "info",
            title: "Tudo Bem!",
            html:
              '<div style="padding-bottom: 2.3em">O tema permanece cadastrado!</div>',
            showConfirmButton: false,
            timerProgressBar: true,
            timer: 3000,
          });
        }
      });
    },

    activeTheme(theme_id) {
      this.$http.get(
        `activeTheme/${theme_id}/${this.$cookies.get("service_by_client_id")}`,
        (res) => {
          var msg = res.data.message
          this.$swal({
            icon: "success",
            title: "Sucesso!",
            html:
              `<div style="padding-bottom: 2.3em">${msg}</div>`,
            showConfirmButton: false,
            timerProgressBar: true,
            timer: 3000,
          })
          console.log(res);

        },
        (err) => {
          console.error(err);
        }
      );
      this.getConfigs()
    }
  },
  mounted() {
    this.getComponents();
    this.getThemes();
    this.getConfigs();
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
