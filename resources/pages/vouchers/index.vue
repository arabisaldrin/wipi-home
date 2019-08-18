<template>
  <page :title="title" scheme="indigo">
    <template slot="tools">
      <v-flex>
        <v-btn small v-show="view" dark depressed rounded icon @click="$router.back()">
          <v-icon>mdi-arrow-left</v-icon>
        </v-btn>
        <v-btn small v-show="!view" fab color="primary" to="add" append>
          <v-icon>mdi-plus</v-icon>
        </v-btn>
        <v-btn small v-show="view" fab dark color="green" class="ml-2" target="_blank">
          <!-- :href="getPrintURL(selectedGroup)" -->
          <v-icon>mdi-printer</v-icon>
        </v-btn>
        <v-btn small v-show="view" class="mx-1" fab color="pink" @click="archiveGroup">
          <v-icon>mdi-archive</v-icon>
        </v-btn>
      </v-flex>
      <v-spacer></v-spacer>
    </template>
    <v-tabs-items :value="view" class="transparent">
      <v-tab-item key="group">
        <group-view />
      </v-tab-item>
      <v-tab-item key="vouchers">
        <vouchers-view />
      </v-tab-item>
    </v-tabs-items>
    <router-view></router-view>
  </page>
</template>

<script>
import groupView from "./__components__/group-view";
import vouchersView from "./__components__/vouchers-view";
import { mapActions } from "vuex";
export default {
  components: {
    groupView,
    vouchersView
  },
  data() {
    return {
      title: "Groups",
      view: 0
    };
  },
  created() {
    const { group_id } = this.$route.query;
    if (group_id) {
      this.view = 1;
    }
  },
  methods: {
    ...mapActions({
      archive: "voucherGroups/archive"
    }),
    archiveGroup() {
      const { group_id } = this.$route.query;
      this.archive({ group_id });
      this.$router.replace("/vouchers");
    }
  },
  watch: {
    $route(val) {
      const { group_id } = val.query;
      if (typeof group_id != "undefined") {
        this.view = 1;
      } else {
        this.view = 0;
      }
    },
    view(val) {
      this.title = val ? "Vouchers" : "Groups";
    }
  }
};
</script>
