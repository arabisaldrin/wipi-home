<template>
  <page title="VIP Users" scheme="lime darken-2">
    <template slot="tools">
      <v-btn fab small color="primary" to="add" append>
        <v-icon>mdi-plus</v-icon>
      </v-btn>
      <v-btn fab small dark color="green" class="ml-2">
        <v-icon>mdi-printer</v-icon>
      </v-btn>
    </template>
    <v-container grid-list-md>
      <v-layout column>
        <v-card>
          <v-data-table
            :headers="headers"
            :items="users"
            :server-items-length="totalUser"
            :options.sync="options"
            item-key="id"
          >
            <template v-slot:item.devices="{item}">
              <v-chip small v-for="device in item.devices" :key="device.id">{{device.mac_address}}</v-chip>
            </template>
            <template v-slot:item.actions="{item}">
              <v-btn x-small fab dark color="primary" :to="`${item.id}`" append class="mr-1">
                <v-icon small dark>mdi-pencil</v-icon>
              </v-btn>
              <v-btn x-small fab dark color="red" @click="removeVip(item.id)">
                <v-icon small dark>mdi-trash-can</v-icon>
              </v-btn>
            </template>
          </v-data-table>
        </v-card>
      </v-layout>
    </v-container>
    <router-view></router-view>
  </page>
</template>

<script>
import { mapState, mapActions } from "vuex";
export default {
  data() {
    return {
      options: {
        rowsPerPage: 10
      },
      headers: [
        {
          text: "Name",
          value: "name"
        },
        {
          text: "Devices",
          value: "devices"
        },
        {
          text: "",
          width: "120",
          value: "actions"
        }
      ]
    };
  },
  computed: {
    ...mapState({
      users: s => s.vips.lists,
      totalUser: s => s.vips.total
    })
  },
  methods: {
    ...mapActions({
      getUsers: "vips/fetch",
      toggleStatus: "vips/toggleStatus",
      removeVip: "vips/remove"
    })
  },
  watch: {
    options: {
      deep: true,
      handler: async function(val) {
        await this.getUsers(val);
      }
    }
  }
};
</script>