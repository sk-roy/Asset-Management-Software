<template>
  <v-card
    class="mx-4 mt-4 mx-auto pa-4"
    max-width="280"
    hover
  >
    <v-card-item>
      <v-card-title>
        {{ event.title }}
      </v-card-title>

      <v-card-subtitle>
        {{ formatDate(event.datetime) }}
      </v-card-subtitle>
    </v-card-item>

    <v-card-text>
      {{ event.description }}
    </v-card-text>

    <v-card-actions>
      <v-btn
        text="Details"
      ></v-btn>
    </v-card-actions>
  </v-card>
</template>

<script>
import { format } from 'date-fns';

export default {
  props: {
    event: {},
  },

  methods: {
    formatDate(date) {
      return format(date, 'MMMM dd, yyyy, hh:mm a');
    }
  },
}
</script>