<template>
  <v-list-item class="mb-2 notification-item">
    <v-chip v-show="!value.read_at" x-small class="unred-badge" color="primary"></v-chip>
    <v-list-item-icon class="mr-3">
      <v-avatar size="30">
        <img src="@/assets/avatars/default.svg" />
      </v-avatar>
    </v-list-item-icon>
    <v-layout column>
      <v-list-item-content style="width : 100%" class="pb-0">
        <v-list-item-title>{{ title }}</v-list-item-title>
        <v-list-item-subtitle>{{ content }}</v-list-item-subtitle>
      </v-list-item-content>
      <v-layout row pa-0 justify-end ma-0>
        <v-btn
          v-show="!value.read_at"
          color="success"
          outlined
          class="pa-0 ma-0 mx-1 px-2 caption"
          x-small
          @click="markRead(value.id)"
        >Read</v-btn>
        <!--  <v-btn color="primary" outlined class="pa-0 ma-0 px-2" small>
          <v-icon small>mdi-open-in-new</v-icon>View
        </v-btn>-->
      </v-layout>
    </v-layout>
  </v-list-item>
</template>

<script>
import { mapActions } from "vuex";
export default {
  props: {
    value: {
      type: Object
    },
    avatar: {
      type: String
    },
    title: {
      type: String
    },
    content: {
      type: String
    }
  },
  methods: {
    ...mapActions({
      markRead: "notifications/markRead"
    })
  }
};
</script>
  
<style lang="scss">
.notification-item {
  .unred-badge {
    position: absolute;
    right: 5px;
    top: 5px;
    padding: 0 !important;
    height: 10px;
    width: 10px;
  }
}
</style>