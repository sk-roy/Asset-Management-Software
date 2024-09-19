<script>
import CategoryCard from "@/components/cards/CategoryCard.vue";
import store from "@/store";

export default {
    data() {
        return {
          categories: [],
        }
    },

    components() {
      CategoryCard
    },
      
    mounted() {
      this.fetchCategories()
    },

    methods: {  
      async fetchCategories() {
        try {
          await store.dispatch('fetchCategories');
          this.categories = store.getters.getCategories;
        } catch (error) {
          console.error("Fetching categories failed", error);
        }
      },
    }
}
</script>

<template>
  <div>
    <v-card flat class="w-100 h-100 hidden-sm-and-down">
      <v-card-text>
        <div class="d-sm-flex align-center">
          <div>
            <h2 class="title text-h6 font-weight-medium">Category List</h2>
          </div>
        </div>
        <v-table class="month-table mt-7">
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
    
    <v-col class="hidden-md-and-up">
      <v-row cols="12" v-for="category in categories" :key="category.id">
        <CategoryCard :category="category"/>
      </v-row>
    </v-col>
  </div>
</template>
