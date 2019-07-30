<template>
  <v-layout row fill-height>
    <v-flex lg8 md6 class="hidden-sm-and-down"></v-flex>
    <v-flex class="layout align-center justify-center">
      <v-flex xs9>
        <v-form @submit.prevent="submit">
          <v-layout column justify-center>
            <v-flex>
              <v-layout row wrap justify-center py-2>
                <span class="display-3">Sign In</span>
              </v-layout>
            </v-flex>
            <v-flex class="pb-3">
              <v-layout row wrap align-center justify-center>
                <v-btn dark icon color="blue">
                  <v-icon>mdi-facebook</v-icon>
                </v-btn>
                <v-btn dark icon color="red">
                  <v-icon>mdi-gmail</v-icon>
                </v-btn>
              </v-layout>
            </v-flex>
            <v-flex>
              <v-text-field
                v-model="formData.email"
                v-validate="'required'"
                :error-messages="errors.collect('Email')"
                name="Email"
                label="Email"
                prepend-inner-icon="mdi-account"
              ></v-text-field>
              <v-text-field
                type="password"
                v-model="formData.password"
                v-validate="'required'"
                :error-messages="errors.collect('Password')"
                name="Password"
                label="Password"
                prepend-inner-icon="mdi-shield-lock-outline"
              ></v-text-field>
            </v-flex>
            <v-flex class="layout justify-center">
              <v-btn text small>Fogot password?</v-btn>
            </v-flex>
            <v-flex class="layout justify-center">
              <v-btn rounded class="primary" block large @click="submit">Sign In</v-btn>
            </v-flex>
          </v-layout>
        </v-form>
      </v-flex>
    </v-flex>
    <v-dialog v-model="loading" persistent max-width="min-content" transition="dialog-transition">
      <v-card>
        <v-card-text>
          <v-progress-circular color="primary" indeterminate></v-progress-circular>
        </v-card-text>
      </v-card>
    </v-dialog>
  </v-layout>
</template>

<script>
import { mapActions } from "vuex";
export default {
  layout: "empty",
  data: () => ({
    formData: {
      //   email: "arabis.aldrin@yandex.com",
      //   password: "arabis"
    },
    loading: false
  }),
  methods: {
    async submit() {
      const valid = await this.$validator.validateAll();
      if (valid) {
        this.loading = true;
        try {
          await this.login(this.formData);
          this.$router.replace("/");
        } catch (ex) {
          console.log(ex);
        }
      }
    },
    ...mapActions(["login"])
  }
};
</script>
