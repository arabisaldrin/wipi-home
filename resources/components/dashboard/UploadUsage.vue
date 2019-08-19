<template>
  <stats-card
    color="orange"
    icon="mdi-chart-donut"
    title="Upload Usage"
    sub-icon="mdi-update"
    sub-text="Last 2 days"
    sub-text-color="text-primary"
  >
    <template slot="sub-text">
      <v-menu offset-y>
        <template v-slot:activator="{on}">
          <span v-on="on" class="caption font-weight-light">
            {{filter.text}}
            <v-icon x-small right>mdi-chevron-down</v-icon>
          </span>
        </template>
        <v-list dense>
          <v-list-item v-for="(item,i) in filters" :key="i" @click="filter=item">
            <v-list-item-title>{{item.text}}</v-list-item-title>
          </v-list-item>
        </v-list>
      </v-menu>
      <v-spacer></v-spacer>
      <v-icon small class @click="refresh">mdi-refresh</v-icon>
    </template>
    <template slot="icon">
      <div class="icon-overlay">
        <v-icon small dark class="absolute">mdi-upload</v-icon>
      </div>
      <v-icon dark size="40" class="ma-3">{{loading ? 'mdi-loading mdi-spin' : 'mdi-chart-donut'}}</v-icon>
    </template>
    <template>
      <v-icon small>mdi-arrow-up</v-icon>
      {{ usage | fix2 }} GB
    </template>
  </stats-card>
</template>

<script>
import StatsCard from "@/components/dashboard/StatsCard";
const filters = [
  {
    text: "Today",
    value: app.$moment()
  },
  {
    text: "Last 2 Days",
    value: app.$moment().subtract(2, "day")
  },
  {
    text: "This week",
    value: app.$moment().startOf("week")
  }
];
export default {
  components: {
    StatsCard
  },
  data() {
    return {
      filters,
      usage: 0,
      filter: filters[0],
      loading: true
    };
  },
  created() {
    this.refresh();
  },
  methods: {
    async refresh() {
      this.loading = true;
      const date = this.filter.value.format("YYYY-MM-DD");
      const { data } = await axios.get(
        `/dashboard/data-usage?type=upload&date=${date}`
      );
      this.usage = data;
      this.loading = false;
    }
  },
  watch: {
    filter: "refresh"
  }
};
</script>
<style>
.icon-overlay {
  height: 100%;
  position: absolute;
  width: 100%;
  justify-content: center;
  display: flex;
}
</style>