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
                v-if="viewFollowTicket == true"
                @click="viewFormToEdit(selected)"
              >
                <md-icon>edit</md-icon>
              </md-button>

              <md-button
                class="md-icon-button inline-flex"
                v-if="add == false && viewTicket == true"
                @click="
                  viewForm();
                  clearForm();
                "
              >
                <md-icon>add_circle_outline</md-icon>
              </md-button>

              <md-button
                class="md-icon-button inline-flex"
                v-if="viewTicket == false"
                @click="cancelForm()"
              >
                <md-icon>keyboard_return</md-icon>
              </md-button>
            </div>
          </md-card-header>
          <md-card-content>
            <!-- Listagem -->
            <md-table
              v-model="tickets"
              md-sort="first_name"
              md-sort-order="asc"
              md-card
              md-fixed-header
              v-if="viewTicket == true"
            >
              <md-table-row
                slot="md-table-row"
                slot-scope="{ item }"
                @click="(selected = item), getFollowTicketById(item)"
              >
                <md-table-cell md-label="Status" md-sort-by="status">
                  <md-badge :class="badgeVariant(item.status_id)" class="md-square" :md-content="item.status" />
                </md-table-cell>
                <md-table-cell md-label="Título" md-sort-by="title">
                  {{ item.title }}
                </md-table-cell>
                <md-table-cell md-label="Usuário">
                  {{ item.first_name }} {{ item.last_name }}
                </md-table-cell>
                
              </md-table-row>
            </md-table>

            <!-- Serviços por Cliente -->
            <div
              class="md-layout md-gutter md-content"
              v-if="viewFollowTicket == true"
            >
              <div
                class="md-layout-item md-size-100"
                v-for="data in followTickets"
                :key="data.id"
              >
                <img :src="user" class="iconUserTicket" />
                <p class="nameUserTicket">{{ data.first_name }}</p>
                <div class="md-layout-item md-size-90 right">
                  <md-card class="card-followTickets">
                    <md-card-content md-alignment="space-between">
                      <md-card-expand>
                        <div class="left">
                          <md-icon>info</md-icon>
                        <span class="ticketUser">
                          {{ data.description }}
                        </span>
                      </div>
                        <div class="right">
                          {{ data.created_at }}
                        </div>
                      </md-card-expand>
                      
                    </md-card-content>
                    <md-card-actions md-alignment="space-between">
                      <div>
                        <md-badge class="md-square" :class="badgeVariant(data.status_id)" :md-content="data.status" />
                      </div>
                      <md-button
                        class="md-icon-button inline-flex"
                        @click="removeFollowTicket(data)"
                      >
                        <md-icon>delete</md-icon>
                      </md-button>
                    </md-card-actions>
                  </md-card>
                </div>
              </div>
            </div>

            <!-- Cadastro de Tickets -->
            <div class="md-layout" v-if="add == true">
              <form @submit.prevent="sendForm">
                <div class="md-layout-item md-small-size-100 md-size-80">
                  <md-field>
                    <label>Título</label>
                    <md-input v-model="tickets.title" type="text"></md-input>
                  </md-field>
                </div>
                <div class="md-layout-item md-small-size-100 md-size-20">
                  <md-field>
                    <label>Status</label>
                    <md-select
                      v-model="tickets.status_id"
                      name="state"
                      id="state"
                    >
                      <md-option
                        v-for="status in statusTicket"
                        :key="status.id"
                        :value="status.id"
                        >{{ status.status }}</md-option
                      >
                    </md-select>
                  </md-field>
                </div>
                <div class="md-layout-item md-size-100">
                  <md-field maxlength="5">
                    <label>Descrição</label>
                    <md-textarea v-model="tickets.description"></md-textarea>
                  </md-field>
                </div>
                <div class="md-layout-item md-size-100 textRight">
                  <md-button type="submit" class="md-raised md-success">
                    Salvar
                  </md-button>
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
                      <md-option
                        v-for="service in services"
                        :key="service.id"
                        :value="service.id"
                        >{{ service.service }}</md-option
                      >
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

import VueTheMask from "vue-the-mask";
Vue.use(VueTheMask);

