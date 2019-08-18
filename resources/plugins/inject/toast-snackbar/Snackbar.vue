<template>
  <v-app style="position : absolute">
    <v-snackbar v-model="show" :timeout="0" :color="item.color" top @click="next">
      {{item.message}}
      <v-chip v-if="queues.length" disabled small class="ml-2 pa-0">{{queues.length || ''}}+ more</v-chip>
      <v-btn icon @click="next">
        <v-icon>mdi-close-circle</v-icon>
      </v-btn>
    </v-snackbar>
  </v-app>
</template>

<script>
export default {
  data() {
    return {
      show: true,
      queues: [],
      timer: null,
      item: {
        message: "",
        color: "",
        timeout: 2000
      }
    };
  },
  methods: {
    queue(option) {
      this.queues.push(option);
      if (!this.timer) this.next();
    },
    next() {
      let vm = this;
      clearTimeout(vm.timer);
      if (!vm.queues.length) {
        vm.show = false;
      } else {
        const opt = vm.queues.shift();
        opt.timeout = opt.timeout || 2000;

        vm.item = opt;

        vm.timer = setTimeout(() => {
          vm.next();
        }, vm.item.timeout);
      }
    }
  },
  watch: {
    show(val) {
      if (!val) {
        setTimeout(() => {
          this.$destroy();
        }, 500);
      }
    }
  }
};
</script>
