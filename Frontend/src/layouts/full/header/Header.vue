<script>
import store from '@/store';
import Cookies from 'js-cookie';
import { ref } from "vue";
import { profile } from "./data";
import Profile from '@/pages/Profile/Profile.vue';
import ChangePassword from '@/pages/Profile/ChangePassword.vue';


export default {
  data() {
    return {
      userprofile: ref(profile),
      profileDialog: false,
      changePasswordDialog: false,
    }
  },

  components: {
    Profile,
    ChangePassword,
  },

  methods: {    
    async logout() {
      try {
        const response = await store.dispatch('logout');

        console.log('Logout successful:', response.data)

        Cookies.remove('auth_token', { path: '/' })
        
        this.$router.push('login');
      } catch (error) {
        console.error("Logout failed", error);
      }
    },

    onClickItem(item) {
      console.log('onClickItem', item);
      if (item.title == "My Profile") {
        this.profileDialog = true;  
      } else if (item.title == "Password Change") {
        this.changePasswordDialog = true;
      }
    }, 

    closeProfileDialog() {
      this.profileDialog = false;
    },

    closeChangePasswordDialog() {
      console.log('closeChangePasswordDialog');
      this.changePasswordDialog = false;
    }
  }
}
</script>


<template>
  <div>
    <!-- ---------------------------------------------- -->
    <!-- User Profile -->
    <!-- ---------------------------------------------- -->
    <v-menu anchor="bottom end" origin="auto" min-width="300">
      <template v-slot:activator="{ props }">
        <v-btn
          v-bind="props"
          class="pa-0 px-1"
          elevation="0"
          color="transparent"
          plain
          :ripple="false"
        >
          <v-avatar size="35">
            <img src="@/assets/images/users/user2.jpg" alt="Julia" />
          </v-avatar>
        </v-btn>
      </template>

      <v-list class="pa-6" elevation="10" rounded="lg">
        <v-list-item
          class="pa-3 mb-2"
          v-for="(item, i) in userprofile"
          :key="i"
          :value="item"
          :title="item.title"
          :subtitle="item.desc"
          rounded="lg"
          @click="onClickItem(item)"
        >
         
        </v-list-item>

        <v-btn block color="secondary" variant="contained" class="mt-4 py-4" @click="logout"
        >Logout</v-btn
        >
      </v-list>
    </v-menu>
    
    <v-dialog v-model="profileDialog" max-width="700">
        <Profile :closeProfileDialog="closeProfileDialog"/>
    </v-dialog>

    <v-dialog v-model="changePasswordDialog" max-width="700">
        <ChangePassword :closeChangePasswordDialog="closeChangePasswordDialog"/>
    </v-dialog>
  </div>
</template>
