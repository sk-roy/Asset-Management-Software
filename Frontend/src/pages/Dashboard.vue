<template>
  <v-row class="hidden-sm-and-down">
    <v-col cols="12" md="9">
      <v-card flat class="w-100 h-100 hidden-sm-and-down">
        <v-card-text>
          <div class="d-sm-flex align-center">
            <h2 class="title text-h6 font-weight-medium"> Assets </h2>
          </div>
          <v-data-table
            v-model="selected"
            :headers="headers"
            :items="assets"
            item-value="id"
            :items-per-page="10"
            hide-default-footer
          ></v-data-table>
        </v-card-text>
      </v-card>      
      <v-row class="hidden-md-and-up">
          <v-col cols="12" v-for="asset in assets" :key="asset.id">
              <AssetCard :asset="asset"/>
          </v-col>
      </v-row>
    </v-col>
        
    <v-col cols="12" md="3">      
      <v-row cols="12" v-for="event in events.slice(0, 3)" :key="event.id">
        <EventCard :event="event"/>
      </v-row>
    </v-col>
  </v-row>

  <div class="hidden-md-and-up ">
    
  <v-slide-group
      v-model="model"
      class="pa-2"
      center-active
      show-arrows
      style="max-width: 100%; background-color: gray;"

    >
      <v-slide-group-item
        v-for="asset in assets" :key="asset.id"
        class="d-flex"
        style="margin-right: 20px;"
      >
      
        <AssetCard :asset="asset"/>
      </v-slide-group-item>
    </v-slide-group>
  </div>
</template>


<script>
import store from '@/store';
import AssetCard from '@/components/cards/AssetCard.vue';
import EventCard from '@/components/cards/EventCard.vue';
import methods from '@/components/methods';

export default {
data () {
  return {
    selected: [],
    headers: [
        { title: 'Title', align: 'start', sortable: false, key: 'title' },
        { title: 'Address', align: 'end', sortable: false, key: 'address' },
        { title: 'Brand', align: 'end', sortable: true, key: 'brand' },
        { title: 'Model', align: 'end', sortable: true, key: 'model' },
        // { title: 'Purchasing Price', align: 'end', sortable: true, key: 'purchase_price' },
        { title: 'Purchasing Date', align: 'end', sortable: true, key: 'purchase_date' },
    ],
    assets: [],
    events: [],
    model: null,
  }
},

components: {
  AssetCard,
  EventCard
},

mounted() {
    this.fetchAssets();
    this.fetchEvents();
},

methods: {
    async fetchAssets() {
        await store.dispatch('fetchAssets');
        this.assets = store.getters.getAssets;
    },
     
    async fetchEvents() {
      try {
        await store.dispatch('fetchEvents', {type: 'All'});
        this.events = store.getters.getEvents('All');
      } catch (error) {
        methods.handleUnauthorizedError(error, 'Fetching events failed.');
      }
    }
  }
}
</script>
