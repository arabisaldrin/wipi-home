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
        <v-tab>Devices</v-tab>
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
      <v-tab-item>
        <v-alert
          type="info"
          :value="true"
        >Associating device(s) will restrict connection only to this device(s)</v-alert>
        <v-checkbox
          :disabled="hasDevice"
          label="Auto connect?"
          v-model="formData.auto_connect"
          hide-details
        ></v-checkbox>
        <v-list>
          <v-list-item class="pa-0" v-for="(device,i) in formData.devices" :key="i">
            <v-layout row>
              <v-flex grow>
                <v-text-field
                  :disabled="(i+1) !== formData.devices.length"
                  v-model="device.mac_address"
                  label="Mac address"
                ></v-text-field>
              </v-flex>
              <v-flex shrink>
                <v-btn
                  icon
                  v-if="(i+1) === formData.devices.length"
                  :disabled="!device.mac_address"
                  @click="formData.devices.push({})"
                >
                  <v-icon>mdi-plus</v-icon>
                </v-btn>
                <v-btn icon v-else @click="formData.devices.splice(i,1)">
                  <v-icon color="red">mdi-delete</v-icon>
                </v-btn>
              </v-flex>
            </v-layout>
          </v-list-item>
        </v-list>
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
import { mapActions, mapState, mapGetters } from "vuex";
import attrMixin from "@/js/mixins/attribute-mixin";
export default {
  mixins: [attrMixin],
  data() {
    return {
      tab: 0,
      loading: false,
      formData: {
        check: {},
        reply: {},
        devices: [
          {
            mac_address: ""
          }
        ]
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
    ...mapGetters({
      find: "users/find"
    }),
    userId() {
      return this.$route.params.id;
    },
    hasDevice() {
      return !this.formData.devices.filter(e => !!e.mac_address).length;
    }
  },
  async created() {
    await this.getPlans();
    const data = await this.find(this.userId);
    data.devices.push({});
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
        try {
          this.loading = true;
          await this.updateUser(this.formData);
          this.$toast.success("toast.success", ["User", "updated"]);
          close();
        } catch (error) {
          console.log(error);
          this.$toast.success(this.$t("toast.error"), ["udpate", "User"]);
        }
      }
    }
  }
};
</script>
