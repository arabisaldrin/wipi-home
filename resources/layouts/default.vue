<template>
  <v-app app>
    <v-app-bar app :flat="!page.scrolling" dark :class="page.scheme">
      <div :class="`header-panel-overlay ${page.scheme}`"></div>
      <v-app-bar-nav-icon @click="toggleDrawer"></v-app-bar-nav-icon>
      <v-fade-transition>
        <span v-show="page.scrolling" v-text="page.title"></span>
      </v-fade-transition>
      <v-spacer></v-spacer>
      <v-btn medium fab text>
        <v-icon>mdi-magnify</v-icon>
      </v-btn>
      <v-btn medium fab text>
        <v-icon>mdi-heart</v-icon>
      </v-btn>
      <v-menu offset-y left :close-on-content-click="false">
        <template v-slot:activator="{ on }">
          <v-btn medium fab text v-on="on">
            <v-icon>mdi-bell-outline</v-icon>
          </v-btn>
        </template>

        <v-card>
          <v-card-title class="pa-2">
            <span class="caption grey--text">Notification</span>
          </v-card-title>
          <v-list dense class="pt-0">
            <notification actions title="Title" content="Content"></notification>
            <v-list-item v-for="i in 3" :key="i" @click.stop>
              <v-list-item-icon>
                <v-avatar size="30">
                  <img src="@/assets/avatars/default.svg" />
                </v-avatar>
              </v-list-item-icon>
              <v-list-item-content>
                <v-list-item-title>Notification {{ i }}</v-list-item-title>
              </v-list-item-content>
            </v-list-item>
          </v-list>
        </v-card>
      </v-menu>
      <v-btn icon href="/logout">
        <v-icon>mdi-logout</v-icon>
      </v-btn>
    </v-app-bar>
    <v-navigation-drawer v-model="drawer" :mini-variant="miniVariant" app>
      <v-fade-transition>
        <div class="layout justify-center py-2 align-center" v-show="drawer && !miniVariant">
          <div class="d-flex align-baseline">
            wi
            <span class="display-1">Pi</span>
            <v-icon large color="primary">mdi-home-outline</v-icon>
            <span class="display-1">ome</span>
            <v-icon>mdi-wifi mdi-rotate-45</v-icon>
          </div>
        </div>
      </v-fade-transition>

      <v-divider></v-divider>
      <v-list dense class="pt-0">
        <template v-for="item in menu">
          <v-layout v-if="item.heading" :key="item.heading" row align-center>
            <v-flex xs6>
              <v-subheader v-if="item.heading">{{ item.heading }}</v-subheader>
            </v-flex>
            <v-flex xs6 class="text-xs-center">
              <a href="#!" class="body-2 black--text">EDIT</a>
            </v-flex>
          </v-layout>
          <v-list-group v-else-if="item.children" :key="item.text" v-model="item.model">
            <template v-slot:activator>
              <v-list-item class="pl-0">
                <v-list-item-icon>
                  <v-icon>{{ item.icon }}</v-icon>
                </v-list-item-icon>
                <v-list-item-content>
                  <v-list-item-title>{{ item.text }}</v-list-item-title>
                </v-list-item-content>
              </v-list-item>
            </template>
            <v-list-item
              v-for="(child, i) in item.children"
              :key="i"
              :to="child.route"
              style="border-left : 2px solid var(--v-primary-base)"
            >
              <v-list-item-icon v-if="child.icon">
                <v-icon small>{{ child.icon }}</v-icon>
              </v-list-item-icon>
              <v-list-item-content>
                <v-list-item-title>{{ child.text }}</v-list-item-title>
              </v-list-item-content>
            </v-list-item>
          </v-list-group>
          <v-list-item v-else :key="item.text" :to="item.route">
            <v-list-item-icon>
              <v-icon>{{ item.icon }}</v-icon>
            </v-list-item-icon>
            <v-list-item-content>
              <v-list-item-title>{{ item.text }}</v-list-item-title>
            </v-list-item-content>
          </v-list-item>
        </template>
      </v-list>
    </v-navigation-drawer>
    <v-content>
      <div
        class="material-panel-header"
        :class="page.scheme"
        :style="`height : ${page.panelHeight}`"
      ></div>
      <router-view></router-view>
    </v-content>
    <v-footer app class="font-weight-medium">
      <v-flex text-xs-right>
        <v-icon>mdi-settings</v-icon>
        <v-icon
          class="mx-1"
          :color="$vuetify.theme.dark ? 'primary' : ''"
          @click="$vuetify.theme.dark = !$vuetify.theme.dark"
        >mdi-invert-colors</v-icon>
      </v-flex>
    </v-footer>
  </v-app>
</template>

<script>
import menu from "@/js/menu";
import { mapState, mapActions } from "vuex";
import Notification from "@/components/Notification";
export default {
  components: {
    Notification
  },
  data() {
    return {
      menu,
      drawer: true,
      miniVariant: false
    };
  },
  computed: {
    ...mapState(["page"])
  },
  methods: {
    toggleDrawer() {
      if (this.$vuetify.breakpoint.lgAndUp) {
        this.drawer = true;
        this.miniVariant = !this.miniVariant;
      } else {
        this.miniVariant = false;
        this.drawer = !this.drawer;
      }
    }
  }
};
</script>
<style>
.v-app-bar {
  transition: all 2s ease;
}
.header-panel-overlay {
  position: absolute;
  width: 100%;
  top: 0;
  left: 0;
  height: 100%;
  z-index: -1;
}
.material-panel-header {
  position: fixed;
  width: 100%;
  top: 0;
  z-index: 0;
}
</style>
