<template>
  <vue-topprogress ref="topProgress"></vue-topprogress>
</template>

<script>
import { vueTopprogress } from 'vue-top-progress'

export default {
  mounted () {
    this.$refs.topProgress.start()

    setTimeout(() => {
      this.$refs.topProgress.done()
    }, 2000)
  },

  components: {
    vueTopprogress
  }
}
</script>