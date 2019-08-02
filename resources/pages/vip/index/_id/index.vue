<template>
  <dialog-page title="Update VIP" icon="mdi-account-plus" max-width="500" persistent @accept="save">
    <template slot="extension">
      <v-tabs v-model="tab" dark background-color="primary" slider-color="white">
        <v-tab :class="{'error--text' : errors.any()}">User Info</v-tab>
        <v-tab>Devices</v-tab>
      </v-tabs>
    </template>
    <v-tabs-items v-model="tab">
      <v-tab-item>
        <v-form>
          <v-layout column>
            <v-flex>
              <v-text-field
                v-model="formData.name"
                v-validate="'required'"
                :error-messages="errors.collect('Name')"
                name="Name"
                label="Name"
              ></v-text-field>
            </v-flex>
          </v-layout>
        </v-form>
      </v-tab-item>
      <v-tab-item>
        <v-list>
          <v-list-item v-for="(device,i) in formData.devices" :key="i">
            <v-layout row>
              <v-flex grow>
                <v-text-field
                  :disabled="(i+1) !== formData.devices.length"
                  v-model="device.mac_address"
                  label="Mac"
                ></v-text-field>
              </v-flex>
              <v-flex shrink>
                <v-btn
                  icon
                  v-if="(i+1) === formData.devices.length"
                  :disabled="!device.mac"
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
      <v-btn text class="mx-1" @click="close">Cancel</v-btn>
      <v-btn :loading="loading" outlined color="primary" class="mx-1" @click="accept(close)">
        <v-icon left>mdi-check</v-icon>Save
      </v-btn>
    </template>
  </dialog-page>
</template>

<script>
import { mapActions, mapGetters } from "vuex";
export default {
  data() {
    return {
      tab: 0,
      formData: {
        devices: [
          {
            mac_address: ""
          }
        ]
      },
      loading: false
    };
  },
  computed: {
    vipId() {
      return this.$route.params.id;
    },
    ...mapGetters({
      find: "vips/find"
    })
  },
  async created() {
    this.formData = await this.find(this.vipId);
  },
  methods: {
    ...mapActions({
      update: "vips/update"
    }),
    async save(close) {
      const valid = await this.$validator.validateAll();
      if (valid) {
        await this.update(this.formData);
        close();
      }
    }
  }
};
</script>