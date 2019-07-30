<template>
  <page :title="title" scheme="indigo">
    <template slot="tools">
      <v-flex>
        <v-btn small v-show="view" dark depressed rounded icon @click="view = 0">
          <v-icon>mdi-arrow-left</v-icon>
        </v-btn>
        <v-btn small v-show="!view" fab color="primary" to="add" append>
          <v-icon>mdi-plus</v-icon>
        </v-btn>
        <v-btn
          small
          v-show="view"
          fab
          dark
          color="green"
          class="ml-2"
          :href="getPrintURL(selectedGroup)"
          target="_blank"
        >
          <v-icon>mdi-printer</v-icon>
        </v-btn>
        <v-btn
          small
          v-show="view"
          class="mx-1"
          fab
          color="pink"
          @click="archiveGroup([selectedGroup]) ; view = 0"
        >
          <v-icon>mdi-archive</v-icon>
        </v-btn>
      </v-flex>
      <v-spacer></v-spacer>
    </template>
    <v-tabs-items v-model="view" class="transparent">
      <v-tab-item>
        <v-container grid-list-md>
          <v-layout row wrap v-if="groups.length">
            <v-hover v-for="group in groups" :key="group.id">
              <template v-slot:default="{ hover }">
                <v-flex sm4 xs12 md3 lg3 grow>
                  <v-card class="fill-height">
                    <v-list-item three-line>
                      <v-list-item-content>
                        <div class="overline mb-4 px-1 layout row">
                          {{ $moment().format("MMM DD, YYYY") }}
                          <v-spacer></v-spacer>
                          <v-icon small>
                            {{
                            group.printed_at
                            ? "mdi-printer"
                            : group.released_at
                            ? "mdi-playlist-check"
                            : ""
                            }}
                          </v-icon>
                        </div>
                        <v-list-item-title class="headline mb-1">
                          {{
                          group.total_vouchers + " - " + (group.plan || {}).code
                          }}
                        </v-list-item-title>
                        <v-list-item-subtitle>
                          {{
                          group.description
                          }}
                        </v-list-item-subtitle>
                      </v-list-item-content>
                    </v-list-item>
                    <v-overlay v-if="group.archived_at" absolute color="#3c3c3c">
                      <v-icon color="pink" large>mdi-archive</v-icon>
                    </v-overlay>
                    <div v-else>
                      <v-fade-transition>
                        <v-overlay v-if="hover" absolute color="#3c3c3c">
                          <v-btn
                            x-small
                            class="mx-1"
                            fab
                            color="green"
                            @click="viewVouchers(group)"
                          >
                            <v-icon>mdi-file-eye-outline</v-icon>
                          </v-btn>
                          <v-btn
                            x-small
                            class="mx-1"
                            fab
                            color="primary"
                            :href="getPrintURL(group)"
                            target="_blank"
                          >
                            <v-icon>mdi-printer</v-icon>
                          </v-btn>
                          <v-btn
                            x-small
                            class="mx-1"
                            fab
                            color="pink"
                            @click="archiveGroup([group])"
                          >
                            <v-icon>mdi-archive</v-icon>
                          </v-btn>
                        </v-overlay>
                      </v-fade-transition>
                    </div>
                  </v-card>
                </v-flex>
              </template>
            </v-hover>
          </v-layout>
          <v-alert type="info" v-else :value="true">
            No data available. click
            <v-icon small>mdi-plus</v-icon>to add
          </v-alert>
        </v-container>
      </v-tab-item>
      <v-tab-item>
        <v-container grid-list-md>
          <v-card>
            <v-data-table
              v-model="selecetd"
              :headers="headers"
              :items="vouchers"
              :options.sync="options"
              :server-items-length="totalVouchers"
              :loading="loadingVouchers"
              item-key="id"
            >
              <template v-slot:item.actions="{ item }">
                <!--  <v-btn fab dark small color="primary" class="mr-1" :to="`${item.id}`" append>
                  <v-icon small dark>mdi-pencil</v-icon>
                </v-btn>-->
                <v-btn
                  :disabled="!item.is_active"
                  fab
                  x-small
                  color="red"
                  @click="removeVoucher(item.id)"
                  class="mr-1"
                >
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
          </v-card>
        </v-container>
      </v-tab-item>
    </v-tabs-items>
    <router-view></router-view>
  </page>
</template>

<script>
import { mapActions, mapState } from "vuex";
import Qrcode from "qrcode.vue";

export default {
  components: {
    Qrcode
  },
  data() {
    return {
      title: "Vouchers",
      view: 0,
      options: {
        itemsPerPage: 10
      },
      page: 1,
      selecetd: [],
      headers: [
        {
          text: "Code",
          value: "code"
        },
        {
          text: "Expiration",
          value: "expiration"
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
      ],
      selectedGroup: {},
      filter: {
        group_id: null
      }
    };
  },
  created() {
    this.getVoucherGroups();
  },
  computed: {
    ...mapState({
      vouchers: s => s.vouchers.lists,
      totalVouchers: s => s.vouchers.totalVouchers,
      loadingVouchers: s => s.vouchers.loading,
      totalGroups: s => s.voucherGroups.totalGroups,
      groups: s => s.voucherGroups.lists
    })
  },
  methods: {
    ...mapActions({
      getVouchers: "vouchers/fetch",
      getVoucherGroups: "voucherGroups/fetch",
      removeVoucher: "vouchers/remove",
      archiveGroup: "voucherGroups/archive"
    }),
    viewVouchers(group) {
      this.filter.group_id = group.id;
      this.title = group.plan.code;
      this.selectedGroup = group;
      this.view = 1;
    },
    getPrintURL(group) {
      const reportURL = "http://localhost:8080/jasperserver/rest_v2/reports";
      const reportUnit = "reports/pihome/Vouchers";
      const format = "pdf";
      const options = {
        j_username: "jasperadmin",
        j_password: "jasperadmin",
        voucher_group_id: group.id,
        PARAM_REPORT_FILENAME: "Sample"
      };

      var str = Object.keys(options)
        .map(function(key) {
          return (
            encodeURIComponent(key) + "=" + encodeURIComponent(options[key])
          );
        })
        .join("&");

      return `${reportURL}/${reportUnit}.${format}?${str}`;
    }
  },
  watch: {
    filter: {
      deep: true,
      handler: function(val) {
        this.options.filter = val;
        this.getVouchers();
      }
    },
    options: {
      deep: true,
      handler: function(val) {
        this.getVouchers(val);
      }
    },
    view(val) {
      if (!val) this.title = "Vouchers";
    }
  }
};
</script>
