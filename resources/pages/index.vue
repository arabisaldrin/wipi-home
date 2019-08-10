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
                <template
                  >{{ userCount.active || 0 }}/{{
                    userCount.total
                  }}
                  Active</template
                >
              </stats-card>
            </v-flex>
            <v-flex sm6 xs12 md6 lg3>
              <stats-card
                color="pink"
                icon="mdi-chart-donut"
                title="Download Usage"
                sub-icon="mdi-update"
                sub-text="Last 2 days"
                sub-text-color="text-primary"
              >
                <template slot="icon">
                  <div
                    style="height: 100%; position: absolute; width: 100%; justify-content: center; display: flex;"
                  >
                    <v-icon small class="absolute">mdi-download</v-icon>
                  </div>
                  <v-icon dark size="40" class="ma-3">mdi-chart-donut</v-icon>
                </template>
                <template>
                  <v-icon small>mdi-arrow-up</v-icon>
                  {{ dataUsage.download | fix2 }} GB
                </template>
              </stats-card>
            </v-flex>
            <v-flex sm6 xs12 md6 lg3>
              <stats-card
                color="orange"
                icon="mdi-chart-donut"
                title="Upload Usage"
                sub-icon="mdi-update"
                sub-text="Last 2 days"
                sub-text-color="text-primary"
              >
                <template slot="icon">
                  <div
                    style="height: 100%; position: absolute; width: 100%; justify-content: center; display: flex;"
                  >
                    <v-icon small class="absolute">mdi-upload</v-icon>
                  </div>
                  <v-icon dark size="40" class="ma-3">mdi-chart-donut</v-icon>
                </template>
                <template>
                  <v-icon small>mdi-arrow-down</v-icon>
                  {{ dataUsage.upload | fix2 }} GB
                </template>
              </stats-card>
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
                  Last used -
                  <router-link to="#">{{ voucherCount.last }}</router-link>
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

export default {
  filters: {
    fix2(val) {
      return Number(val).toFixed(2);
    }
  },
  components: {
    StatsCard,
    MonthlyTrends,
    AnnualTrends
  },
  data() {
    return {
      userCount: {},
      voucherCount: {},
      dataUsage: {
        upload: 0,
        download: 0
      },
      annualTrends: {
        labels: [],
        datasets: []
      }
    };
  },
  async created() {
    const [
      { data: userCount },
      { data: voucherCount },
      { data: dataUsage }
    ] = await Promise.all([
      axios.get("/dashboard/user-count"),
      axios.get("/dashboard/voucher-count"),
      axios.get("/dashboard/data-usage")
    ]);

    this.userCount = userCount;
    this.voucherCount = voucherCount;
    this.dataUsage = dataUsage;
  }
};
</script>
