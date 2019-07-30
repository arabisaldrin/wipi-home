<template>
  <page title="Settings" scheme="deep-purple">
    <v-layout column>
      <v-expansion-panels accordion v-model="panel">
        <v-expansion-panel>
          <v-expansion-panel-header>General</v-expansion-panel-header>
          <v-expansion-panel-content>
            <v-alert type="info" :value="true">
              Lorem ipsum, dolor sit amet consectetur adipisicing elit. Optio,
              voluptatem!
            </v-alert>
          </v-expansion-panel-content>
        </v-expansion-panel>
        <v-expansion-panel>
          <v-expansion-panel-header>Notifications</v-expansion-panel-header>
          <v-expansion-panel-content>
            <v-alert type="info" :value="true">
              Lorem ipsum, dolor sit amet consectetur adipisicing elit. Optio,
              voluptatem!
            </v-alert>
          </v-expansion-panel-content>
        </v-expansion-panel>
        <v-expansion-panel>
          <v-expansion-panel-header>Interface</v-expansion-panel-header>
          <v-expansion-panel-content>
            <v-alert type="info" :value="true">
              Lorem ipsum, dolor sit amet consectetur adipisicing elit. Optio,
              voluptatem!
            </v-alert>
          </v-expansion-panel-content>
        </v-expansion-panel>
      </v-expansion-panels>
    </v-layout>
  </page>
</template>

<script>
export default {
  data() {
    return {
      panel: 0
    };
  }
};
</script>