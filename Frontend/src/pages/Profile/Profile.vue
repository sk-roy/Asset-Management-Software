<template>
    <div>  
        <div>            
          <v-card
            class="mx-auto pa-12 pb-8"
            elevation="8"
            max-width="700"
            rounded="lg"
          >
            <v-card-title v-if="!editing">
                {{ user.name }}
            </v-card-title>

            
          <div v-if="editing" class="text-subtitle-1 text-medium-emphasis">Name</div>  
          <v-text-field
            v-if="editing"
            v-model="model.name"
            density="compact"
            placeholder="Name"
            prepend-inner-icon="mdi-account-outline"
            variant="outlined"
          ></v-text-field>
            
          <div v-if="editing" class="text-subtitle-1 text-medium-emphasis">Email</div>  
          <v-text-field
            v-if="editing"
            v-model="model.email"
            density="compact"
            placeholder="Name"
            prepend-inner-icon="mdi-account-outline"
            variant="outlined"
            class=" mb-4"
          ></v-text-field>
            

  
          <v-row>
            <v-col cols="12" v-if="!editing">
              <p><strong>Email: </strong>{{ user.email }}</p>
            </v-col>
          </v-row>

          <v-row>
            <v-col cols="12" v-if="!editing">
              <p><strong>User ID: </strong>{{ user.id }}</p>
            </v-col>
          </v-row>

          
          <v-spacer></v-spacer>

          <div class="d-flex justify-center gap-20 px-8">
            <v-btn @click="closeDialog"  variant="outlined" color="secondary">Close</v-btn>
            <v-btn v-if="!editing" @click="editUser" variant="outlined" color="success">Edit</v-btn>
            <v-btn v-if="editing" @click="updateUser" variant="outlined" color="success">Update</v-btn>
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
        closeProfileDialog: {
          type: Function,
          required: true,
        }
    },


    data() {
      return {
        open: true,
        customWidth: 700,
        user: {},
        editing: false,
        
        model: {
          name: "",
          email: "",
        }
      };
    },

    mounted() {
      this.getUser();

    },

    methods: {
      
      closeDialog() {
        this.closeProfileDialog();
      },

      async getUser() {
        try {
          await store.dispatch('fetchUser');
          this.user = store.getters.getUser;
        } catch (error) {
          methods.handleUnauthorizedError(error, "Fetching user failed")
        }
      },

      editUser() {
        this.model.name = this.user.name;
        this.model.email = this.user.email;
        this.editing = true;
      },

      async updateUser() {
        await apiClient.post('/user/update', this.model);
        await this.getUser();
        this.editing = false;
      }

    }
  };
  </script>
  
