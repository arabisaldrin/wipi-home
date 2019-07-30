<template>
  <div>
    <v-card class="mt-4 pa-0">
      <v-layout row wrap ml-2 pr-3>
        <v-flex shrink>
          <v-sheet class="offset-t-4" :color="color" elevation="12">
            <v-icon dark size="40" class="ma-3">md {{icon}}</v-icon>
          </v-sheet>
        </v-flex>
        <v-spacer></v-spacer>
        <v-flex shrink class="text-xs-right" pa-3>
          <p class="category grey--text font-weight-light" v-text="title"/>
          <h3 class="title display-1 font-weight-light">
            {{ value }}
            <small>{{ smallValue }}</small>
          </h3>
        </v-flex>
      </v-layout>
      <v-card-actions>
        <v-icon :color="subIconColor" size="20" class="mr-2">{{ subIcon }}</v-icon>
        <span :class="subTextColor" class="caption font-weight-light" v-text="subText"/>
      </v-card-actions>
    </v-card>
  </div>
</template>

<script>
export default {
  props: {
    icon: {
      type: String,
      required: true
    },
    subIcon: {
      type: String,
      default: undefined
    },
    subIconColor: {
      type: String,
      default: undefined
    },
    subTextColor: {
      type: String,
      default: undefined
    },
    subText: {
      type: String,
      default: undefined
    },
    title: {
      type: String,
      default: undefined
    },
    value: {
      type: String,
      default: undefined
    },
    smallValue: {
      type: String,
      default: undefined
    },
    color: {
      type: String,
      default: undefined
    }
  }
}
</script>
