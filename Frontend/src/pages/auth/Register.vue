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
        <div class="text-subtitle-1 text-medium-emphasis">Name</div>
  
        <v-text-field
          v-model="name"
          density="compact"
          placeholder="Name"
          prepend-inner-icon="mdi-account-outline"
          variant="outlined"
        ></v-text-field>

        <div class="text-subtitle-1 text-medium-emphasis">Email</div>
  
        <v-text-field
          v-model="email"
          density="compact"
          placeholder="Email address"
          prepend-inner-icon="mdi-email-outline"
          variant="outlined"
        ></v-text-field>
  
        <div class="text-subtitle-1 text-medium-emphasis">Password</div>

        <v-text-field
          v-model="password"
          :append-inner-icon="visible ? 'mdi-eye-off' : 'mdi-eye'"
          :type="visible ? 'text' : 'password'"
          density="compact"
          placeholder="Enter your password"
          prepend-inner-icon="mdi-lock-outline"
          variant="outlined"
          @click:append-inner="visible = !visible"
        ></v-text-field>
  
  
        <v-btn
          class="mb-8"
          color="blue"
          size="large"
          variant="tonal"
          block
          @click="registration"
        >
          Register
        </v-btn>
  
        <v-card-text class="text-center">
          <a
            class="text-blue text-decoration-none"
            rel="noopener noreferrer"
            @click="goToLogin"
            style="cursor: pointer;"
          >
            Already have an account?
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
      name: "",
      email: "",
      password: "",
      visible: false,
    };
  },

  methods: {
    async registration() {
      try {
        const response = await apiClient.post('/register', {
            name: this.name,
            email: this.email,
            password: this.password
        })

        console.log(response);

        // Store the token in a cookie
        const token = response.data.token;
        document.cookie = `auth_token=${token}; path=/; max-age=${
          24 * 60 * 60
        }`; // 1 day

        // Redirect to the profile page
        this.$router.push("/");
      } catch (error) {
        console.error("Login failed", error);
        alert("Login failed. Please check your credentials.");
      }
    },

    goToLogin() {
      this.$router.push('/auth/login')
    },
  },
}
</script>