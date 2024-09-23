<template>
  <v-card flat class="w-100 h-100">
    <v-card-text>
      <div class="d-sm-flex align-center">
        <h2 class="title text-h6 font-weight-medium"> Assets </h2>
      </div>

      <v-data-table
          v-model="selected"
          :headers="headers"
          :items="assets"
          item-value="id"
          show-select
      ></v-data-table>

  </v-card-text>
</v-card>
</template>


<script>
import store from '@/store';
import AssetCard from '@/components/cards/AssetCard.vue';

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
  AssetCard
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
