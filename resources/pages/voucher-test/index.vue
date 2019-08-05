<template>
  <page title="Voucher Test">
    <v-container grid-list-md>
      <v-card class="mb-2">
        <v-card-text>
          <v-layout justify-center column>
            <v-flex>
              <v-text-field
                v-model="formData.voucher"
                v-validate="'required'"
                :error="errors.has('Voucher')"
                label="Voucher"
                name="Voucher"
                @keypress.enter="submit"
              ></v-text-field>
            </v-flex>
            <v-flex>
              <v-btn block color="primary" @click="submit">Submit</v-btn>
            </v-flex>
          </v-layout>
        </v-card-text>
      </v-card>
      <v-card>
        <v-card-text>
          <pre>{{JSON.stringify(result, null, 2)}}</pre>
        </v-card-text>
      </v-card>
    </v-container>
  </page>
</template>

<script>
export default {
  data() {
    return {
      formData: {
        res: "notyet",
        uamip: "192.168.10.1",
        uamport: "3990",
        challenge: "2c8aa29f59591f39a7c6a3c7d0f2dcf2",
        called: "B8-27-EB-33-17-3D",
        mac: "34-41-5D-D9-E3-06",
        ip: "192.168.10.4",
        ssid: "Arabis-GOWIFI",
        nasid: "Kupiki",
        sessionid: "156501567000000001",
        userurl: "http://google.com/",
        voucher: ""
      },
      result: ""
    };
  },
  methods: {
    async submit() {
      const valid = await this.$validator.validateAll();
      if (valid) {
        const { data } = await axios.post("/portal/voucher", this.formData);
        this.result = data;
      }
    }
  }
};
</script>
