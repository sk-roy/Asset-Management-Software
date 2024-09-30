<template>
    <div>  
      <v-navigation-drawer
        v-model="eventDrawerIsOpen"
        location="right"
        temporary
        :width="customWidth"
        app
      >
        <div>
          <v-row class="d-flex justify-space-between">
            <v-col cols="auto">
              <v-list>
                <v-list-item>
                  <v-list-item-title> {{ eventDrawerEventId == null ? 'New Event' : 'Editing Event' }} </v-list-item-title>
                </v-list-item>
              </v-list>
            </v-col>

            <v-col cols="auto"  style="padding: 20px;">
              <v-btn icon @click="closeDrawer" class="mx-auto close-btn">
                <v-icon>mdi-close</v-icon>
              </v-btn>
            </v-col>
          </v-row>
                
          <v-card
            class="mx-auto pa-12 pb-8"
            elevation="8"
            max-width="650"
            rounded="lg"
          >
                       
              <!-- Common Fields for All Events -->
              <v-row>
              <v-col cols="9">
                <v-text-field v-model="model.title" label="Event Title" variant="outlined" density="compact"></v-text-field>
              </v-col>
              <v-col cols="3" class="d-flex align-end justify-end">
                <v-switch v-model="model.active_mode" color="primary"></v-switch>
              </v-col>
              <v-col cols="12" md="6">
                <v-text-field v-model="model.datetime" label="Event Date & Time" type="datetime-local" variant="outlined" density="compact"></v-text-field>
              </v-col>
              <v-col cols="12" md="6">                
                <v-select
                  multiple
                  v-model="model.repeatDays"
                  :items="['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday']"
                  label="Repeat on Days"
                  variant="outlined"
                  density="compact"
                ></v-select>
              </v-col>
              <v-col cols="12">
                <v-textarea v-model="model.description" label="Event Description" variant="outlined" density="compact"></v-textarea>
              </v-col>
              <v-col cols="12" md="6">
                <v-text-field v-model="model.charge" label="Charge" variant="outlined" density="compact"></v-text-field>
              </v-col>
              <v-col cols="12" md="6">
                <v-text-field v-model="model.map_location" label="Map Location" variant="outlined" density="compact"></v-text-field>
              </v-col>
            </v-row>

              <v-select
                v-model="model.asset_id"
                :items="assets"
                item-title="title"
                item-value="id"
                label="Select Asset"
                variant="outlined"
                density="compact"
                persistent-hint
                single-line
                @change="onAssetChange"
              ></v-select>

              <v-select
                v-model="model.category_id"
                :items="categories"
                item-title="name"
                item-value="id"
                label="Select Category"
                variant="outlined"
                density="compact"
                persistent-hint
                single-line
                @change="onCategoryChange"
              ></v-select>



                <!-- Conditional Fields Based on Event Category -->
                <!-- Service (Category ID: 6) -->
                <v-row v-if="model.category_id === 6">
                  <v-col cols="12">
                    <v-text-field v-model="model.service_provider" label="Service Provider" variant="outlined" density="compact"></v-text-field>
                  </v-col>
                  <v-col cols="12">
                    <v-textarea v-model="model.service_details" label="Service Details" variant="outlined" density="compact"></v-textarea>
                  </v-col>
                </v-row>

                <!-- Clean (Category ID: 7) -->
                <v-row v-if="model.category_id === 7">
                  <v-col cols="12" md="6">
                    <v-text-field v-model="model.cleaning_service" label="Cleaning Service" variant="outlined" density="compact"></v-text-field>
                  </v-col>
                  <v-col cols="12" md="6">
                    <v-text-field v-model="model.cleaning_charge" label="Cleaning Charge" variant="outlined" density="compact"></v-text-field>
                  </v-col>
                </v-row>

                <!-- Replace (Category ID: 8) -->
                <v-row v-if="model.category_id === 8">
                  <v-col cols="12">
                    <v-text-field v-model="model.replacement_item" label="Replacement Item" variant="outlined" density="compact"></v-text-field>
                  </v-col>
                  <v-col cols="12" md="6">
                    <v-text-field v-model="model.replacement_cost" label="Replacement Cost" variant="outlined" density="compact"></v-text-field>
                  </v-col>
                </v-row>

                <!-- Visit (Category ID: 9) -->
                <v-row v-if="model.category_id === 9">
                  <v-col cols="12" md="6">
                    <v-text-field v-model="model.visitor_name" label="Visitor Name" variant="outlined" density="compact"></v-text-field>
                  </v-col>
                  <v-col cols="12" md="6">
                    <v-text-field v-model="model.visit_purpose" label="Visit Purpose" variant="outlined" density="compact"></v-text-field>
                  </v-col>
                </v-row>

                <!-- Bill Payment (Category ID: 10) -->
                <v-row v-if="model.category_id === 10">
                  <v-col cols="12" md="6">
                    <v-text-field v-model="model.bill_provider" label="Bill Provider" variant="outlined" density="compact"></v-text-field>
                  </v-col>
                  <v-col cols="12" md="6">
                    <v-text-field v-model="model.bill_amount" label="Bill Amount" variant="outlined" density="compact"></v-text-field>
                  </v-col>
                </v-row>

              <div class="d-flex justify-center gap-20 px-8">
                <v-btn @click="closeDrawer" variant="outlined" color="secondary">Cancel</v-btn>
                <v-btn @click="updateEvent" v-if="eventDrawerEventId != null" variant="outlined" color="success">Update</v-btn>
                <v-btn @click="createEvent" v-if="eventDrawerEventId == null" variant="outlined" color="success">Submit</v-btn>
              </div>

          </v-card>
        </div>
      </v-navigation-drawer>
    </div>
