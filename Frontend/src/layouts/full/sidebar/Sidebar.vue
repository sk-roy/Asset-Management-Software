<script>
import { ref } from "vue";
import sidebarItems from "./sidebarItem";

export default {
  data () {
    return {
      sidebarMenu: ref(sidebarItems),
    }
  },
  
}
</script>


<template>
  <div>
    <!-- ---------------------------------------------- -->
    <!---Logo part -->
    <!-- ---------------------------------------------- -->
    <div>
      <RouterLink to="/">        
        <v-img
          class="mx-auto"
          max-width="100"
          src="https://img.freepik.com/free-vector/colorful-letter-gradient-logo-design_474888-2309.jpg?w=740&t=st=1726240262~exp=1726240862~hmac=a4c9e4d3c4eefc2a210a01ecec64619e56a4dea387fa00ce7c9ca79b4b02343e"     
        ></v-img>
      </RouterLink>
    </div>
    <!-- ---------------------------------------------- -->
    <!---Navigation -->
    <!-- ---------------------------------------------- -->
    <div class="scrollnavbar">
      <v-list  class="pa-4" color="transparent">
        <!-- ---------------------------------------------- -->
        <!---Menu Loop -->
        <!-- ---------------------------------------------- -->
        <template v-for="(item, i) in sidebarMenu" :key="i">
          <!-- ---------------------------------------------- -->
          <!---Single Item-->
          <!-- ---------------------------------------------- -->
          <v-list-item  :to="item.to" rounded="lg" class="mb-1">            
            <template v-slot:prepend >
              <v-icon :icon="item.icon" class="feather-sm v-icon v-icon--size-default"></v-icon>
            </template>

            <v-list-item-title v-text="item.title"></v-list-item-title>
          </v-list-item>
        </template>
      </v-list>
    </div>
  </div>
</template>