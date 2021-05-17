<template>
  <div>


    <div
      class="md-layout md-gutter textRight md-content"
      v-if="rule_type == true"
    >
      <div class="md-layout-item">
        <md-card>
          <md-card-header>
            <div>Ticket Abertos</div>
          </md-card-header>

          <md-card-content>
            <div class="md-title">{{ dashResult.ticketsOpen }}</div>
          </md-card-content>
        </md-card>
      </div>

      <div class="md-layout-item">
        <md-card>
          <md-card-header>
            <div>Tickets no Mês</div>
          </md-card-header>

          <md-card-content>
            <div class="md-title">{{ dashResult.ticketsInMonth }}</div>
          </md-card-content>
        </md-card>
      </div>

      <div class="md-layout-item">
        <md-card>
          <md-card-header>
            <div>Tickets Pendentes</div>
          </md-card-header>

          <md-card-content>
            <div class="md-title">{{ dashResult.ticketsPending }}</div>
          </md-card-content>
        </md-card>
      </div>

    </div>

    <div
      class="md-layout md-gutter textRight md-content"
      v-if="rule_type == true"
    >
      <div class="md-layout-item">
        <md-card>
          <md-card-header>
            <div>Tickets em Atendimento</div>
          </md-card-header>

          <md-card-content>
            <div class="md-title">{{ dashResult.ticketsInProgress }}</div>
          </md-card-content>
        </md-card>
      </div>

      <div class="md-layout-item">
        <md-card>
          <md-card-header>
            <div>Tickets Solucionados</div>
          </md-card-header>

          <md-card-content>
            <div class="md-title">{{ dashResult.ticketsFinish }}</div>
          </md-card-content>
        </md-card>
      </div>

    </div>

  </div>
</template>

<script>
export default {
  name: "home",
  props: {
    rule_type: Boolean,
  },
  data() {
    return {
      dashResult: {},
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

    // Dashboard de Administrador
    getDashboard() {
      this.$http.get(
        "dashboard",
        (res) => {
          this.dashResult = res.data.data;
          console.log(this.dashResult);
        },
        (err) => {
          console.error(err);
        }
      )
    }
  },
  
  mounted() {
    this.getDashboard();
  },
};
</script>