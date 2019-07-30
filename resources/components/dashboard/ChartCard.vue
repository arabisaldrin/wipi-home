<template>
  <v-card class="mt-3 mx-auto">
    <v-sheet class="offset-t-3 mx-auto" color="cyan" elevation="12" max-width="calc(100% - 32px)">
      <v-sparkline
        :labels="value.labels"
        :value="value.data"
        color="white"
        line-width="2"
        padding="16"
      ></v-sparkline>
    </v-sheet>

    <v-card-text>
      <div class="title font-weight-light mb-2">{{value.title}}</div>
      <div class="subheading font-weight-light grey--text">{{value.subTitle}}</div>
      <v-divider class="my-2"></v-divider>
      <v-icon class="mr-2" small>{{value.footerIcon}}</v-icon>
      <span class="caption grey--text font-weight-light">{{value.footerContent}}</span>
    </v-card-text>
  </v-card>
</template>

<script>
export default {
  props: {
    value: {
      default: () => ({
        title: 'Title',
        subTitle: 'Title',
        labels: ['12am', '3am', '6am', '9am', '12pm', '3pm', '6pm', '9pm'],
        data: [200, 675, 410, 390, 310, 460, 250, 240],
        footerIcon: 'mdi-clock',
        footerContent: 'last registration 26 minutes ago'
      })
    }
  }
}
</script>
