<template>
  <div class="page-container">
    <md-app>
      <md-app-toolbar class="md-primary">
        <div class="md-toolbar-row">
          <div class="md-toolbar-section-start">
            <span class="md-title">manag.io</span>
          </div>
          <div class="md-toolbar-section-end">
            <md-menu md-size="huge" :md-offset-x="-230" :md-offset-y="8">
              <md-button md-menu-trigger>
                <md-icon>notifications</md-icon>
              </md-button>

              <md-menu-content>
                <md-menu-item>My Item 1</md-menu-item>
              </md-menu-content>
            </md-menu>

            <md-menu md-size="huge" :md-offset-x="-200" :md-offset-y="8">
              <md-button md-menu-trigger>
                <md-icon>person</md-icon>
              </md-button>

              <md-menu-content>
                <md-list-item @click="confirmLogout()">
                  <md-icon>meeting_room</md-icon>
                  <span class="md-list-item-text">Sair do sistema</span>
                </md-list-item>
              </md-menu-content>
            </md-menu>
          </div>
        </div>
      </md-app-toolbar>
    </md-app>
  </div>
</template>

<script>
export default {
  name: "Navbar",
  data() {
    return {
      title: "Welcome",
    };
  },

  methods: {
    efetuarLogout() {
      this.$session.destroy();
      this.$store.commit("DESLOGAR_USUARIO");
      this.$router.push("login");
    },

    confirmLogout() {
      this.$swal({
        title: "Logout",
        html: "Deseja realmente sair do sistema?",
        showDenyButton: true,
        reverseButtons: true,
        showClass: {
          popup: "animate__animated animate__fadeIn",
        },
        hideClass: {
          popup: "animate__animated animate__fadeOut",
        },
        denyButtonText: `Cancelar`,
        confirmButtonText: `Sair`,
      }).then((result) => {
        if (result.isConfirmed) {
          this.efetuarLogout();
        }
      });
    },

    toTimestamp(strDate) {
      var datum = Date.parse(strDate);
      return datum / 1000;
    },
  },

  mounted() {
    let now = this.toTimestamp(Date());
    let expire_time = this.$session.get("expire_time");

    setInterval(() => {
      if (now > expire_time) {
        this.efetuarLogout();
        //console.log("Token Expirado");
      } else {
        //console.log("Token Válido");
      }
    }, 10000);
  },

  beforeCreate: function () {
    if (!this.$session.exists()) {
      this.$router.push("login");
    }
  },

  computed: {
    usuarioestaLogado() {
      return Boolean(this.$cookies.get("token"));
    },
  },
};
</script>

<style>
.md-app {
  max-height: 400px;
  border: 1px solid rgba(#000, 0.12);
}

/* Demo purposes only */
.md-drawer {
  width: 230px;
  max-width: calc(100vw - 125px);
}
</style>