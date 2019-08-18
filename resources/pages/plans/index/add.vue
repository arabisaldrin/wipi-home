<template>
  <dialog-page
    title="Add Plan"
    icon="mdi-ticket-confirmation"
    max-width="500"
    persistent
    @accept="save"
  >
    <template slot="extension">
      <v-tabs v-model="tab" dark background-color="primary" slider-color="white">
        <v-tab :class="{'red--text' : errors.any()}">Plan Info</v-tab>
        <v-tab>Subscription</v-tab>
      </v-tabs>
    </template>
    <v-tabs-items v-model="tab">
      <v-tab-item>
        <v-text-field
          v-model.number="formData.code"
          v-validate="'required'"
          :error-messages="errors.collect('Code')"
          name="Code"
          label="Code"
          prepend-inner-icon="mdi-code-array"
        ></v-text-field>
        <v-textarea v-model="formData.description" rows="3" label="Description"></v-textarea>
      </v-tab-item>
      <v-tab-item>
        <v-alert type="info" class="pa-2" :value="true">All fields are optional</v-alert>
        <v-text-field
          type="number"
          v-model.number="formData.check['Simultaneous-Use']"
          @keydown="checkInput"
          label="Simultaneous Use"
          placeholder="No Limit"
          prepend-inner-icon="mdi-cellphone-link"
        ></v-text-field>
        <v-text-field
          type="number"
          v-model.number="dailyTime"
          @keydown="checkInput"
          label="Daily Time"
          placeholder="All Day"
          prepend-inner-icon="mdi-calendar-clock"
        >
          <template slot="append">mins</template>
        </v-text-field>
        <v-text-field
          type="number"
          v-model.number="sessionTime"
          @keydown="checkInput"
          label="Session Time"
          placeholder="No Timout"
          prepend-inner-icon="mdi-account-clock"
        >
          <template slot="append">mins</template>
        </v-text-field>
        <v-text-field
          type="number"
          v-model.number="speed"
          @keydown="checkInput"
          label="Band-width"
          placeholder="Full Speed"
          prepend-inner-icon="mdi-speedometer"
        >
          <template slot="append">mb/s</template>
        </v-text-field>
        <v-text-field
          type="number"
          v-model.number="cap"
          @keydown="checkInput"
          label="Data Cap"
          placeholder="No Data Cap"
          prepend-inner-icon="mdi-cloud-download-outline"
        >
          <template slot="append">mb</template>
        </v-text-field>
      </v-tab-item>
    </v-tabs-items>
    <template v-slot:actions="{close,accept}">
      <v-btn text class="mx-1" @click="close">Cancel</v-btn>
      <v-btn outlined color="primary" class="mx-1" @click="accept(close)">
        <v-icon left>mdi-check</v-icon>Save
      </v-btn>
    </template>
  </dialog-page>
</template>

<script>
import { mapActions } from "vuex";
import attrMixin from "@/js/mixins/attribute-mixin";
export default {
  mixins: [attrMixin],
  data() {
    return {
      tab: 0,
      formData: {
        reply: {},
        check: {}
      }
    };
  },
  methods: {
    checkInput(e) {
      if (e.keyCode === 69 || e.keyCode === 190) {
        e.preventDefault();
        e.stopPropagation();
        return false;
      }
    },
    async save(close) {
      const valid = await this.$validator.validateAll();
      if (valid) {
        await this.addPlan(this.formData);
        close();
      }
    },
    ...mapActions({
      addPlan: "plans/add"
    })
  }
};
</script>
