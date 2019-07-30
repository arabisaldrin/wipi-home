<template>
  <dialog-page
    title="Create Voucher(s)"
    icon="mdi-ticket-confirmation"
    max-width="500"
    persistent
    @accept="save"
  >
    <v-layout column wrap>
      <v-flex class="px-3">
        <v-subheader class="pl-0">Generation count ({{formData.total_vouchers}})</v-subheader>
        <v-slider
          hide-details
          v-model="formData.total_vouchers"
          min="1"
          :thumb-size="24"
          thumb-label
        ></v-slider>
      </v-flex>
      <v-flex>
        <v-autocomplete
          v-validate="'required'"
          v-model="formData.plan_id"
          :items="plans"
          :error-messages="errors.collect('Plan')"
          prepend-inner-icon="mdi-cash-usd"
          item-text="code"
          item-value="id"
          label="Plan"
          name="Plan"
        ></v-autocomplete>
      </v-flex>
      <v-flex>
        <v-menu offset-y>
          <template v-slot:activator="{on}">
            <v-text-field
              readonly
              name="Expiration"
              label="Expiration"
              prepend-inner-icon="mdi-calendar"
              :value="formData.expiration"
              placeholder="No Expiration"
              v-on="on"
            ></v-text-field>
          </template>
          <v-date-picker
            v-model="formData.expiration"
            reactive
            :min="$moment().format('YYYY-MM-DD')"
          ></v-date-picker>
        </v-menu>
      </v-flex>
      <v-flex>
        <v-textarea
          v-model="formData.description"
          :error-messages="errors.collect('Description')"
          v-validate="'required'"
          rows="3"
          label="Description"
          name="Description"
        ></v-textarea>
      </v-flex>
    </v-layout>
    <template v-slot:actions="{close,accept}">
      <v-btn text class="mx-1" @click="close">Cancel</v-btn>
      <v-btn :loading="loading" outlined color="primary" class="mx-1" @click="accept(close)">
        <v-icon left>mdi-check</v-icon>Save
      </v-btn>
    </template>
  </dialog-page>
</template>

<script>
import { mapActions, mapState } from "vuex";
export default {
  data() {
    return {
      tab: 0,
      loading: false,
      formData: {}
    };
  },
  computed: {
    ...mapState({
      plans: s => s.plans.lists
    })
  },
  created() {
    this.fetchPlans();
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
        this.loading = true;
        await this.addVoucher(this.formData);
        this.getVoucherGroups();
        close();
      }
    },
    ...mapActions({
      fetchVouchers: "vouchers/fetch",
      addVoucher: "vouchers/add",
      getVouchers: "vouchers/fetch",
      fetchPlans: "plans/fetch",
      getVoucherGroups: "voucherGroups/fetch"
    })
  },
  watch: {
    formData: {
      deep: true,
      handler: function(val) {
        const plan = this.plans.find(e => e.id === val.plan_id);
        if (plan) {
          if (val.expiration) {
            var exp = this.$moment(val.expiration).format("YYYY-MM-DD");
          }
          this.formData.description = `${
            val.total_vouchers
          } voucher(s) of plan ${plan.code}${
            exp ? " - Expiration on " + exp : ""
          }`;
        }
      }
    }
  }
};
</script>
