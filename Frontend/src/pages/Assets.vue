<template>
    <div>
    <v-card flat class="w-100 h-100 mb-4">
        <v-card-text>
            <div class="d-flex align-center">
                <div>
                    <h2 class="title text-h6 font-weight-medium"> Assets </h2>
                </div>
                <v-spacer></v-spacer>
                <div>
                    <v-btn variant="outlined" color="secondary" @click="clickCreateAsset">
                        Add new Asset
                    </v-btn>
                </div>
            </div>

            <v-data-table
                class="mt-4 hidden-sm-and-down"
                v-model="selected"
                :headers="headers"
                :items="assets"
                item-value="id"
                show-select
            ></v-data-table>

        </v-card-text>
    </v-card>
    
    <CreateAssetDrawer :isOpen="openDrawer" @update:isOpen="openDrawer = $event" />

  
    <v-row class="hidden-md-and-up">
        <v-col cols="12" v-for="asset in assets" :key="asset.id">
            <AssetCard :asset="asset"/>
        </v-col>
    </v-row>
    </div>
</template>


<script>
import store from '@/store';
import AssetCard from '@/components/cards/AssetCard.vue';
import CreateAssetDrawer from '@/components/drawer/CreateAssetDrawer.vue';

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
      openDrawer: false,
    }
  },

  components: {
    AssetCard,
    CreateAssetDrawer,
  },
  
  mounted() {
      this.fetchAssets()
  },

  methods: {
      async fetchAssets() {
          await store.dispatch('fetchAssets');
          this.assets = store.getters.getAssets;
      },

        clickCreateAsset() {
            this.openDrawer = true;
        }
  }
}
</script>
