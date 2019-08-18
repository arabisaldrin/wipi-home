<template>
  <v-dialog v-model="show" v-bind="$attrs">
    <v-card>
      <v-toolbar :color="color" dark>
        <v-icon dark left>{{icon}}</v-icon>
        {{title}}
        <v-spacer></v-spacer>
        <v-btn v-show="allowClose" text icon @click="show = false">
          <v-icon>mdi-close</v-icon>
        </v-btn>
        <slot slot="extension" name="extension"></slot>
      </v-toolbar>
      <v-card-text class="pb-0 pt-2">
        <v-container grid-list-md pa-0 fluid>
          <v-form @submit.prevent="accept(close)">
            <slot></slot>
          </v-form>
        </v-container>
      </v-card-text>
      <v-card-actions>
        <v-spacer></v-spacer>
        <slot name="actions" v-bind="{accept,close}">
          <slot name="actions.close" v-bind="{on : {click : close}}">
            <v-btn text class="mx-1" @click="close">Cancel</v-btn>
          </slot>
          <slot name="actions.accept" v-bind="{on : {click : accept}}">
            <v-btn outlined color="primary" class="mx-1" @click="accept(close)">
              <v-icon left>mdi-check</v-icon>Save
            </v-btn>
          </slot>
        </slot>
      </v-card-actions>
    </v-card>
  </v-dialog>
</template>

<script>
export default {
  props: {
    value: {
      type: Boolean,
      default: false
    },
    allowClose: {
      type: Boolean,
      default: false
    },
    title: {
      type: String
    },
    icon: {
      type: String
    },
    color: {
      type: String,
      default: "primary"
    }
  },
  data() {
    return {
      show: false
    };
  },
  mounted() {
    this.show = true;
  },
  methods: {
    accept(cb) {
      this.$emit("accept", cb);
    },
    close() {
      this.show = false;
    }
  },
  watch: {
    show(val) {
      if (!val) {
        setTimeout(() => {
          this.$router.back();
        }, 300);
      }
    }
  }
};
</script>
