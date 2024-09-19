<template>
  <v-card
    class="mx-4 mt-4 mx-auto pa-4"
    max-width="280"
    hover
  >
    <v-card-item>
      <v-card-title>
        {{ category.title }}
      </v-card-title>
      <v-card-subtitle>
        Name: {{ category.name }}
      </v-card-subtitle>
      <v-card-subtitle>
        Type: {{ category.type }}
      </v-card-subtitle>
    </v-card-item>
    <v-card-text>
      {{ category.description }}
    </v-card-text>
  </v-card>
</template>

<script>

export default {
  props: {
    category: {},
  },
}
</script>