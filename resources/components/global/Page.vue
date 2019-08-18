<template>
  <div>
    <v-container grid-list-md py-0 class="page">
      <div class="page-title mb-3 layout align-center py-2 wrap">
        <span
          class="white--text text"
          :style="`margin-left : ${scrollOffset}px;opacity : ${scrollOffset-10 >= 40 ? '0' : '1'};font-size : calc(40px - ${scrollOffset * .5}px)`"
        >
          <slot name="title">{{title}}</slot>
        </span>
        <v-divider vertical inset class="mx-3"></v-divider>
        <slot name="tools"></slot>
      </div>
    </v-container>
    <v-form @submit.prevent="$emit('accept')">
      <slot></slot>
    </v-form>
    <v-scale-transition>
      <v-btn
        v-show="scrolling"
        @click="$vuetify.goTo(1)"
        fab
        color="primary"
        bottom
        right
        fixed
        x-small
        @click.stop
        style="bottom : 50px"
      >
        <v-icon>mdi-arrow-up</v-icon>
      </v-btn>
    </v-scale-transition>
  </div>
</template>

<script>
import { mapMutations } from "vuex";
export default {
  props: {
    title: {
      type: String
    },
    scheme: {
      type: String,
      default: "primary"
    },
    panelHeight: {
      type: String,
      default: "184px"
    }
  },
  data() {
    return {
      visibleoffset: 42,
      visibleoffsetbottom: 0,
      scrollOffset: 0,
      scrolling: false
    };
  },
  created() {
    document.title = this.title;
    const { title, scheme, panelHeight, scrolling } = this;
    this.setPage({
      title,
      scheme,
      scrolling,
      panelHeight
    });
  },
  mounted() {
    const throttle = (fn, wait) => {
      var time = Date.now();
      return function() {
        if (time + wait - Date.now() < 0) {
          fn();
          time = Date.now();
        }
      };
    };
    window.addEventListener("scroll", this.catchScroll);
  },
  methods: {
    catchScroll() {
      if (window.pageYOffset - 5 <= this.visibleoffset) {
        this.scrollOffset = window.pageYOffset;
      } else {
        this.scrollOffset = 40;
      }
      const pastTopOffset = window.pageYOffset > parseInt(this.visibleoffset);
      const pastBottomOffset =
        window.innerHeight + window.pageYOffset >=
        document.body.offsetHeight - parseInt(this.visibleoffsetbottom);
      const scrolling =
        parseInt(this.visibleoffsetbottom) > 0
          ? pastTopOffset && !pastBottomOffset
          : pastTopOffset;
      if (this.scrolling != scrolling) {
        this.scrolling = scrolling;
        this.setScrolling(this.scrolling);
      }
    },
    ...mapMutations(["setPage", "setScrolling"])
  }
};
</script>

<style lang="scss">
.page {
  position: inherit;
  &-title {
    position: relative;
    .text {
      position: -webkit-sticky;
      position: sticky;
      top: 20px;
    }
  }
}
</style>
