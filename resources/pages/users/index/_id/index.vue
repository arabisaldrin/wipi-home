<template>
  <dialog-page
    title="Update User"
    icon="mdi-account-edit"
    max-width="500"
    persistent
    @accept="save"
  >
    <template slot="extension">
      <v-tabs v-model="tab" dark background-color="primary" slider-color="white">
        <v-tab :class="{'error--text' : errors.any()}">Login</v-tab>
        <v-tab>User Info</v-tab>
        <v-tab>Subscription</v-tab>
      </v-tabs>
    </template>
    <v-tabs-items v-model="tab">
      <v-tab-item>
        <v-layout column>
          <v-flex>
            <v-text-field
              v-model="formData.username"
              v-validate="'required'"
              :error-messages="errors.collect('Username')"
              name="Username"
              label="Username"
              prepend-inner-icon="mdi-account"
            ></v-text-field>
          </v-flex>
          <v-flex>
            <v-text-field
              v-model="formData.check['Cleartext-Password']"
              v-validate="'required'"
              :error-messages="errors.collect('Password')"
              name="Password"
              label="Password"
              prepend-inner-icon="mdi-key"
            ></v-text-field>
          </v-flex>
        </v-layout>
      </v-tab-item>
      <v-tab-item>
        <v-alert type="info" class="pa-2" :value="true">All fields are optional</v-alert>
        <v-layout column>
          <v-flex>
            <v-text-field
              v-model="formData.first_name"
              name="First name"
              label="First name"
              prepend-inner-icon="mdi-account"
            ></v-text-field>
          </v-flex>
          <v-flex>
            <v-text-field
              v-model="formData.last_name"
              name="Last name"
              label="Last name"
              prepend-inner-icon="mdi-account"
            ></v-text-field>
          </v-flex>
          <v-flex>
            <v-text-field
              v-model="formData.email_address"
              name="Email Address"
              label="Email Address"
              prepend-inner-icon="mdi-at"
            ></v-text-field>
          </v-flex>
          <v-flex>
            <v-text-field
              v-model="formData.mobile_number"
              name="Mobile No."
              label="Mobile No."
              prepend-inner-icon="mdi-cellphone"
            ></v-text-field>
          </v-flex>
        </v-layout>
      </v-tab-item>
      <v-tab-item>
        <v-select
          :items="plans"
          v-model="formData.plan"
          label="Plan"
          item-text="code"
          return-object
        ></v-select>
      </v-tab-item>
    </v-tabs-items>
    <template v-slot:actions="{close,accept}">
      <v-btn :disabled="loading" text class="mx-1" @click="close">Cancel</v-btn>
      <v-btn :loading="loading" outlined color="primary" class="mx-1" @click="accept(close)">
        <v-icon left>mdi-check</v-icon>Save
      </v-btn>
    </template>
  </dialog-page>
</template>

<script>
import { mapActions, mapState } from "vuex";
import attrMixin from "@/js/mixins/attribute-mixin";
export default {
  mixins: [attrMixin],
  data() {
    return {
      tab: 0,
      loading: false,
      formData: {
        check: {},
        reply: {}
      },
      cap: undefined,
      speed: undefined,
      dailyTime: undefined,
      sessionTime: undefined
    };
  },
  computed: {
    ...mapState({
      plans: s => s.plans.lists
    }),
    userId() {
      return this.$route.params.id;
    }
  },
  async created() {
    await this.getPlans();
    const { data } = await axios.get(`/users/${this.userId}`);
    this.convertFrom(data);
    this.formData = data;
  },
  methods: {
    ...mapActions({
      updateUser: "users/update",
      getPlans: "plans/fetch"
    }),
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
        await this.updateUser(this.formData);
        close();
      }
    }
  }
};
</script>
