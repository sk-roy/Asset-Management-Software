<template>
    <div>
        <v-card flat class="w-100 h-100 mb-4">
            <v-card-text>
                <div class="d-flex align-center">
                    <div>
                        <h2 class="title text-h6 font-weight-medium"> Assets </h2>
                    </div>
                    <v-spacer></v-spacer>
                    <div class="gap-10">
                        <v-btn 
                        variant="outlined" 
                        color="secondary" 
                        @click="clickEditAsset" 
                        class="hidden-sm-and-down"
                        v-if="selected.length == 1">
                            Edit
                        </v-btn>
                        <v-btn 
                        variant="outlined" 
                        color="error" 
                        @click="deleteAssetList" 
                        class="hidden-sm-and-down"
                        v-if="selected.length >= 1">
                            Delete
                        </v-btn>
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
                >
                    <template v-slot:item="{ item }">
                        <tr :data-item-id="item.id" style="cursor: pointer;">
                            <td>
                                <v-checkbox
                                class="checkbox-column"
                                density="compact"
                                v-model="selected"
                                :value="item.id"
                                hide-details
                                dense
                                ></v-checkbox>
                            </td>
                            <td @click="openAssetDialog(item)">{{ item.title }}</td>
                            <td style="text-align: right;" @click="openAssetDialog(item)">{{ item.address }}</td>
                            <td style="text-align: right;" @click="openAssetDialog(item)">{{ item.brand }}</td>
                            <td style="text-align: right;" @click="openAssetDialog(item)">{{ item.model }}</td>
                            <td style="text-align: right;" @click="openAssetDialog(item)">{{ item.purchase_price }}</td>
                            <td style="text-align: right;" @click="openAssetDialog(item)">{{ item.purchase_date }}</td>
                        </tr>
                    </template>
                </v-data-table>

                <!-- Asset Detail Dialog -->
                <v-dialog v-model="dialog" max-width="700">
                    <AssetDetails :assetProp="selectedAsset" :closeDialog="closeDialog"/>
                </v-dialog>
            </v-card-text>
        </v-card>
        
    
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
import AssetDetails from './Assets/AssetDetails.vue';
import methods from '@/components/methods';
import { mapActions } from 'vuex';

export default {
  data () {
    return {
        assetId: null,

        headers: [
            { title: 'Title', align: 'start', sortable: false, key: 'title' },
            { title: 'Address', align: 'end', sortable: false, key: 'address' },
            { title: 'Brand', align: 'end', sortable: true, key: 'brand' },
            { title: 'Model', align: 'end', sortable: true, key: 'model' },
            { title: 'Purchasing Price', align: 'end', sortable: true, key: 'purchase_price' },
            { title: 'Purchasing Date', align: 'end', sortable: true, key: 'purchase_date' },
        ],
        assets: [],
        selected: [],
        
        dialog: false,
        selectedAsset: null, 
    }
  },

  components: {
    AssetCard,
    AssetDetails,
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
        store.commit('SET_DRAWER_ASSET_ID', null);
        store.commit('openDrawer');
    },

    async openAssetDialog(item) {
        await store.dispatch('fetchAssetDetails', { id: item.id });
        this.selectedAsset = store.getters.getAssetDetails(item.id);
        this.dialog = true;
    },

    closeDialog() {
        this.dialog = false;
    }, 

    clickEditAsset() {
        if (this.selected.length === 1) {            
            store.commit('SET_DRAWER_ASSET_ID', this.selected[0]);
            store.commit('openDrawer');
        }
    },

    async deleteAssetList() {        
        methods.deleteAssetList(this.selected);
    },
  }
}
</script>


<style scoped>

.checkbox-column {
  text-align: left;
  transform: scale(.9);
}

</style>
