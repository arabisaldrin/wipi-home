<template>
  <page title="Profile" scheme="indigo" panel-height="20em">
    <v-layout column fill-height>
      <v-flex shrink class="mb-4">
        <span class="display-3 white--text">Hello, Aldrin!</span>
      </v-flex>
      <v-flex class="mt-5">
        <v-layout row wrap>
          <v-flex md5 lg5 xs12>
            <v-card>
              <v-card-title style="height : 4em" class="layout justify-center ma-0 pa-0">
                <v-avatar size="120" class="offset-t-5">
                  <img src="@/assets/avatars/default.svg" />
                </v-avatar>
              </v-card-title>
              <v-layout row justify-center>
                <v-flex xs4 shrink justify-center class="layout ma-0">
                  <div class="subtitle">asdsad</div>
                </v-flex>
                <v-divider vertical></v-divider>
                <v-flex xs4 shrink justify-center class="layout ma-0">
                  <div class="subtitle">asdsad</div>
                </v-flex>
                <v-divider vertical></v-divider>
                <v-flex xs4 shrink justify-center class="layout ma-0">
                  <div class="subtitle">asdsad</div>
                </v-flex>
              </v-layout>
              <v-card-text>
                Lorem ipsum dolor sit amet consectetur adipisicing elit.
                Mollitia voluptate iure illo sequi. Molestias excepturi in sunt
                quia eius ratione ipsam illo atque harum, officiis expedita est,
                voluptate neque nobis! Lorem ipsum dolor sit amet consectetur
                adipisicing elit. Dolore ad cum repudiandae mollitia ratione
                laborum, assumenda sequi blanditiis, facere deleniti iure? Ut
                nulla minima assumenda dolores obcaecati voluptas neque at.
              </v-card-text>
            </v-card>
          </v-flex>
          <v-flex md7 lg7 xs12>
            <v-card>
              <v-card-title primary-title>My Profile</v-card-title>
              <v-divider></v-divider>
              <v-card-text>
                Lorem ipsum, dolor sit amet consectetur adipisicing elit.
                Doloribus, sunt debitis? Quibusdam tempora saepe provident
                consequatur aliquid, pariatur obcaecati, nemo magnam incidunt
                dolorum quam reiciendis itaque aut voluptas, commodi voluptates.
              </v-card-text>
            </v-card>
          </v-flex>
        </v-layout>
      </v-flex>
    </v-layout>
  </page>
</template>

<script>
export default {};
</script>

<style>
</style>
