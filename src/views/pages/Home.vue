<template>
  <div>
    <div
      class="md-layout md-gutter textRight md-content"
      v-if="rule_type == true"
    >
      <div class="md-layout-item">
        <md-card>
          <md-card-header>
            <div>Clientes</div>
          </md-card-header>

          <md-card-content>
            <div class="md-title">{{ qtdClients }}</div>
          </md-card-content>
        </md-card>
      </div>
      <div class="md-layout-item">
        <md-card>
          <md-card-header>
            <div>Serviços</div>
          </md-card-header>

          <md-card-content>
            <div class="md-title">{{ qtdServices }}</div>
          </md-card-content>
        </md-card>
      </div>
    </div>
    <div class="md-layout md-gutter md-content" v-else>
      <div
        class="md-layout-item md-size-33"
        v-for="service in services"
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
          </md-card-actions>
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
      qtdClients: 0,
      qtdServices: 0,
      services: [],
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
    
    /**
     * Dashboard de Cliente
     */

    viewServicesByClients() {
      let client_id = this.$cookies.get("client_id");

      this.$http.get(
        `servicesByClients/${client_id}`,
        (res) => (this.services = res.data.data),
        (err) => console.error(err)
      );
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

    status(status) {
      if (status === true) {
        return "Ativo";
      } else {
        return "Inativo";
      }
    },
  },
  mounted() {
    /**
     * Dashboard de Administrador
     */

    //qtd de clientes
    this.$http.get(
      "clients",
      (res) => {
        this.qtdClients = res.data.data.length;
      },
      (err) => {
        console.error(err);
      }
    ),
      //qtd de serviços
      this.$http.get(
        "services",
        (res) => {
          this.qtdServices = res.data.data.length;
        },
        (err) => {
          console.error(err);
        }
      ),
      this.viewServicesByClients();
  },
};
</script>