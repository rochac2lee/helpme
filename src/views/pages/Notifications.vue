<template>
  <div class="systemContent">
    <div class="md-layout md-content container-fluid">
      <div class="md-layout-item">
        <md-card>
          <md-card-header>
            <div class="md-title">{{ title }}</div>
          </md-card-header>
          <md-card-content>
              <div v-for="notification in notifications" :key="notification.id" class="notification">
                  {{ notification.message }}
              </div>

          </md-card-content>
        </md-card>
      </div>
    </div>
  </div>
</template>

  <script>

export default {
  name: "notifications",
  props: {
    rule_type: Boolean,
  },
  data() {
    return {
      title: "",
      notifications: [],
    };
  },
  methods: {

    getNotifications() {
      let user_id = this.$cookies.get("user_id")
      this.$http.get(
        `notifications/${user_id}`,
        res => {
          this.qtdNotifications = res.data.data.length
          this.notifications = res.data.data
        },
        err => {
          console.error(err);
        }
      )
    }


  },

  mounted() {
    this.title = "Notificações";
    this.getNotifications();
  },
};
</script>

<style scoped>
.card-service {
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