export default {
  name: "clients",
  data() {
    return {
      title: "",
      data: [],
      tickets: [],
      statusTicket: [],
      followTickets: [],
      ticket: {
        user_id: "",
        status_id: "",
        title: "",
        description: "",
      },
      followTicket: {
        user_id: "",
        ticket_id: "",
        status_id: "",
        description: "",
      },
      add: false,
      addService: false,
      selected: "",
      viewTicket: true,
      viewFollowTicket: false,
      user: require("../../assets/undraw_male_avatar_323b.png"),
    };
  },
  methods: {
    getTickets() {
      this.$http.get(
        "tickets",
        (res) => (this.tickets = res.data.data),
        (err) => console.error(err)
      );
    },

    getStatusTicket() {
      this.$http.get(
        "statusTicket",
        (res) => (this.statusTicket = res.data.data),
        (err) => console.error(err)
      );
    },

    getFollowTicketById(ticket) {
      this.viewTicket = false;
      this.title = ticket.title;
      this.viewFollowTicket = true;
      this.$http.get(
        `followTicketById/${ticket.id}`,
        (res) => {
          (this.followTickets = res.data.data), console.log(this.followTickets);
        },
        (err) => console.error(err)
      );
    },

    sendForm() {
      if (!this.tickets.id) {
        this.$http.post(
          "tickets",
          this.tickets,
          (res) => {
            this.$swal({
              icon: "success",
              title: "Sucesso!",
              html:
                '<div style="padding-bottom: 2.3em">Ticket cadastrado com sucesso!</div>',
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
                '<div style="padding-bottom: 2.3em">Não foi possível cadastrar o ticket!</div>',
              showConfirmButton: false,
              timerProgressBar: true,
              timer: 3000,
            }),
              console.error(err);
          }
        );
      } else {
        this.$http.put(
          "tickets",
          this.tickets,
          this.tickets.id,
          (res) => {
            this.$swal({
              icon: "success",
              title: "Sucesso!",
              html:
                '<div style="padding-bottom: 2.3em">Ticket atualizado com sucesso!</div>',
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
                '<div style="padding-bottom: 2.3em">Não foi possível alterar o ticket!</div>',
              showConfirmButton: false,
              timerProgressBar: true,
              timer: 3000,
            }),
              console.error(err);
          }
        );
      }

      //Atualiza dinamicamente a lista de Tickets
      setTimeout(() => {
        this.getTickets();
        this.cancelForm();
      }, 1000);
    },

    sendFormService() {
      this.servicesByClients.client_id = this.selected.id;

      if (!this.servicesByClients.id) {
        this.$http.post(
          "servicesByClients",
          this.servicesByClients,
          (res) => {
            this.$swal({
              icon: "success",
              title: "Sucesso!",
              html:
                '<div style="padding-bottom: 2.3em">Serviço vinculado ao cliente com sucesso!</div>',
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
                '<div style="padding-bottom: 2.3em">Não foi possível vincular o serviço ao cliente!</div>',
              showConfirmButton: false,
              timerProgressBar: true,
              timer: 3000,
            }),
              console.error(err);
          }
        );
      } else {
        this.$http.put(
          "servicesByClients",
          this.servicesByClients,
          this.servicesByClients.id,
          (res) => {
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
          (err) => {
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
          }
        );
      }

      //Atualiza dinamicamente a lista de Tickets
      setTimeout(() => {
        this.getTickets();
        this.cancelForm();
      }, 1000);
    },

    editService(service) {
      switch (service.service_id) {
        case 1:
          this.$router.push({ name: "Home" });
          this.$store.commit("SITE", {
            service: service,
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
            this.getTickets();
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

    removeFollowTicket(data) {
      this.$swal({
        title: "Exclusão",
        html: "Deseja realmente remover esse registro?",
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
            "followTicket",
            `${data.id}`,
            (res) => {
              this.$swal({
                icon: "success",
                title: "Sucesso!",
                html:
                  '<div style="padding-bottom: 2.3em">Registro excluído com sucesso!</div>',
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
                  '<div style="padding-bottom: 2.3em">Não foi possível excluir esse registro!</div>',
                showConfirmButton: false,
                timerProgressBar: true,
                timer: 3000,
              }),
                console.error(err);
            }
          );
          setTimeout(() => {
            this.getFollowTicketById(this.ticket.id);
          }, 1000);
        } else if (result.isDenied) {
          this.$swal({
            icon: "info",
            title: "Tudo Bem!",
            html:
              '<div style="padding-bottom: 2.3em">O registro permanece cadastrado!</div>',
            showConfirmButton: false,
            timerProgressBar: true,
            timer: 3000,
          });
        }
      });
    },

    badgeVariant(status_id) {
      var variant = ""
      switch (status_id) {
        case 1:
          variant = "badge-info"
          break;

        case 2:
          variant = "badge-secondary"
          break;

        case 3:
          variant = "badge-warning"
          break;

        case 4:
          variant = "badge-success"
          break;

        case 5:
          variant = "badge-danger"
          break;
      }
      return variant
    },

    viewForm() {
      this.title = "Novo Ticket";
      this.add = true;
      this.viewTicket = false;
      this.viewFollowTicket = false;
    },

    viewFormService() {
      (this.title = "Adicionar Serviço"),
        (this.add = false),
        (this.addService = true),
        (this.viewTicket = false),
        (this.viewFollowTicket = false);
    },

    viewFormToEdit(ticket) {
      this.add = true;
      this.tickets = ticket;
      this.title = ticket.title;
      this.add = true;
      this.viewFollowTicket = false;
    },

    cancelForm() {
      this.title = "Tickets";
      this.add = false;
      this.viewTicket = true;
      this.viewFollowTicket = false;
      this.getTickets();
    },

    clearForm() {
      this.clients = {
        user_id: "",
        status_id: 1,
        title: "",
        description: "",
      };
    },
  },

  mounted() {
    this.title = "Tickets";
    this.getTickets();
    this.getStatusTicket();
  },
};
</script>

<style scoped>
.card-followTickets {
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