</template>
  
<script>
import apiClient from '@/plugins/axios';
import store from '@/store';
import { mapGetters, mapActions, mapState } from 'vuex';


  export default {

    data() {
      return {
        customWidth: 700,
        open: false,

        model: {
          title: '',
          datetime: '',
          description: '',
          charge: '',
          active_mode: true,
          map_location: '',
          asset_id: null,
          category_id: null,
          service_provider: '',
          service_details: '',
          cleaning_service: '',
          cleaning_charge: '',
          replacement_item: '',
          replacement_cost: '',
          visitor_name: '',
          visit_purpose: '',
          bill_provider: '',
          bill_amount: '',

          repeatDays: null,
        },
        
        categories: [],
        assets: [],
      }
    },
   
    watch: {
      eventDrawerIsOpen() {
        this.fetchEvent();
        this.fetchCategories();
        this.fetchAssets();
      },
    },

    computed: {
      ...mapGetters([
        'eventDrawerIsOpen',
        'eventDrawerEventId',
        'eventDrawerCategoryId',
        'eventDrawerAssetId'
      ]),
    },

    methods: {
      handleReset() {
      },

      closeDrawer()  {
        store.commit('closeEventDrawer');
      },

      async fetchCategories() {
        try {
          await store.dispatch('fetchCategories', { type: "event" });
          this.categories = store.getters.getCategories('event');

          if (this.eventDrawerCategoryId) {
            this.model.category_id = this.eventDrawerCategoryId;
          } else if (this.categories.length > 0) {
            this.model.category_id = this.categories[0].id;
          }
        } catch (error) {
          console.error("Fetching categories failed", error);
        }
      },

      async fetchAssets() {
        try {
          await store.dispatch('fetchAssets');
          this.assets = store.getters.getAssets;

          if (this.eventDrawerAssetId) {
            this.model.asset_id = this.eventDrawerAssetId;
          } else if (this.assets.length > 0) {
            this.model.asset_id = this.assets[0].id;
          }
        } catch (error) {
          console.error("Fetching assets failed", error);
        }
      },

      async createEvent() {          
        try {
          await apiClient.post("/events", this.model);
          window.location.reload();
        } catch (error) {
          console.error("Failed to create new event:", error);
          alert("Failed to create new event.");
        }
      },

      async updateEvent() {          
        try {
          await apiClient.patch(`/events/${this.eventDrawerEventId}`, this.model);
          window.location.reload();
        } catch (error) {
          console.error("Failed to updating new event:", error);
          alert("Failed to updating new event.");
        }
      },

      onCategoryChange(value) {
        this.model.category_id = value;
      },

      onAssetChange(value) {
        this.model.asset_id = value;
      },

      fetchEvent() {
        if (this.eventDrawerEventId != null) {
          this.model = store.getters.getEventDetails(this.eventDrawerEventId);
        } else {
          this.resetModel();
        }
      },

      resetModel() {
        this.model = {
          title: '',
          datetime: '',
          description: '',
          charge: '',
          active_mode: true,
          map_location: '',
          asset_id: null,
          category_id: null,
          service_provider: '',
          service_details: '',
          cleaning_service: '',
          cleaning_charge: '',
          replacement_item: '',
          replacement_cost: '',
          visitor_name: '',
          visit_purpose: '',
          bill_provider: '',
          bill_amount: '',

          repeatDays: null,
        };
      },
    },
  }
</script>
  
  
