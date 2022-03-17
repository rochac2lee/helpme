<template>
  <div class="navbarTop">
    <md-app>
      <md-app-toolbar class="md-primary">
        <div class="md-toolbar-row">
          <div class="md-toolbar-section-start">
            <span class="md-title">help.me</span>
          </div>
          <div class="md-toolbar-section-end notificationsBadge">
            <md-menu md-size="huge" :md-offset-x="-230" :md-offset-y="8">
                <md-badge id="teste" :md-content="qtdNotifications">
                  <md-button @click="$router.push('notifications'), setReadAll()" class="md-icon-button">
                    <md-icon>notifications</md-icon>
                  </md-button>
                </md-badge>

              <md-menu-content>
                <md-list-item v-for="notification in notifications" :key="notification.id">
                  {{ notification.message }}
                </md-list-item>
              </md-menu-content>
            </md-menu>

            <md-menu md-size="huge" :md-offset-x="-200" :md-offset-y="8">
              <md-button class="md-icon-button" md-menu-trigger>
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
      qtdNotifications: null,
      notifications: []
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

    getNotifications() {
      let user_id = this.$cookies.get("user_id")
      this.$http.get(
        `notifications/allUnreaded/${user_id}`,
        res => {
          this.qtdNotifications = res.data.total
        },
        err => {
          console.error(err);
        }
      )

      if (this.qtdNotifications == null || this.qtdNotifications == 0) {
        document.getElementsByClassName("md-badge")[0].classList.add("hidden");
      } else {
        document.getElementsByClassName("md-badge")[0].classList.remove("hidden");
      }
    },

    setReadAll() {
      let user_id = this.$cookies.get("user_id")
      this.$http.get(
        `notifications/readAll/${user_id}`,
        res => {
          console.log(res.data.data)
        },
        err => {
          console.error(err);
        }
      ),
      this.getNotifications()
    }
  },

  mounted() {

    this.getNotifications()  

    setInterval(() => {
      this.getNotifications()  
    }, 5000);

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