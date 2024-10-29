<template>
    <v-card
      class="mx-auto"
      max-width="344"
    >
      <v-img
        height="200px"
        src="https://cdn.vuetifyjs.com/images/cards/sunshine.jpg"
        cover
      ></v-img>
  
      <v-card-title>
        {{ asset.title }}
      </v-card-title>
  
      <v-card-subtitle>
        {{ asset.model }}
      </v-card-subtitle>
  
      <v-card-actions>
        <v-btn
          color="orange-lighten-2"
          text="Explore"
        ></v-btn>
  
        <v-spacer></v-spacer>
  
        <v-btn
          :icon="show ? 'mdi-chevron-up' : 'mdi-chevron-down'"
          @click="show = !show"
        ></v-btn>
      </v-card-actions>
  
      <v-expand-transition>
        <div v-show="show">
          <v-divider></v-divider>
  
          <v-card-text>            
            {{ asset.description }}
          </v-card-text>
        </div>
      </v-expand-transition>
    </v-card>
  </template>

<script>
export default {
  props: {
    asset: {},
  },
  data: () => ({
    show: false,
  }),
}
</script>