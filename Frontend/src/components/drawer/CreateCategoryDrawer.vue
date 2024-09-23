<template>
    <div>  
      <v-navigation-drawer
        v-model="open"
        location="left"
        temporary
        :width="customWidth"
        app
      >
        <div>
          <v-list>
            <v-list-item>
              <v-list-item-content>
                <v-list-item-title>New Category</v-list-item-title>
              </v-list-item-content>
            </v-list-item>
          </v-list>
        
      <v-card
        class="mx-auto pa-12 pb-8"
        elevation="8"
        max-width="448"
        rounded="lg"
      >
          <v-text-field
            v-model="model.name"
            density="compact"
            label="Category Name"
            variant="outlined"
          ></v-text-field>

          <v-text-field
            v-model="model.title"
            density="compact"
            label="Category Title"
            variant="outlined"
          ></v-text-field>

          <v-textarea
            v-model="model.description"
            label="Description"
            variant="outlined"
            density="compact"
            rows="5"
            auto-grow
          ></v-textarea>

          <v-select
            v-model="model.type"
            :items="items"
            density="compact"
            label="Select Category Type"
            variant="outlined"
          ></v-select>

          
        <div class="d-flex align-center px-8">
            
          <v-btn  @click="submit"> Submit </v-btn>
          <v-spacer></v-spacer>
          <v-btn @click="handleReset"> clear </v-btn>
          <v-spacer></v-spacer>
          <v-btn @click="closeDrawer"> Cancel </v-btn>
        </div>


          

          
    </v-card>

      </div>

      </v-navigation-drawer>
    </div>
  </template>
  
  <script>
import apiClient from '@/plugins/axios';


  export default {
    props: {
        isOpen: {
            type: Boolean,
            required: false,
            default: false,
        },
    },

    data() {
      return {
        customWidth: 500,
        open: this.isOpen,
        model: {
          name: "",
          title: "",
          description: "",
          type: "",
          fields: [],
        },
        items: ['Asset', 'Event'],
      }
    },

    watch: {
        isOpen(newVal) {
            this.open = newVal;
        },
    },

    methods: {
      closeDrawer() {
          this.open = false;
          this.$emit('update:isOpen', false);
      },

      handleReset() {
        this.model.name = "";
        this.model.title = "";
        this.model.description = "";
        this.model.type = "";
        this.model.fields = [];
      },

      async submit() {
        try {
          await apiClient.post('/categories', this.model); 
          this.handleReset();
          this.closeDrawer();
        } catch (error) {
          console.error("Failed to create new task:", error);
        }
      }
    }
  }
  </script>
  
  