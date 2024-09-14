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
                <v-list-item
                v-for="(item, index) in items"
                :key="index"
                :value="index"
                >
                <v-list-item-title>{{ item.title }}</v-list-item-title>
                </v-list-item>
            </v-list>
        </v-menu>
      </v-app-bar>
  
      <v-navigation-drawer>
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
        <v-list>
          <v-list-item title="Drawer right"></v-list-item>
          <v-list-item title="Drawer right"></v-list-item>
          <v-list-item title="Drawer right"></v-list-item>
          <v-list-item title="Drawer right"></v-list-item>
          <v-list-item title="Drawer right"></v-list-item>
          <v-list-item title="Drawer right"></v-list-item>
          <v-list-item title="Drawer right"></v-list-item>
          <v-list-item title="Drawer right"></v-list-item>
          <v-list-item title="Drawer right"></v-list-item>
          <v-list-item title="Drawer right"></v-list-item>
          <v-list-item title="Drawer right"></v-list-item>
          <v-list-item title="Drawer right"></v-list-item>
          <v-list-item title="Drawer right"></v-list-item>
          <v-list-item title="Drawer right"></v-list-item>
          <v-list-item title="Drawer right"></v-list-item>
        </v-list>
      </v-navigation-drawer>
  
      <v-main class="d-flex align-center justify-center" style="min-height: 300px;">
        <router-view></router-view> <!-- Dynamic content will be injected here -->
      </v-main>
    </v-layout>
</template>

<script>
    import pkg from '../../package.json';

    export default {
        data: () => ({
            items: [
                { title: 'Profile' },
                { title: 'Settings' },
                { title: 'Logout' },
            ],
            user: {
                initials: 'JD',
                fullName: 'John Doe',
                email: 'john.doe@doe.com',
            },
            title: pkg.title || 'Asset Management System'
        }),
    }
</script>