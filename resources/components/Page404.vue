<template>
  <v-app>
    <v-container fill-height align-center grid-list-md>
      <v-layout column align-center justify-center>
        <v-flex shrink>
          <span class="display-4 layout align-center">
            4
            <v-icon color="red" size="100" class="ml-2">mdi-cancel</v-icon>4
          </span>
        </v-flex>
        <v-flex shrink>Page not found!</v-flex>
        <v-flex shrink>
          <v-btn color="primary" href="/">
            <v-icon left>mdi-home</v-icon>Home
          </v-btn>
        </v-flex>
      </v-layout>
    </v-container>
  </v-app>
</template>

<script>
export default {};
</script>

<style>
</style>
