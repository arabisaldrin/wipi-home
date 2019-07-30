<route-meta>
{
  "title" : "Home"
}
</route-meta>
<template>
  <page title="Dashboard" scheme="primary">
    <v-container grid-list-md>
      <v-layout column>
        <v-flex>
          <v-layout row wrap>
            <v-flex md8 lg8>
              <v-card>
                <v-card-text>
                  <line-chart style="height : 230px"></line-chart>
                </v-card-text>
              </v-card>
            </v-flex>
            <v-flex md4 lg4>
              <v-card>
                <v-card-text>
                  <pie-chart style="height : 230px"></pie-chart>
                </v-card-text>
              </v-card>
            </v-flex>
            <v-flex xs12>
              <v-card>
                <v-card-text>
                  <bar-chart style="height : 230px"></bar-chart>
                </v-card-text>
              </v-card>
            </v-flex>
          </v-layout>
        </v-flex>
        <v-flex xs12>
          <v-layout row wrap class="mt-3">
            <v-flex sm6 xs12 md6 lg3>
              <stats-card
                color="green"
                icon="mdi mdi-store"
                title="Revenue"
                value="$34,245"
                sub-icon="mdi-calendar"
                sub-text="Last 24 Hours"
              />
            </v-flex>
            <v-flex sm6 xs12 md6 lg3>
              <stats-card
                color="orange"
                icon="mdi-content-copy"
                title="Used Space"
                value="49/50"
                small-value="GB"
                sub-icon="mdi-alert"
                sub-icon-color="error"
                sub-text="Get More Space..."
                sub-text-color="text-primary"
              />
            </v-flex>
            <v-flex sm6 xs12 md6 lg3>
              <stats-card
                color="red"
                icon="mdi-information-outline"
                title="Fixed Issues"
                value="75"
                sub-icon="mdi-tag"
                sub-text="Tracked from Github"
              />
            </v-flex>
            <v-flex sm6 xs12 md6 lg3>
              <stats-card
                color="info"
                icon="mdi-twitter"
                title="Followers"
                value="+245"
                sub-icon="mdi-update"
                sub-text="Just Updated"
              />
            </v-flex>
          </v-layout>
        </v-flex>
      </v-layout>
    </v-container>
  </page>
</template>

<script>
import StatsCard from "@/components/dashboard/StatsCard";

export default {
  components: {
    StatsCard
  }
};
</script>
