<template>
    <div>  
        <div>            
          <v-card
            class="mx-auto pa-12 pb-8"
            elevation="8"
            max-width="700"
            rounded="lg"
          >
            
          <div class="text-subtitle-1 text-medium-emphasis">Old Password</div>
          <v-text-field
            v-model="model.old_password"
            :append-inner-icon="visible ? 'mdi-eye-off' : 'mdi-eye'"
            :type="visible ? 'text' : 'password'"
            density="compact"
            placeholder="Enter your password"
            prepend-inner-icon="mdi-lock-outline"
            variant="outlined"
            @click:append-inner="visible = !visible"
          ></v-text-field>

          <div class="text-subtitle-1 text-medium-emphasis">New Password</div>
          <v-text-field
            v-model="model.new_password"
            :append-inner-icon="visible ? 'mdi-eye-off' : 'mdi-eye'"
            :type="visible ? 'text' : 'password'"
            density="compact"
            placeholder="Enter your password"
            prepend-inner-icon="mdi-lock-outline"
            variant="outlined"
            @click:append-inner="visible = !visible"
          ></v-text-field>
            
          <div class="d-flex justify-center gap-20 px-8">
            <v-btn @click="closeDialog"  variant="outlined" color="secondary">Close</v-btn>
            <v-btn @click="updatePassword" variant="outlined" color="success">Update Password</v-btn>
          </div>
        </v-card>

      </div>
    </div>
  </template>
  
  <script>
import methods from '@/components/methods';
import apiClient from '@/plugins/axios';
import store from '@/store';

  export default {
    props: {
      closeChangePasswordDialog: {
          type: Function,
          required: true,
        }
    },


    data() {
      return {
        open: true,
        customWidth: 700,
        
        model: {
          old_password: null,
          new_password: null,
        }
      };
    },

    methods: {
      
      closeDialog() {
        this.closeChangePasswordDialog();
      },

      async updatePassword() {
        try {
        await apiClient.post('/user/change-password', this.model);
        this.closeDialog();
        } catch(error) {
          methods.handleUnauthorizedError(error, 'Failed to password change.');
        }
      }

    }
  };
  </script>
  
