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
            v-model="selecetd"
            :headers="headers"
            :items="plans"
            :options.sync="options"
            item-key="id"
          >
            <template v-slot:item.actions="{item}">
              <v-btn x-small fab dark color="primary" class="mr-1" :to="`${item.id}`" append>
                <v-icon small dark>mdi-pencil</v-icon>
              </v-btn>
              <v-btn x-small fab dark color="red" class="mr-1" @click="deleteItem(item)">
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
import { mapActions, mapState } from "vuex";
export default {
  data() {
    return {
      options: {
        rowsPerPage: 10
      },
      selecetd: [],
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
  computed: {
    ...mapState({
      plans: s => s.plans.lists
    })
  },
  methods: {
    async deleteItem(plan) {
      this.deletePlan(plan.id);
    },
    ...mapActions({
      getPlans: "plans/fetch",
      deletePlan: "plans/remove"
    })
  },
  watch: {
    options: {
      deep: true,
      handler: async function(val) {
        await this.getPlans(val);
      }
    }
  }
};
</script>
