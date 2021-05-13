<template>
  <div>
    <vueTopprogress></vueTopprogress>
    <navbar></navbar>
    <div class="main-content">
      <sidebar></sidebar>
      <router-view :rule_type="admin"></router-view>
    </div>
  </div>
</template>

<script>
import vueTopprogress from "../../components/Loading";
import Sidebar from "../../components/Sidebar";
import Navbar from "../../components/Navbar";

export default {
  components: {
    vueTopprogress,
    Sidebar,
    Navbar,
  },
  data() {
    return {
      admin: null,
    };
  },
  mounted() {
    switch (this.$cookies.get("rule_type")) {
      case "55a54008ad1ba589aa210d2629c1df41":
        this.admin = true;

        break;

      case "9e688c58a5487b8eaf69c9e1005ad0bf":
        this.admin = false;

        break;

      default:
        break;
    }
  },
};
</script>

<style>
body {
  background-color: #eee;
}
</style>