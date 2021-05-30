<template>
  <div class="systemContentHome">
    <div
      class="md-layout md-gutter md-content container-fluid-home"
      v-if="rule_type == true"
    >
      <div class="md-layout-item">
        Seja bem vindo(a) <b>{{this.$cookies.get('first_name')}}</b>
      </div>
    </div>

      <div class="flex py-12">
        <div
          v-for="column in columns"
          :key="column.title"
          class="bg-gray-100 rounded-lg px-3 py-3 column-width rounded mr-4"
        >
          <div class="column-head">
          <p class="text-gray-700 left font-semibold font-sans tracking-wide text-sm">{{column.title}}</p>
          <p class="text-gray-700 right font-semibold font-sans tracking-wide text-sm">{{column.qtd}}</p>
          </div>
          <!-- Draggable component comes from vuedraggable. It provides drag & drop functionality -->
          <draggable :list="column.tickets" @change="update($event, column.id)" :animation="200" ghost-class="ghost-card" group="tickets">
            <!-- Each element from here will be draggable and animated. Note :key is very important here to be unique both for draggable and animations to be smooth & consistent. -->
            <task-card
              v-for="(ticket) in column.tickets"
              :key="ticket.id"
              :task="ticket"
              class="mt-3 cursor-move"
            ></task-card>
            <!-- </transition-group> -->
          </draggable>
        </div>
      </div>

  </div>
</template>

<script>
import draggable from "vuedraggable";
import TaskCard from "../../components/TaskCard.vue";
export default {
  name: "home",
  components: {
    TaskCard,
    draggable
  },
  props: {
    rule_type: Boolean,
  },
  data() {
    return {
      dashResult: {},
      columns: []
    };
  },
  computed: {
    config() {
      const config = {
        headers: {
          Authorization: `Bearer ${this.$cookies.get("token")}`,
        },
      };
      return config;
    },

  },

  methods: {

    update(event, status) {
        if (event.added) {
        console.log(event);
        console.log(status);

        event.added.element.status_id = status

        this.$http.patch(
          "tickets",
          event.added.element.id,
          event.added.element
        )

      }

      setTimeout(() => {
        this.getDashboard()
      }, 100);

    },

    // Dashboard de Administrador
    getDashboard() {
      this.$http.get(
        "dashboard",
        (res) => {
          this.dashResult = res.data.data;

          this.columns = [
            {
              title: "Novo",
              id: 1,
              qtd: this.dashResult.ticketsOpen.qtd,
              tickets: this.dashResult.ticketsOpen.data
            },
            {
              id: 2,
              title: "Em atendimento",
              qtd: this.dashResult.ticketsInProgress.qtd,
              tickets: this.dashResult.ticketsInProgress.data
            },
            {
              id: 3,
              title: "Pendentes",
              qtd: this.dashResult.ticketsPending.qtd,
              tickets: this.dashResult.ticketsPending.data
            },
            {
              id: 4,
              title: "Solucionados",
              qtd: this.dashResult.ticketsFinish.qtd,
              tickets: this.dashResult.ticketsFinish.data
            }
          ]
        },
        (err) => {
          console.error(err);
        }
      );
    },
  },

  mounted() {
    this.getDashboard();
  },
};
</script>

<style scoped>
.column-head {
  padding-bottom: 20px;
}

.column-width {
  /* min-width: 320px; */
  width: 320px;
}
/* Unfortunately @apply cannot be setup in codesandbox, 
but you'd use "@apply border opacity-50 border-blue-500 bg-gray-200" here */
.ghost-card {
  opacity: 0.5;
  background: #F7FAFC;
  border: 1px solid #4299e1;
}
</style>