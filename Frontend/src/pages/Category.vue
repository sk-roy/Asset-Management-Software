<script>
import CategoryCard from "@/components/cards/CategoryCard.vue";
import store from "@/store";
import CategoryDrawer from "@/components/drawer/CategoryDrawer.vue";

export default {
    data() {
        return {
          categories: [],
          openDrawer: false,
          customWidth: 500, 
        }
    },

    components() {
      CategoryCard,
      CategoryDrawer
    },
      
    mounted() {
      this.fetchCategories()
    },

    methods: {  
      async fetchCategories() {
        try {
          await store.dispatch('fetchCategories', { type: 'all' });
          this.categories = store.getters.getCategories('all');
        } catch (error) {
          console.error("Fetching categories failed", error);
        }
      },

      clickCreateCategory() {
        this.openDrawer = true;
      }
    }
}
</script>


<style scoped>
.close-btn {
  position: absolute;
  top: 10px;
  right: 10px;
}
</style>

<template>
  <div>
    <v-card flat class="w-100 h-100">
      <v-card-text>
        <div class="d-flex align-center">
          <div>
            <h2 class="title text-h6 font-weight-medium">Category</h2>
          </div>
          <v-spacer></v-spacer>
          <div>
              <v-btn variant="outlined" color="secondary" @click="clickCreateCategory">
                  Add new Category
              </v-btn>
          </div>
        </div>
        <v-table class="month-table mt-7 hidden-sm-and-down">
          <template v-slot:default>
            <thead>
              <tr>
                <th class="font-weight-medium text-subtitle-1">Id</th>
                <th class="font-weight-medium text-subtitle-1">Name</th>
                <th class="font-weight-medium text-subtitle-1">Title</th>
                <th class="font-weight-medium text-subtitle-1">Type</th>
              </tr>
            </thead>
            <tbody>
              <tr
                v-for="category in categories"
                :key="category.id"
                :class="category.title"
                class="month-category"
              >
                <td>{{ category.id }}</td>
                <td>{{ category.name }}</td>
                <td>{{ category.title }}</td>
                <td>
                  <h5
                    class="
                      font-weight-medium
                      text-no-wrap text-body-2 text-grey-darken-1
                    "
                  >
                    {{ category.type }}
                  </h5>
                </td>
              </tr>
            </tbody>
          </template>
        </v-table>
      </v-card-text>
    </v-card>
    
    <CategoryDrawer :isOpen="openDrawer" @update:isOpen="openDrawer = $event" />
    
    <v-col class="hidden-md-and-up">
      <v-row cols="12" v-for="category in categories" :key="category.id">
        <CategoryCard :category="category"/>
      </v-row>
    </v-col>
  </div>
</template>
