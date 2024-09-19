<template>
    <div>  
      <v-navigation-drawer
        v-model="open"
        location="left"
        temporary
        :width="customWidth"
        app
      >
        <div>
            <v-btn variant="outlined" color="secondary" @click="closeDrawer">
                <v-icon>mdi-close</v-icon>
            </v-btn>
        </div>

        <v-list>
          <v-list-item>
            <v-list-item-content>
              <v-list-item-title>Drawer Content</v-list-item-title>
            </v-list-item-content>
          </v-list-item>
        </v-list>
      </v-navigation-drawer>
    </div>
  </template>
  
  <script>
  export default {
    props: {
        isOpen: {
            type: Boolean,
            required: false,
            default: false,
        },
    },

    data() {
      return {
        customWidth: 500,
        open: this.isOpen,
      }
    },

    watch: {
        isOpen(newVal) {
            this.open = newVal;
        },
    },

    methods: {
        closeDrawer() {
            console.log('clicked closeDrawer');
            this.open = false;
            this.$emit('update:isOpen', false);
        },
    },
  }
  </script>
  
  <style scoped>
  .close-btn {
    position: absolute;
    top: 10px;
    right: 10px;
  }
  </style>
  