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
      <v-card-text class="pb-0">
        <v-container grid-list-md pa-0 fluid>
          <v-form @submit.prevent="$emit('accept')">
            <slot></slot>
          </v-form>
        </v-container>
      </v-card-text>
      <v-card-actions>
        <v-spacer></v-spacer>
        <slot
          name="actions"
          v-bind:close="() => show = false"
          v-bind:accept="(cb) => $emit('accept',cb)"
        ></slot>
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
