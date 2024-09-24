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
              <v-list-item-title>New Asset</v-list-item-title>
            </v-list-item>
          </v-list>
            
          <v-card
            class="mx-auto pa-12 pb-8"
            elevation="8"
            max-width="650"
            rounded="lg"
          >
              <v-text-field
                v-model="model.title"
                density="compact"
                label="Title"
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

              <!-- Conditional Fields Based on Category -->
              <!-- Land or Flat -->
              <v-row v-if="model.category_id === 1">
                <v-col cols="12" md="6">
                  <v-text-field v-model="model.address" label="Address" variant="outlined" density="compact"></v-text-field>
                </v-col>
                <v-col cols="12" md="6">
                  <v-text-field v-model="model.flat_number" label="Flat Number" variant="outlined" density="compact"></v-text-field>
                </v-col>
                <v-col cols="12" md="6">
                  <v-text-field v-model="model.floor_number" label="Floor Number" variant="outlined" density="compact"></v-text-field>
                </v-col>
                <v-col cols="12" md="6">
                  <v-text-field v-model="model.area" label="Area" variant="outlined" density="compact"></v-text-field>
                </v-col>
                <v-col cols="12" md="6">
                  <v-text-field v-model="model.purchase_price" label="Purchase Price" variant="outlined" density="compact"></v-text-field>
                </v-col>
                <v-col cols="12" md="6">
                  <v-text-field v-model="model.purchase_date" label="Purchase Date" type="date" variant="outlined" density="compact"></v-text-field>
                </v-col>
                <v-col cols="12">
                  <v-text-field v-model="model.diagram_path" label="Diagram Path" variant="outlined" density="compact"></v-text-field>
                </v-col>
                <v-col cols="12" md="6">
                  <v-text-field v-model="model.latitude" label="Latitude" variant="outlined" density="compact"></v-text-field>
                </v-col>
                <v-col cols="12" md="6">
                  <v-text-field v-model="model.longitude" label="Longitude" variant="outlined" density="compact"></v-text-field>
                </v-col>
              </v-row>

              <!-- Electronic Device -->
              <v-row v-if="model.category_id === 2">
                <v-col cols="12" md="6">
                  <v-text-field v-model="model.brand" label="Brand" variant="outlined" density="compact"></v-text-field>
                </v-col>
                <v-col cols="12" md="6">
                  <v-text-field v-model="model.model" label="Model" variant="outlined" density="compact"></v-text-field>
                </v-col>
                <v-col cols="12" md="6">
                  <v-text-field v-model="model.capacity" label="Capacity" variant="outlined" density="compact"></v-text-field>
                </v-col>
                <v-col cols="12">
                  <v-text-field v-model="model.specification" label="Specification" variant="outlined" density="compact"></v-text-field>
                </v-col>
              </v-row>

              <!-- Furniture -->
              <v-row v-if="model.category_id === 3">
                <v-col cols="12">
                  <v-text-field v-model="model.weight" label="Weight" variant="outlined" density="compact"></v-text-field>
                </v-col>
              </v-row>

              <!-- Vehicle -->
              <v-row v-if="model.category_id === 4">
                <v-col cols="12" md="6">
                  <v-text-field v-model="model.plate_number" label="Plate Number" variant="outlined" density="compact"></v-text-field>
                </v-col>
                <v-col cols="12" md="6">
                  <v-text-field v-model="model.brand" label="Brand" variant="outlined" density="compact"></v-text-field>
                </v-col>
                <v-col cols="12" md="6">
                  <v-text-field v-model="model.model" label="Model" variant="outlined" density="compact"></v-text-field>
                </v-col>
                <v-col cols="12">
                  <v-text-field v-model="model.weight" label="Weight" variant="outlined" density="compact"></v-text-field>
                </v-col>
              </v-row>

              <!-- Jewelry -->
              <v-row v-if="model.category_id === 5">
                <v-col cols="12">
                  <v-text-field v-model="model.weight" label="Weight" variant="outlined" density="compact"></v-text-field>
                </v-col>
              </v-row>

<!--               
              <v-row class="d-flex justify-center">
                <v-btn @click="submitForm">Submit</v-btn>
              </v-row> -->

              <div class="d-flex justify-center gap-20 px-8">
                <v-btn @click="closeDrawer">Cancel</v-btn>
                <v-btn @click="editAsset" v-if="assetId != null">Edit</v-btn>
                <v-btn @click="submitForm" v-if="assetId == null">Submit</v-btn>
              </div>


          </v-card>

        </div>
      </v-navigation-drawer>
    </div>
</template>
  
<script>
import apiClient from '@/plugins/axios';
import store from '@/store';


  export default {
    props: {
      assetId: {
        type: Number,
      },
    },

    data() {
      return {
        customWidth: 700,
        open: false,
        
        model: {
          title: "",
          description: "",
          category_id: 1,
          address: "",
          flat_number: "",
          floor_number: "",
          area: "",
          purchase_price: "",
          purchase_date: "",
          diagram_path: "",
          latitude: "",
          longitude: "",
          brand: "",
          model: "",
          capacity: "",
          specification: "",
          plate_number: "",
          weight: "",
        },

        categories: [],
      }
    },
    
    mounted() {
      this.fetchCategories();
    },
   
    watch: {
      assetId: 'fetchAsset',
      drawer: {
        handler(newValue) {
          if (newValue) {
            this.fetchAsset();
          }
        },
      },
    },

    methods: {
      closeDrawer() {
        this.open = false;
      },

      openDrawer() {
        this.open = true;
      },

      handleReset() {
      },

      async fetchCategories() {
        console.log(this.assetId);
        try {
          await store.dispatch('fetchCategories', { type: "asset" });
          this.categories = store.getters.getCategories('asset');
        } catch (error) {
          console.error("Fetching categories failed", error);
        }
      },

      async submitForm() {
        console.log('category', this.model);
          
        try {
          await apiClient.post("/assets", this.model);
          window.location.reload();
        } catch (error) {
          console.error("Failed to create new asset:", error);
          alert("Failed to create new asset.");
        }
      },

      onCategoryChange(value) {
        this.model.category_id = value;
      },

      fetchAsset() {
        if (this.assetId != null) {
          this.model = store.getters.getAsset(this.assetId);
        } else {
          this.resetModel();
        }
      },

      editAsset() {        
        console.log('editAsset');
      },

      resetModel() {
        this.model = {
          title: "",
          description: "",
          category_id: 1,
          address: "",
          flat_number: "",
          floor_number: "",
          area: "",
          purchase_price: "",
          purchase_date: "",
          diagram_path: "",
          latitude: "",
          longitude: "",
          brand: "",
          model: "",
          capacity: "",
          specification: "",
          plate_number: "",
          weight: "",
        };
      },
    },
  }
</script>
  
  