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
            :items="items"
            :server-items-length="totalItems"
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
                @click="confirmAndToggleStatus(item)"
              >
                <v-icon
                  small
                  dark
                >{{item.is_active? 'mdi-account-off-outline' : 'mdi-account-check-outline'}}</v-icon>
              </v-btn>
              <v-btn x-small fab dark color="red" @click="confirmAndRemove(item)">
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
import { mapActions } from "vuex";
import tableMixin from "@/js/mixins/table-mixin";
export default {
  mixins: [tableMixin("users")],
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
      ]
    };
  },
  methods: {
    ...mapActions({
      toggleStatus: "users/toggleStatus"
    }),
    async confirmAndRemove(user) {
      const confirmed = await this.$confirm(
        "Are you sure you want to remove the user?",
        {
          title: "Confirm Deletion",
          onStop: () => {}
        }
      );
      if (confirmed) {
        try {
          await this.remove(user.id);
          this.$toast.success(this.$t("toast.success", ["User", "removed"]));
        } catch (error) {
          const { status } = error.response;
          this.$toast.error(this.$t("toast.error", ["remove", "User"]));
        }
      }
    },
    async confirmAndToggleStatus(user) {
      const action = user.is_active ? "Deactivate" : "Activate";
      const confirmed = await this.$confirm(
        `Are you sure you want to ${action} the user?`,
        {
          title: "Confirm Action",
          onStop: () => {}
        }
      );
      if (confirmed) {
        try {
          await this.toggleStatus(user.id);
          this.$toast.success(
            this.$t("toast.success", ["User", action + "ed"])
          );
        } catch (error) {
          const { status } = error.response;
          this.$toast.error(this.$t("toast.error", ["deactivate", "User"]));
        }
      }
    }
  }
};
</script>
