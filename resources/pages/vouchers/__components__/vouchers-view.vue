<template>
  <v-container grid-list-md>
    <v-data-table
      :headers="headers"
      :items="items"
      :options.sync="options"
      :server-items-length="totalItems"
      :loading="loading"
      :footer-props="{'items-per-page-options' : [5,10,20]}"
      item-key="id"
    >
      <template v-slot:item.actions="{ item }">
        <v-btn :disabled="!item.is_active" fab x-small color="red" class="mr-1">
          <v-icon color="white" small>mdi-delete</v-icon>
        </v-btn>
        <v-dialog max-width="min-content" transition="dialog-transition">
          <template v-slot:activator="{on}">
            <v-btn fab x-small color="success" v-on="on">
              <v-icon>mdi-qrcode</v-icon>
            </v-btn>
          </template>
          <v-card class="white">
            <v-card-text>
              <qrcode
                :value="item.code"
                :size="200"
                level="H"
                background="white"
                foreground="black"
              ></qrcode>
              <v-layout justify-center class="black--text">
                <h2>{{item.code}}</h2>
              </v-layout>
            </v-card-text>
          </v-card>
        </v-dialog>
      </template>
    </v-data-table>
  </v-container>
</template>
<script>
import tableMixin from "@/js/mixins/table-mixin";
import Qrcode from "qrcode.vue";
import clone from "lodash.clone";
export default {
  components: {
    Qrcode
  },
  mixins: [tableMixin("vouchers")],
  data() {
    return {
      headers: [
        {
          text: "Code",
          value: "code"
        },
        {
          text: "Used",
          value: "used_at"
        },
        {
          text: "Created Date",
          value: "created_at"
        },
        {
          text: "Actions",
          value: "actions",
          width: "110px",
          align: "right"
        }
      ]
    };
  },
  computed: {
    group_id() {
      return this.$route.query.group_id;
    },
    extraOptions() {
      const { group_id } = this;
      return {
        filters: {
          group_id
        }
      };
    }
  },
  watch: {
    async $route(val) {
      if (typeof this.group_id != "undefined") {
        this.reload();
      }
    }
  }
};
</script>