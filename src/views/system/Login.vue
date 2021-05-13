<template>
  <div class="page-container login">
    <div class="md-layout">
      <div class="md-layout-item md-small-size-100 md-size-30 loginLeft">
        <h1>Login</h1>

        <form>
          <div class="md-layout-item md-small-size-100 md-size-70">
            <md-field>
              <label>Usuário ou Email</label>
              <md-input
                autofocus
                v-model="user.username"
                type="text"
              ></md-input>
            </md-field>
          </div>

          <div class="md-layout-item md-small-size-100 md-size-70">
            <md-field>
              <label>Senha</label>
              <md-input v-model="user.password" type="password" @keypress.enter="efetuarLogin()"></md-input>
            </md-field>
          </div>

          <md-snackbar
            :md-position="position"
            :md-duration="isInfinity ? Infinity : duration"
            :md-active.sync="showSnackbar"
            md-persistent
          >
            <span>{{msg}}</span>
            <md-button class="md-primary" @click="showSnackbar = false"
              >Ok</md-button
            >
          </md-snackbar>
        </form>

        <md-button
          type="submit"
          @click="efetuarLogin()"
          class="md-raised md-success"
          >Entrar</md-button
        >
      </div>
      <div class="md-layout-item md-small-size-100 md-size-70 loginRight">
        <img :src="logo_managio" width="80%" class="logoLogin" top="15px" />
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: "login",
  data() {
    return {
      user: {
        username: "",
        password: "",
      },
      msg: "",
      showSnackbar: false,
      position: "left",
      duration: 4000,
      isInfinity: false,
      welcome: require("@/assets/images/undraw_Business_decisions_re_84ag.png"),
      logo_managio: require("@/assets/images/managio_logo_dark.png"),
    };
  },
  methods: {
    efetuarLogin() {
      this.showSnackbar = true,
      this.$store
        .dispatch("efetuarLogin", this.user)
        .then(() => {
          this.$session.start();
          this.$session.set("jwt", this.$store.state.token);
          this.$session.set("expire_time", this.$store.state.user.expire_time);
          this.$router.push({ name: "home" }),
          this.msg = "Seja bem vindo"
        })
        .catch(() => {
            this.user = {
                username: "",
                password: "",
            },
            this.msg = "Login ou senha inválidos. Tente Novamente!"
        });
    },
  },
  mounted() {
    if (this.$session.exists()) {
      this.$router.push("home");
    }
  }
};
</script>

<style>
.login .md-layout {
  width: 100%;
  height: 100vh;
  padding-top: 0;
}
.logoLogin {
  padding-top: 15%;
}
.md-snackbar-content .md-button-content {
    color: white;
}
</style>