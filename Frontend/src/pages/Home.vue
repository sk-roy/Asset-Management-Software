<template>
    <div class="mt-4 mr-4">
        <v-row class="mb-4" justify="end">
            <v-col cols="auto">
            <v-btn variant="outlined">
                Add new Asset
            </v-btn>
            </v-col>
            <v-col cols="auto">
            <v-btn variant="outlined">
                See All
            </v-btn>
            </v-col>
        </v-row>
  
        <v-row class="hidden-sm-and-down">
            <v-col>
                <div style="max-height: 400px; overflow-x: auto;">
                    <v-data-table
                        v-model="selected"
                        :headers="headers"
                        :items="assets"
                        item-value="id"
                        show-select
                    ></v-data-table>
                </div>
            </v-col>
        </v-row>

      <v-row class="hidden-md-and-up">
      <v-col cols="12" v-for="asset in assets" :key="asset.id">
        <Asset :asset="asset"/>
      </v-col>
    </v-row>
    </div>
    
  </template>
  

<script>
import store from '@/store';
import Asset from '@/components/cards/Asset.vue';

  export default {
    data () {
      return {
        selected: [],
        headers: [
            { title: 'Title', align: 'start', sortable: false, key: 'title' },
            { title: 'Address', align: 'end', sortable: false, key: 'address' },
            { title: 'Brand', align: 'end', sortable: true, key: 'brand' },
            { title: 'Model', align: 'end', sortable: true, key: 'model' },
            { title: 'Purchasing Price', align: 'end', sortable: true, key: 'purchase_price' },
            { title: 'Purchasing Date', align: 'end', sortable: true, key: 'purchase_date' },
        ],
        assets: [],
      }
    },

    components: {
        Asset
    },
    
    mounted() {
        this.fetchAssets()
    },

    methods: {
        async fetchAssets() {
            await store.dispatch('fetchAssets');
            this.assets = store.getters.getAssets;
        }
    }
  }
</script>
