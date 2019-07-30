<template>
  <page title="Advertisements" scheme="blue-grey">
    <template slot="tools">
      <v-btn fab color="primary" to="add" append>
        <v-icon>mdi-plus</v-icon>
      </v-btn>
      <v-btn fab dark color="green" class="ml-2">
        <v-icon>mdi-printer</v-icon>
      </v-btn>
    </template>
    <v-layout column>
      <v-card>
        <v-data-table :headers="headers" :items="[]" :options.sync="options" item-key="id"></v-data-table>
      </v-card>
    </v-layout>
    <router-view></router-view>
  </page>
</template>

<script>
export default {
  data() {
    return {
      headers: [],
      options: {}
    };
  }
};
</script>
