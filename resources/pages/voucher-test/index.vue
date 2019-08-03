<template>
  <page title="Voucher Test">
    <v-container grid-list-md>
      <v-card class="mb-2">
        <v-card-text>
          <v-layout justify-center column>
            <v-flex>
              <v-text-field v-model="formData.voucher" label="Voucher" @keypress.enter="submit"></v-text-field>
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
        mac: "34-41-5D-D9-E3-06"
      },
      result: ""
    };
  },
  methods: {
    async submit() {
      const { data } = await axios.post("/portal/voucher", this.formData);
      this.result = data;
    }
  }
};
</script>
