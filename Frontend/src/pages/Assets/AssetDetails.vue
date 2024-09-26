<template>
    <div>  
        <div>            
          <v-card
            class="mx-auto pa-12 pb-8"
            elevation="8"
            max-width="700"
            rounded="lg"
          >
            <!-- Asset Title -->

            <v-card-title>
                {{ asset.title }}
            </v-card-title>
            

            <div class="scrollable-content">
  
            <!-- Asset Description -->
            <v-row>
              <v-col cols="12">
                <p><strong>Description: </strong>{{ asset.description }}</p>
              </v-col>
            </v-row>
  
            <!-- Category Selection -->
            <v-row>
              <v-col cols="12">
                <p><strong>Category: </strong>{{ getCategoryName(asset.category_id) }}</p>
              </v-col>
            </v-row>
  
            <!-- Conditional Fields Based on Category -->
            <!-- Land or Flat -->
            <v-row v-if="asset.category_id === 1">
              <v-col cols="12" md="6">
                <p><strong>Address: </strong>{{ asset.address }}</p>
              </v-col>
              <v-col cols="12" md="6">
                <p><strong>Flat Number: </strong>{{ asset.flat_number }}</p>
              </v-col>
              <v-col cols="12" md="6">
                <p><strong>Floor Number: </strong>{{ asset.floor_number }}</p>
              </v-col>
              <v-col cols="12" md="6">
                <p><strong>Area: </strong>{{ asset.area }}</p>
              </v-col>
              <v-col cols="12" md="6">
                <p><strong>Purchase Price: </strong>{{ asset.purchase_price }}</p>
              </v-col>
              <v-col cols="12" md="6">
                <p><strong>Purchase Date: </strong>{{ asset.purchase_date }}</p>
              </v-col>
              <v-col cols="12">
                <p><strong>Diagram Path: </strong>{{ asset.diagram_path }}</p>
              </v-col>
              <v-col cols="12" md="6">
                <p><strong>Latitude: </strong>{{ asset.latitude }}</p>
              </v-col>
              <v-col cols="12" md="6">
                <p><strong>Longitude: </strong>{{ asset.longitude }}</p>
              </v-col>
            </v-row>
  
            <!-- Electronic Device -->
            <v-row v-if="asset.category_id === 2">
              <v-col cols="12" md="6">
                <p><strong>Brand: </strong>{{ asset.brand }}</p>
              </v-col>
              <v-col cols="12" md="6">
                <p><strong>Model: </strong>{{ asset.model }}</p>
              </v-col>
              <v-col cols="12" md="6">
                <p><strong>Capacity: </strong>{{ asset.capacity }}</p>
              </v-col>
              <v-col cols="12">
                <p><strong>Specification: </strong>{{ asset.specification }}</p>
              </v-col>
            </v-row>
  
            <!-- Furniture -->
            <v-row v-if="asset.category_id === 3">
              <v-col cols="12">
                <p><strong>Weight: </strong>{{ asset.weight }}</p>
              </v-col>
            </v-row>
  
            <!-- Vehicle -->
            <v-row v-if="asset.category_id === 4">
              <v-col cols="12" md="6">
                <p><strong>Plate Number: </strong>{{ asset.plate_number }}</p>
              </v-col>
              <v-col cols="12" md="6">
                <p><strong>Brand: </strong>{{ asset.brand }}</p>
              </v-col>
              <v-col cols="12" md="6">
                <p><strong>Model: </strong>{{ asset.model }}</p>
              </v-col>
              <v-col cols="12">
                <p><strong>Weight: </strong>{{ asset.weight }}</p>
              </v-col>
            </v-row>
  
            <!-- Jewelry -->
            <v-row v-if="asset.category_id === 5">
              <v-col cols="12">
                <p><strong>Weight: </strong>{{ asset.weight }}</p>
              </v-col>
            </v-row>


            <AssetNotes :assetProp="assetProp"/>
  
            </div>

            <div class="d-flex justify-center gap-20 px-8">
              <v-btn @click="goBack"  variant="outlined" color="secondary">Close</v-btn>
              <v-btn @click="editAsset" variant="outlined" color="success">Edit</v-btn>
              <v-btn @click="triggerDelete" variant="outlined" color="error">Delete</v-btn>
            </div>
          </v-card>

        </div>
    </div>
  </template>
  
  <script>
import methods from '@/components/methods';
import store from '@/store';
import AssetNotes from './AssetNotes.vue';

  export default {
    props: {
        assetProp: {},
        closeDialog: {
          type: Function,
          required: true,
        }
    },

    components: {
      AssetNotes,
    },

    data() {
      return {
        open: true,
        customWidth: 700,
        asset: this.assetProp,
        notes: [],
        
        categories: [
          { id: 1, name: 'Land/Flat' },
          { id: 2, name: 'Electronic Device' },
          { id: 3, name: 'Furniture' },
          { id: 4, name: 'Vehicle' },
          { id: 5, name: 'Jewelry' }
        ]
      };
    },

    mounted() {
      this.fetchNotes();
    },

    methods: {
      getCategoryName(id) {
        const category = this.categories.find(c => c.id === id);
        return category ? category.name : 'Unknown';
      },
      goBack() {
        this.closeDialog();
      },

      editAsset() {        
        this.goBack();
        store.commit('SET_DRAWER_ASSET_ID', this.assetProp.id);
        store.commit('openDrawer');
      },

      triggerDelete() {
        methods.deleteAsset(this.assetProp.id);
        this.open = false;
      },

      async fetchNotes() {
        try {
          await store.dispatch('fetchNotes', { type: this.assetProp.id });
          this.notes = store.getters.getNotes(this.assetProp.id);
        } catch (error) {
          console.error("Fetching notes failed", error);
        }
      },

    }
  };
  </script>
  
  <style scoped>
    .scrollable-content {
      max-height: 400px; 
      overflow-y: auto;  
      overflow-x: hidden; 
    }
  </style>
  
