<template>
    <v-layout class="rounded rounded-md">

      <v-app-bar
        color="teal-darken-4"
      >
        <template v-slot:image>
          <v-img
            gradient="to top right, rgba(19,84,122,.8), rgba(128,208,199,.8)"
          ></v-img>
        </template>

        <template v-slot:prepend>
            <v-app-bar-nav-icon>            
                <v-btn icon>
                <v-icon>mdi-home-floor-a</v-icon>
                </v-btn>
            </v-app-bar-nav-icon>
        </template>
        <v-app-bar-title>{{ title }}</v-app-bar-title>

        <v-spacer></v-spacer>

        <v-btn icon>
          <v-icon>mdi-magnify</v-icon>
        </v-btn>

        <v-btn>
            Assets
        </v-btn>

        <v-btn>
            Events
        </v-btn>

        <v-btn>
            News
        </v-btn>
        
        <v-menu>
            <template v-slot:activator="{ props }">
                <v-btn
                v-bind="props"
                >
                    Profile
                </v-btn>
            </template>
            <v-list>
                <v-list-item @click='profile' >
                  <v-list-item-title> Profile </v-list-item-title>
                </v-list-item>
                <v-list-item @click='settings' >
                  <v-list-item-title> Settings </v-list-item-title>
                </v-list-item>
                <v-list-item @click='logout' >
                  <v-list-item-title> Logout </v-list-item-title>
                </v-list-item>
            </v-list>
        </v-menu>
      </v-app-bar>
  
      <v-navigation-drawer  >
        <v-list>
          <v-list-item title="Drawer left"></v-list-item>
          <v-list-item title="Drawer left"></v-list-item>
          <v-list-item title="Drawer left"></v-list-item>
          <v-list-item title="Drawer left"></v-list-item>
          <v-list-item title="Drawer left"></v-list-item>
          <v-list-item title="Drawer left"></v-list-item>
          <v-list-item title="Drawer left"></v-list-item>
          <v-list-item title="Drawer left"></v-list-item>
          <v-list-item title="Drawer left"></v-list-item>
          <v-list-item title="Drawer left"></v-list-item>
          <v-list-item title="Drawer left"></v-list-item>
          <v-list-item title="Drawer left"></v-list-item>
          <v-list-item title="Drawer left"></v-list-item>
          <v-list-item title="Drawer left"></v-list-item>
          <v-list-item title="Drawer left"></v-list-item>
          <v-list-item title="Drawer left"></v-list-item>
          <v-list-item title="Drawer left"></v-list-item>
        </v-list>
      </v-navigation-drawer>
  
      <v-navigation-drawer location="right">
        <v-col>
          <v-row v-for="asset in events" :key="asset.id">
            <EventCard :event="asset"/>
          </v-row>
        </v-col>
      </v-navigation-drawer>
  
      <v-main class="d-flex align-center justify-center" style="min-height: 300px;">
        <router-view></router-view> <!-- Dynamic content will be injected here -->
      </v-main>
    </v-layout>
</template>

<script>
    import store from '@/store';
    import pkg from '../../package.json';
    import Cookies from 'js-cookie';
    import EventCard from '@/components/cards/EventCard.vue';

    export default {
          
      data() {
        return {
            user: {
                initials: 'JD',
                fullName: 'John Doe',
                email: 'john.doe@doe.com',
            },
            title: pkg.title || 'Asset Management System',
            events: [],
        };
      },   
      
      mounted() {
        this.fetchEvents()
      },

      components() {
        EventCard
      },

      methods: {
        profile() {
          console.log('profile');
        },

        settings() {
          console.log('settings');
        },

        async logout() {
          try {
            const response = await store.dispatch('logout');

            console.log('Logout successful:', response.data)

            Cookies.remove('auth_token', { path: '/' })
            
            this.$router.push('login');
          } catch (error) {
            console.error("Logout failed", error);
          }
        },

        async fetchEvents() {
          try {
            await store.dispatch('fetchEvents');
            this.events = store.getters.getEvents;
            console.log('mainlayout fetchEvents', store.getters.getEvents);
            console.log('mainlayout fetchEvents', this.events);
          } catch (error) {
            console.error("Fetching events failed", error);
          }
        },
      },
    }
</script>