<template>
  <v-card>
    <v-btn v-show="!loading" x-small icon absolute right class="mt-1" @click="refresh">
      <v-icon>mdi-refresh</v-icon>
    </v-btn>
    <v-card-text>
      <v-layout v-show="loading" row align-center justify-center style="height : 234px">
        <v-progress-circular indeterminate color="primary"></v-progress-circular>
      </v-layout>
      <bar-chart v-show="!loading" :chart-data="chartData" style="height : 230px"></bar-chart>
    </v-card-text>
  </v-card>
</template>


<script>
const option = color => {
  return {
    borderColor: color,
    pointBackgroundColor: "white",
    borderWidth: 1,
    pointBorderColor: "white"
  };
};
export default {
  data() {
    return {
      chartData: {},
      loading: true
    };
  },
  async created() {
    this.refresh();
  },
  methods: {
    async refresh() {
      this.loading = true;
      const { data } = await axios.get("/dashboard/annual-trends");

      this.chartData = {
        labels: data.labels.map(e =>
          this.$moment(e,'M').format("MMM")
        ),
        datasets: [
          {
            label: "Data Usage (GB)",
            data: data.usage,
            ...option("#FC2525")
          },
          {
            label: "Connections",
            data: data.connection,
            ...option("#05CBE1")
          }
        ]
      };
      this.loading = false;
    }
  }
};
</script>