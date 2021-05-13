<template>
  <div>
    <div class="md-layout md-gutter md-content">
      <div class="md-layout-item md-size-100 contentCard">
        <md-card class="cardConfig">
          <md-card-header>
            <md-card-header-text>
              <div class="md-title">Páginas</div>
              <div class="md-subhead">
                Aqui você pode adicionar quantas páginas quiser.
              </div>
            </md-card-header-text>

            <md-menu md-size="big" md-direction="bottom-end">
              <md-button
                class="md-icon-button"
                @click="viewFormPages()"
                md-menu-trigger
              >
                <md-icon>add_circle_outline</md-icon>
              </md-button>
            </md-menu>
          </md-card-header>

          <md-card-content>

            <md-dialog :md-active.sync="newPage">
              <md-dialog-title>{{ titlePage }}</md-dialog-title>

              <form @submit.prevent="sendPage">
                <div class="md-layout">
                  <div class="md-layout-item md-small-size-100 md-size-30">
                    <md-field>
                      <label>Título da Página</label>
                      <md-input v-model="page.title" type="text"></md-input>
                    </md-field>
                  </div>
                  <div class="md-layout-item md-small-size-100 md-size-30">
                    <md-field>
                      <label>Caminho</label>
                      <md-input v-model="page.href" type="text"></md-input>
                    </md-field>
                  </div>
                  <div class="md-layout-item md-small-size-100 md-size-100">
                    <md-field maxlength="5">
                      <label>Descrição</label>
                      <md-textarea v-model="page.description"></md-textarea>
                    </md-field>
                  </div>
                  <div class="switch md-layout-item md-small-size-100 md-size-20">
                    <label>Status</label><br>
                    <md-switch v-model="page.status">{{
                      status(page.status)
                    }}</md-switch>
                  </div>
                  <div class="switch md-layout-item md-small-size-100 md-size-20">
                    <label>Abrir em nova aba</label>
                    <md-switch value="_blank" v-model="page.target">{{
                      target(page.target)
                    }}</md-switch>
                  </div>
                  <div class="md-layout-item md-size-100">
                    <md-button
                      class="md-raised md-success left"
                      @click="newPage = false"
                      >Fechar</md-button
                    >
                    <md-button
                      class="md-raised md-success right"
                      type="submit"
                      @click="newPage = false"
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
                    <md-table-head>Ordem</md-table-head>
                    <md-table-head>Página</md-table-head>
                    <md-table-head>Descrição</md-table-head>
                    <md-table-head>Status</md-table-head>
                    <md-table-head class="textCenter">Ações</md-table-head>
                  </md-table-row>
                  <md-table-row v-for="page in pages" :key="page.id">
                    <md-table-cell class="textCenter">
                      <md-button
                        class="md-icon-button"
                        md-menu-trigger
                        @click="up(page)"
                      >
                        <md-icon>arrow_upward</md-icon>
                      </md-button>
                      <md-button
                        class="md-icon-button"
                        md-menu-trigger
                        @click="down(page)"
                      >
                        <md-icon>arrow_downward</md-icon>
                      </md-button>
                    </md-table-cell>
                    <md-table-cell>{{ page.title }}</md-table-cell>
                    <md-table-cell>{{
                      page.description ? page.description : "Sem Descrição"
                    }}</md-table-cell>
                    <md-table-cell
                      ><md-switch
                        @change="updatePage(page.id, page)"
                        v-model="page.status"
                        >{{ status(page.status) }}</md-switch
                      ></md-table-cell
                    >
                    <md-table-cell class="textRight">
                      <md-button
                        v-if="page.target != '_blank'"
                        class="md-icon-button"
                        md-menu-trigger
                        @click="editAdvancedPage(page)"
                      >
                        <md-icon>color_lens</md-icon>
                      </md-button>
                      <md-button
                        class="md-icon-button"
                        md-menu-trigger
                        @click="editPage(page)"
                      >
                        <md-icon>edit</md-icon>
                      </md-button>
                      <md-button
                        v-if="page.home != true"
                        class="md-icon-button"
                        md-menu-trigger
                        @click="removePage(page)"
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
  name: "Pages",
  data() {
    return {
      titlePage: "Nova Página",

      newPage: false,

      pages: [],

      page: {
        service_by_client_id: 0,
        href:"",
        active: false,
        target: "",
        title: "",
        description: "",
        status: true,
      },
    };
  },
  methods: {
    getPages() {
      this.$http.get(
        `sitesPages/${this.$cookies.get("service_by_client_id")}`,
        (res) => {
          this.pages = res.data.data;
        },
        (err) => {
          console.error(err);
        }
      );
    },

    sendPage() {
      if (!this.page.id) {
        console.log(this.$cookies.get("service_by_client_id"));
        this.page.service_by_client_id = parseInt(
          this.$cookies.get("service_by_client_id")
        );

        this.$http.post(
          "sitesPages",
          this.page,
          (res) => {
            this.$swal({
              icon: "success",
              title: "Sucesso!",
              html:
                '<div style="padding-bottom: 2.3em">Página criada com sucesso!</div>',
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
                '<div style="padding-bottom: 2.3em">Não foi possível criar a página!</div>',
              showConfirmButton: false,
              timerProgressBar: true,
              timer: 3000,
            }),
              console.error(err);
          }
        );
      } else {
        this.$http.put(
          "sitesPages",
          this.page.id,
          this.page,
          (res) => {
            this.$swal({
              icon: "success",
              title: "Sucesso!",
              html:
                '<div style="padding-bottom: 2.3em">Página atualizada com sucesso!</div>',
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
                '<div style="padding-bottom: 2.3em">Não foi possível alterar a página!</div>',
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
        this.getPages();
      }, 1000);
    },

    viewFormPages() {
      this.newPage = true;
      this.page = {
        service_by_client_id: 0,
        href: "",
        active: false,
        target: "",
        title: "",
        description: "",
        status: true,
      };
    },

    editPage(page) {
      (this.page = page), (this.newPage = true);
    },

    updatePage(id, page) {
      this.$http.patch(
        `sitesPages/${id}`,
        page,
        (res) => {
          console.log(res);
        },
        (err) => {
          console.log(err);
        }
      );
    },

    removePage(page) {
      this.$swal({
        title: "Exclusão",
        html: "Deseja realmente remover essa página?",
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
            "sitesPage",
            page.id,
            res => {
              this.$swal({
                icon: "success",
                title: "Sucesso!",
                html:
                  '<div style="padding-bottom: 2.3em">Página removida com sucesso!</div>',
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
                  '<div style="padding-bottom: 2.3em">Não foi possível remover a página!</div>',
                showConfirmButton: false,
                timerProgressBar: true,
                timer: 3000,
              })
              console.error(err);
            }
          );

          setTimeout(() => {
            this.getPages();
          }, 1000);
        } else if (result.isDenied) {
          this.$swal({
            icon: "info",
            title: "Tudo Bem!",
            html:
              '<div style="padding-bottom: 2.3em">A Página permanece cadastrada!</div>',
            showConfirmButton: false,
            timerProgressBar: true,
            timer: 3000,
          });
        }
      });
    },

    up(page) {
      
        this.$http.patch(
          "sitesPages/up",
          page.id,
          page,
          (res) => {
            console.log(res);
            this.getPages()
          },
          (err) => {
            console.error(err);
          }
        );

    },

    down(page) {
      
        this.$http.patch(
          "sitesPages/down",
          page.id,
          page,
          (res) => {
            console.log(res);
            this.getPages()
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

    target(target) {
      if (target === "_blank") {
        return "Ativo";
      } else {
        return "Inativo";
      }
    },
  },
  mounted() {
    this.getPages();
  },
};
</script>