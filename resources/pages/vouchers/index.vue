<template>
  <page title="Voucher Groups" scheme="indigo">
    <template slot="tools">
      <v-btn small fab color="primary" to="add" append>
        <v-icon>mdi-plus</v-icon>
      </v-btn>
    </template>
    <v-container grid-list-md>
      <v-data-iterator
        row
        wrap
        :items="items"
        :options.sync="options"
        :server-items-length="totalItems"
        :footer-props="{'items-per-page-options' : [5,10,20]}"
        item-key="id"
      >
        <template v-slot:no-data>No items available</template>
        <template v-slot:default="{items}">
          <v-row>
            <v-col v-for="group in items" :key="group.id" sm="4" xs="12" md="3" lg="3">
              <v-hover>
                <template v-slot:default="{hover}">
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
                      <v-layout row>
                        <v-btn icon @click="archive({group_id : group.id,archive :false})">
                          <v-icon color="green">mdi-package-up</v-icon>
                        </v-btn>
                        <v-btn icon @click="confirmAndRemove(group)">
                          <v-icon color="pink">mdi-delete</v-icon>
                        </v-btn>
                      </v-layout>
                    </v-overlay>
                    <div v-else>
                      <v-fade-transition>
                        <v-overlay v-if="hover" absolute color="#3c3c3c">
                          <v-btn
                            x-small
                            class="mx-1"
                            fab
                            color="green"
                            :to="`group/${group.id}`"
                            append
                          >
                            <v-icon>mdi-file-eye-outline</v-icon>
                          </v-btn>
                          <v-btn
                            x-small
                            class="mx-1"
                            fab
                            color="primary"
                            target="_blank"
                            :href="getPrintURL(group)"
                          >
                            <v-icon>mdi-printer</v-icon>
                          </v-btn>
                          <v-btn
                            x-small
                            class="mx-1"
                            fab
                            color="pink"
                            @click="confirmAndArchive(group)"
                          >
                            <v-icon>mdi-archive</v-icon>
                          </v-btn>
                        </v-overlay>
                      </v-fade-transition>
                    </div>
                  </v-card>
                </template>
              </v-hover>
            </v-col>
          </v-row>
        </template>
      </v-data-iterator>
    </v-container>
    <router-view></router-view>
  </page>
</template>

<script>
import tableMixin from "../../js/mixins/table-mixin";
import { mapActions } from "vuex";
export default {
  mixins: [tableMixin("voucherGroups")],
  data() {
    return {};
  },
  methods: {
    ...mapActions({
      archive: "voucherGroups/archive",
      remove: "voucherGroups/remove"
    }),
    async confirmAndArchive(group) {
      const confirmed = await this.$confirm(
        "Are you sure you want to archive the group?",
        {
          title: "Confirm Archiving",
          subMessage: "This will also archive all voucher of this group",
          onStop: () => {}
        }
      );
      if (confirmed) {
        try {
          await this.archive({ group_id: group.id });
          this.$toast.success(this.$t("group.success", ["archived"]));
        } catch (error) {
          console.log(error);
        }
      }
    },
    async confirmAndRemove(group) {
      const confirmed = await this.$confirm(
        "Are you sure you want to remove the group?",
        {
          title: "Confirm Deletion",
          subMessage: "This will also remove all voucher of this group",
          onStop: () => {}
        }
      );
      if (confirmed) {
        try {
          await this.remove(group.id);
          this.$toast.success(this.$t("group.success", ["removed"]));
        } catch (error) {
          const { status } = error.response;
          this.$toast.error(this.$t("group.remove.failed", { status }));
        }
      }
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
  }
};
</script>
