<script>
import { RouterView } from "vue-router";
import { ref, onMounted } from "vue";
import SidebarVue from "./sidebar/Sidebar.vue";
import HeaderVue from "./header/Header.vue";
import AssetDrawer from "@/components/drawer/AssetDrawer.vue";
import EventDrawer from "@/components/drawer/EventDrawer.vue";

export default {
  components: {
    SidebarVue,
    HeaderVue,
    AssetDrawer,
    EventDrawer,
  },
  data() {
    return {
      drawer: true, // Initialize the drawer state
    };
  },
  mounted() {
    const innerW = window.innerWidth;

    if (innerW < 950) {
      this.drawer = !this.drawer; // Toggle drawer state if window width is less than 950
    }
  },
};
</script>

<template>
  <v-app>
    <!-- ---------------------------------------------- -->
    <!---Sidebar -->
    <!-- ---------------------------------------------- -->
    <v-navigation-drawer
      left
      :permanent="$vuetify.display.mdAndUp"
      elevation="10"
      app
      :temporary="$vuetify.display.mdAndDown"
      v-model="drawer"
      expand-on-hover
    >
      <SidebarVue />
    </v-navigation-drawer>

    
    <AssetDrawer/>
    <EventDrawer/>

    <!-- ---------------------------------------------- -->
    <!---Header -->
    <!-- ---------------------------------------------- -->
    <v-app-bar elevation="0" class="v-topbar">
      <v-app-bar-nav-icon class="hidden-md-and-up" @click="drawer = !drawer" />
      <v-spacer />
      <!-- ---------------------------------------------- -->
      <!-- User Profile -->
      <!-- ---------------------------------------------- -->
      <HeaderVue />
    </v-app-bar>

    <!-- ---------------------------------------------- -->
    <!---Page Wrapper -->
    <!-- ---------------------------------------------- -->
    <v-main>
      <v-container fluid class="page-wrapper">
        <RouterView />
      </v-container>
    </v-main>
  </v-app>
</template>
