<template>
    <div>
      <v-img
        class="mx-auto my-6"
        max-width="150"
        src="https://img.freepik.com/free-vector/colorful-letter-gradient-logo-design_474888-2309.jpg?w=740&t=st=1726240262~exp=1726240862~hmac=a4c9e4d3c4eefc2a210a01ecec64619e56a4dea387fa00ce7c9ca79b4b02343e"     
      ></v-img>
  
      <v-card
        class="mx-auto pa-12 pb-8"
        elevation="8"
        max-width="448"
        rounded="lg"
      >
        <div class="text-subtitle-1 text-medium-emphasis">Email</div>
  
        <v-text-field
          v-model="email"
          density="compact"
          placeholder="Email address"
          prepend-inner-icon="mdi-email-outline"
          variant="outlined"
        ></v-text-field>
  
  
        <v-btn
          class="mb-8"
          color="blue"
          size="large"
          variant="tonal"
          block
          @click="resetPassword"
        >
          Get Reset Link
        </v-btn>
  
        <v-card-text class="text-center">
          <a
            class="text-blue text-decoration-none"
            rel="noopener noreferrer"
            @click="goToRegister"
            style="cursor: pointer;"
          >
            Don't have an account? Register
          </a>
        </v-card-text>
      </v-card>
    </div>
  </template>


<script>
import apiClient from '../../plugins/axios.js'

export default {

  data() {
    return {
      email: "",
    };
  },

  methods: {
    async resetPassword() {
      try {
        const response = await apiClient.post('/forgot-password', {
          email: this.email,
        })

        console.log(response);
      } catch (error) {
        console.error("Login failed", error);
        alert("Login failed. Please check your credentials.");
      }
    },

    goToRegister() {
      this.$router.push('/register')
    },
  },
}
</script>