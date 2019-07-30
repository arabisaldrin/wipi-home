<template>
  <v-list-item>
    <v-list-item-icon class="mr-3">
      <v-avatar size="30">
        <img src="@/assets/avatars/default.svg" />
      </v-avatar>
    </v-list-item-icon>
    <v-layout column>
      <v-list-item-content style="width : 100%">
        <v-list-item-title>
          {{ title }}
        </v-list-item-title>
        <v-list-item-subtitle>
          {{ content }}
        </v-list-item-subtitle>
      </v-list-item-content>
      <v-layout row pa-0 justify-end>
        <v-btn color="success" outlined class="pa-0 ma-0 mx-1 px-2" small>
          <v-icon small>
            mdi-thumb-up
          </v-icon>
          Like</v-btn
        >
        <v-btn color="primary" outlined class="pa-0 ma-0 px-2" small>
          <v-icon small>
            mdi-open-in-new
          </v-icon>
          View</v-btn
        >
      </v-layout>
    </v-layout>
  </v-list-item>
</template>

<script>
export default {
  props: {
    avatar: {
      type: String
    },
    title: {
      type: String
    },
    content: {
      type: String
    }
  }
}
</script>