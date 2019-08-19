<template>
  <page title="Plans" scheme="cyan">
    <template slot="tools">
      <v-btn small fab color="primary" to="add" append>
        <v-icon>mdi-plus</v-icon>
      </v-btn>
      <v-btn small fab dark color="green" class="ml-2">
        <v-icon>mdi-printer</v-icon>
      </v-btn>
    </template>
    <v-container grid-list-md>
      <v-layout column>
        <v-card>
          <v-data-table
            :headers="headers"
            :items="items"
            :options.sync="options"
            :server-items-length="totalItems"
            item-key="id"
          >
            <template v-slot:item.actions="{item}">
              <v-btn x-small fab dark color="primary" class="mr-1" :to="`${item.id}`" append>
                <v-icon small dark>mdi-pencil</v-icon>
              </v-btn>
              <v-btn x-small fab dark color="red" class="mr-1" @click="confirmAndRemove(item)">
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
import tableMixin from "../../js/mixins/table-mixin";
export default {
  mixins: [tableMixin("plans")],
  data() {
    return {
      headers: [
        {
          text: "Code",
          value: "code"
        },
        {
          text: "Description",
          value: "description"
        },
        {
          text: "Active User",
          value: "users_count"
        },
        {
          text: "Actions",
          value: "actions",
          width: "120px",
          align: "right",
          sortable: false
        }
      ]
    };
  },
  methods: {
    async confirmAndRemove(plan) {
      const confirmed = await this.$confirm(
        "Are you sure you want to remove the plan?",
        {
          title: "Confirm Deletion",
          onStop: () => {}
        }
      );
      if (confirmed) {
        try {
          await this.remove(plan.id);
          this.$toast.success(this.$t("toast.success", ["Plan", "removed"]));
        } catch (error) {
          const { status } = error.response;
          this.$toast.error(this.$t("toast.error", ["remove", "Plan"]));
        }
      }
    }
  }
};
</script>
