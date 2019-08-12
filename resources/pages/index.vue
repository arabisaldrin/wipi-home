<route-meta>
{
  "title" : "Home"
}
</route-meta>
<template>
  <page title="Dashboard" scheme="primary">
    <v-container grid-list-md>
      <v-layout column>
        <v-flex xs12>
          <v-layout row wrap>
            <v-flex sm6 xs12 md6 lg3>
              <stats-card color="green" icon="mdi-account-group" title="Users">
                <template>
                  {{ userCount.active || 0 }}/{{
                  userCount.total
                  }}
                  Active
                </template>
              </stats-card>
            </v-flex>
            <v-flex sm6 xs12 md6 lg3>
              <download-usage />
            </v-flex>
            <v-flex sm6 xs12 md6 lg3>
              <upload-usage />
            </v-flex>
            <v-flex sm6 xs12 md6 lg3>
              <stats-card
                color="info"
                icon="mdi-ticket-percent"
                title="Vouchers"
                :value="`${voucherCount.used}/${voucherCount.total}`"
                small-value="Used"
                sub-icon="mdi-update"
              >
                <template slot="sub-text">
                  <span class="caption font-weight-light">
                    Last used -
                    <router-link to="#">{{ voucherCount.last }}</router-link>
                  </span>
                </template>
              </stats-card>
            </v-flex>
          </v-layout>
        </v-flex>
        <v-flex>
          <v-layout row wrap>
            <v-flex md8 lg8>
              <monthly-trends />
            </v-flex>
            <v-flex md4 lg4>
              <v-card>
                <v-card-text>
                  <pie-chart style="height : 230px"></pie-chart>
                </v-card-text>
              </v-card>
            </v-flex>
            <v-flex xs12>
              <annual-trends />
            </v-flex>
          </v-layout>
        </v-flex>
      </v-layout>
    </v-container>
  </page>
</template>

<script>
import StatsCard from "@/components/dashboard/StatsCard";
import MonthlyTrends from "@/components/dashboard/MonthlyTrends";
import AnnualTrends from "@/components/dashboard/AnnualTrends";
import DownloadUsage from "@/components/dashboard/DownloadUsage";
import UploadUsage from "@/components/dashboard/UploadUsage";

export default {
  components: {
    StatsCard,
    MonthlyTrends,
    AnnualTrends,
    DownloadUsage,
    UploadUsage
  },
  data() {
    return {
      userCount: {},
      voucherCount: {}
    };
  },
  async created() {
    const [{ data: userCount }, { data: voucherCount }] = await Promise.all([
      axios.get("/dashboard/user-count"),
      axios.get("/dashboard/voucher-count")
    ]);

    this.userCount = userCount;
    this.voucherCount = voucherCount;
  }
};
</script>
