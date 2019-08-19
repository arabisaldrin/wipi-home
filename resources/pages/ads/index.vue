<template>
  <page title="Advertisements" scheme="blue-grey">
    <template slot="tools">
      <v-btn small fab color="primary" to="add" append>
        <v-icon>mdi-plus</v-icon>
      </v-btn>
      <v-btn small fab dark color="green" class="ml-2">
        <v-icon>mdi-printer</v-icon>
      </v-btn>
    </template>
    <v-container grid-list-md>
      <v-data-table :headers="headers" :items="[]" :options.sync="options" item-key="id"></v-data-table>
    </v-container>
    <router-view></router-view>
  </page>
</template>

<script>
export default {
  data() {
    return {
      headers: [
        {
          text: "Title",
          value: "title"
        },
        {
          text: "Description",
          value: "description"
        },
        {
          text: "Type",
          value: "type"
        },
        {
          text: "Date",
          value: "date"
        }
      ],
      options: {}
    };
  }
};
</script>
