<template>
  <div>
    <button
      @click="sidebarCollapse()"
      class="toggle animate__animated animate__fadeIn"
      :class="{ toggleRight: toggle, animate__fadeOut: !isHovering }"
    >
      <i :class="{ rotate: toggle }" class="fa fa-chevron-left"></i>
    </button>
    <sidebar-menu
      ref="sidebar"
      :menu="menu"
      @mouseover.native="isHovering = true"
      @mouseout.native="hideToggleButton"
      width="350px"
      widthCollapsed="80px"
      :showOneChild="true"
      :hideToggle="true"
      :relative="true"
    />
  </div>
</template>

<script>

export default {
  name: "Sidebar",
  props: {
    collapsed: {
      type: Boolean,
      default: false,
    },
    hideToggle: {
      type: Boolean,
      default: false,
    },
  },
  data() {
    return {
      menu: [],
      isHovering: false,
      toggle: false,
    };
  },
  methods: {
    hideToggleButton() {
      setTimeout(() => {
        this.isHovering = false;
      }, 3000);
      return this.isHovering;
    },
    sidebarCollapse() {
      if (this.$refs["sidebar"].collapsed == false) {
        (this.$refs["sidebar"].collapsed = true), (this.toggle = true);
      } else {
        (this.$refs["sidebar"].collapsed = false), (this.toggle = false);
      }
    },
    agentView() {
      this.$router.push("agentPanel");
    },
  },
  mounted() {
    switch (this.$cookies.get("rule_type")) {
      case "55a54008ad1ba589aa210d2629c1df41":
        this.menu = [
          {
            href: "/home",
            title: "Dashboard",
            icon: "fa fa-home",
          },
          {
            href: "/tickets",
            title: "Chamados",
            icon: "fa fa-laptop-code",
          },
          {
            href: "/clients",
            title: "Clientes",
            icon: "fa fa-address-book",
          },
          {
            href: "/users",
            title: "Usuários",
            icon: "fa fa-users",
          }
        ];

        break;

      case "9e688c58a5487b8eaf69c9e1005ad0bf":
        this.menu = [
          {
            href: "/home",
            title: "Dashboard",
            icon: "fa fa-home",
          },
          {
            href: "/tickets",
            title: "Chamados",
            icon: "fa fa-users",
          }
        ];

        break;

      default:
        break;
    }
  },
};
</script>