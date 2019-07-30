<template>
  <dialog-page
    :title="`Update Voucher (${formData.code})`"
    icon="mdi-ticket-confirmation"
    max-width="500"
    persistent
    @accept="save"
  >
    <v-layout column wrap>
      <v-flex>
        <v-autocomplete
          v-model="formData.plan_id"
          :items="plans"
          prepend-inner-icon="mdi-cash-usd"
          item-text="code"
          item-value="id"
          label="Plan"
        ></v-autocomplete>
      </v-flex>
      <v-flex>
        <v-menu offset-y>
          <template v-slot:activator="{on}">
            <v-text-field
              :value="formData.expiration"
              readonly
              prepend-inner-icon="mdi-calendar"
              placeholder="No Expiration"
              name="Expiration"
              label="Expiration"
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
    voucherId() {
      return this.$route.params.id;
    },
    ...mapState({
      plans: s => s.plans.lists
    })
  },
  async created() {
    const { data } = await axios.get(`/vouchers/${this.voucherId}`);
    this.formData = data;
    this.getPlans();
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
        await this.updateVoucher(this.formData);
        close();
      }
    },
    ...mapActions({
      updateVoucher: "users/update",
      getPlans: "plans/fetch"
    })
  }
};
</script>
