  <template>
  <div class="systemContent">
    <div class="md-layout md-content container-fluid">
      <div class="md-layout-item">
        <md-card>
          <md-card-header>
            <div class="md-title">{{ title }}</div>

            <div class="right">
              <span v-if="this.selected.status_id != 4">
                <md-button
                  class="md-icon-button inline-flex"
                  style="margin-right: 10px"
                  v-if="viewFollowTicket == true"
                  @click="
                    (viewUpdateTicket = !viewUpdateTicket),
                      clearFollowTicketForm()
                  "
                >
                  <md-icon>refresh</md-icon>
                </md-button>
              </span>
              <span v-else>
                <md-button
                  class="md-square inline-flex"
                  style="margin-right: 15px"
                  v-if="viewFollowTicket == true"
                  @click="
                    (viewUpdateTicket = !viewUpdateTicket),
                      clearFollowTicketForm()
                  "
                >
                  reabrir ticket
                </md-button>
              </span>
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
            <div v-if="this.tickets.length > 0">
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
                  <md-table-cell md-label="Status" style="width: 140px">
                    <md-badge
                      :class="badgeVariant(item.status_id)"
                      class="md-square"
                      :md-content="item.status"
                    />
                  </md-table-cell>
                  <md-table-cell md-label="Título" md-sort-by="title">
                    {{ item.title }}
                  </md-table-cell>
                  <md-table-cell
                    md-label="Cliente"
                    md-sort-by="client_first_name"
                  >
                    {{ item.client_first_name }} {{ item.client_last_name }}
                  </md-table-cell>
                  <md-table-cell md-label="Usuário">
                    {{ item.first_name }} {{ item.last_name }}
                  </md-table-cell>
                </md-table-row>
              </md-table>
            </div>
            <div class="empty" v-if="add == false && this.tickets.length == 0">
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

            <!-- Atualizações do Ticket selecionado -->
            <div
              class="md-layout md-gutter md-content"
              v-if="viewFollowTicket == true"
            >
              <div
                class="md-layout-item md-size-100"
                v-if="viewUpdateTicket == true"
              >
                <form @submit.prevent="sendUpdateTicketForm">
                  <div class="md-layout-item md-small-size-100 md-size-20">
                    <md-field>
                      <label>Status</label>
                      <md-select
                        v-model="followTicket.status_id"
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
                    </md-field>
                    <vue-editor v-model="followTicket.description"></vue-editor>
                  </div>
                  <div class="md-layout-item md-size-100 textRight">
                    <md-button type="submit" class="md-raised md-success">
                      Atualizar
                    </md-button>
                  </div>
                </form>

                <hr />
              </div>
              <div class="md-layout-item md-size-100">
                <img :src="user" class="iconUserTicket" />
                <p class="nameUserTicket">{{ selected.first_name }}</p>
                <div class="md-layout-item md-size-90 right">
                  <md-card class="card-followTickets">
                    <md-card-content md-alignment="space-between">
                      <md-card-expand>
                        <div class="left">
                          <md-icon>info</md-icon>
                          <div class="ticketUser" v-html="selected.description">
                          </div>
                        </div>
                        <div class="right">
                          {{ selected.created_at }}
                        </div>
                      </md-card-expand>
                    </md-card-content>
                  </md-card>
                </div>
              </div>
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
                          <div class="ticketUser" v-html="data.description">
                          </div>
                        </div>
                        <div class="right">
                          {{ data.created_at }}
                        </div>
                      </md-card-expand>
                    </md-card-content>
                    <md-card-actions md-alignment="space-between">
                      <div>
                        <md-badge
                          class="md-square"
                          :class="badgeVariant(data.status_id)"
                          :md-content="data.status"
                        />
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
                <div
                  class="md-layout-item md-small-size-100"
                  :class="{
                    'md-size-60': this.clients.length != 0,
                    'md-size-80': this.clients.length == 0,
                  }"
                >
                  <md-field>
                    <label>Título</label>
                    <md-input v-model="tickets.title" type="text"></md-input>
                  </md-field>
                </div>
                <div
                  class="md-layout-item md-small-size-100 md-size-20"
                  v-if="this.clients.length != 0"
                >
                  <md-field>
                    <label>Cliente</label>
                    <md-select
                      v-model="tickets.client_id"
                      name="state"
                      id="state"
                    >
                      <md-option
                        v-for="client in clients"
                        :key="client.id"
                        :value="client.id"
                        >{{ client.first_name }}
                        {{ client.last_name }}</md-option
                      >
                    </md-select>
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
                  </md-field>
                  <vue-editor v-model="tickets.description"></vue-editor>
                </div>
                <div class="md-layout-item md-size-100 textRight">
                  <md-button type="submit" class="md-raised md-success">
                    Salvar
                  </md-button>
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

import { VueEditor } from "vue2-editor";

export default {
  name: "clients",
  components: {
    VueEditor,
  },
  data() {
    return {
      title: "",
      data: [],
      tickets: [],
      clients: [],
      statusTicket: [],
      followTickets: [],
      ticket: {
        user_id: "",
        client_id: "",
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
      selected: [],
      viewTicket: true,
      viewFollowTicket: false,
      viewUpdateTicket: false,
      user: require("../../assets/undraw_male_avatar_323b.png"),

      //Imagem de retorno quando não houverem dados cadastrados
      empty: require("../../assets/images/undraw_empty_xct9.png"),
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

    getClients() {
      this.$http.get(
        "clients",
        (res) => (this.clients = res.data.data),
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
      this.tickets.user_id = this.$cookies.get("user_id");
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
        this.$http.patch(
          "tickets",
          this.tickets.id,
          this.tickets,
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

    sendUpdateTicketForm() {
      this.followTicket.ticket_id = this.selected.id;
      this.followTicket.user_id = this.$cookies.get("user_id");

      this.$http.post(
        "followTicket",
        this.followTicket,
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
            console.log(res);
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

      //Atualiza dinamicamente a lista de Tickets
      setTimeout(() => {
        this.getFollowTicketById(this.selected);
        this.cancelFollowTicketForm();
      }, 1000);
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
            this.getFollowTicketById(this.selected);
            this.cancelFollowTicketForm();
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
      var variant = "";
      switch (status_id) {
        case 1:
          variant = "badge-info";
          break;

        case 2:
          variant = "badge-secondary";
          break;

        case 3:
          variant = "badge-warning";
          break;

        case 4:
          variant = "badge-success";
          break;

        case 5:
          variant = "badge-danger";
          break;
      }
      return variant;
    },

    viewForm() {
      this.title = "Novo Ticket";
      this.add = true;
      this.viewTicket = false;
      this.viewFollowTicket = false;
    },

    viewFormService() {
      this.title = "Adicionar Serviço";
      this.add = false;
      this.addService = true;
      this.viewTicket = false;
      this.viewFollowTicket = false;
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
      this.viewUpdateTicket = false;
      this.getTickets();
    },

    cancelFollowTicketForm() {
      this.add = false;
      this.viewTicket = false;
      this.viewFollowTicket = true;
      this.viewUpdateTicket = false;
    },

    clearForm() {
      this.tickets = {
        user_id: "",
        client_id: "",
        status_id: 1,
        title: "",
        description: "",
      };
    },

    clearFollowTicketForm() {
      this.followTicket = {
        status_id: this.selected.status_id,
        description: "",
      };
    },
  },

  mounted() {
    this.title = "Tickets";
    this.getTickets();
    this.getClients();
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