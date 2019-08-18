<template>
  <v-app style="position : absolute">
    <v-dialog :value="true" :max-width="width" persistent @keydown.esc="choose(false)">
      <v-card tile>
        <v-card-title :class="`pa-2 ${color} white--text`">
          <v-icon dark lef>{{ icon }}</v-icon>
          {{ title }}
        </v-card-title>
        <v-card-text class="color pt-2">
          <div class="subtitle-1">{{message}}</div>
          {{subMessage}}
        </v-card-text>
        <v-card-actions>
          <v-checkbox
            v-show="onStop"
            hide-details
            label="Dont show again?"
            class="ma-0 pt-0"
            v-model="stop"
          ></v-checkbox>
          <v-spacer></v-spacer>
          <v-btn text @click="choose(false)">{{negativeText}}</v-btn>
          <v-btn outlined :color="color" @click="choose(true)">{{postiveText}}</v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
  </v-app>
</template>

<script>
export default {
  props: {
    icon: {
      type: String,
      default: "mdi-alert"
    },
    title: {
      type: String,
      default: "Warning"
    },
    postiveText: {
      type: String,
      default: "Yes"
    },
    negativeText: {
      type: String,
      default: "No"
    },
    color: {
      type: String,
      default: "warning"
    },
    message: {
      type: String,
      required: true
    },
    subMessage: {
      type: String
    },
    persistent: {
      type: Boolean,
      default: true
    },
    width: {
      type: Number,
      default: 400
    },
    onStop: {
      default: undefined
    }
  },
  data() {
    return {
      value: true,
      stop: false
    };
  },
  methods: {
    choose(value) {
      this.value = value;
      if (this.stop) this.onStop();

      this.$destroy();
    }
  }
};
</script>
