<template>
  <page title="Users" scheme="teal">
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
            <template
              v-slot:item.name="{item}"
            >{{(item.first_name || '') + ' ' + (item.last_name || '')}}</template>
            <template v-slot:item.status="{item}">{{item.is_active ? 'Active' : 'Inactive'}}</template>
            <template v-slot:item.actions="{item}">
              <v-btn
                x-small
                :disabled="!item.is_active"
                fab
                dark
                color="primary"
                :to="`${item.id}`"
                append
              >
                <v-icon small dark>mdi-pencil</v-icon>
              </v-btn>
              <v-btn
                x-small
                fab
                dark
                class="mx-1"
                :color="item.is_active ? 'red' : 'green'"
                @click="toggleStatus(item.id)"
              >
                <v-icon
                  small
                  dark
                >{{item.is_active? 'mdi-account-off-outline' : 'mdi-account-check-outline'}}</v-icon>
              </v-btn>
              <v-btn x-small fab dark color="red" @click="removeUser(item.id)">
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
      headers: [
        {
          text: "Username",
          value: "username"
        },
        {
          text: "Name",
          value: "name"
        },
        {
          text: "Email",
          value: "email_address"
        },
        {
          text: "Plan",
          value: "plan.code"
        },
        {
          text: "Status",
          value: "syayis"
        },
        {
          text: "",
          value: "actions",
          width: "150px"
        }
      ],
      options: {
        rowsPerPage: 10
      }
    };
  },
  computed: {
    ...mapState({
      users: s => s.users.lists,
      totalUser: s => s.users.total
    })
  },
  methods: {
    ...mapActions({
      getUsers: "users/fetch",
      toggleStatus: "users/toggleStatus",
      removeUser: "users/remove"
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
