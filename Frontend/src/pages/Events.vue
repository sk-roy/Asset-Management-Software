<script>
import EventCard from "@/components/cards/EventCard.vue";
import store from "@/store";
import { format } from 'date-fns';

export default {
    data() {
        return {
          events: {},
        }
    },

    components() {
      EventCard
    },
      
    mounted() {
      this.fetchEvents()
    },

    methods: {  
      async fetchEvents() {
        try {
          await store.dispatch('fetchEvents');
          this.events = store.getters.getEvents;
        } catch (error) {
          console.error("Fetching events failed", error);
        }
      },
      
        formatDate(date) {
            return format(date, 'MMMM dd, yyyy, hh:mm a');
        }
    },
}
</script>

<template>
  <div>
    <v-card flat class="w-100 h-100 hidden-sm-and-down">
      <v-card-text>
        <div class="d-sm-flex align-center">
          <div>
            <h2 class="title text-h6 font-weight-medium">Event List</h2>
          </div>
        </div>
        <v-table class="month-table mt-7">
          <template v-slot:default>
            <thead>
              <tr>
                <th class="font-weight-medium text-subtitle-1">Id</th>
                <th class="font-weight-medium text-subtitle-1">Title</th>
                <th class="font-weight-medium text-subtitle-1">Date & Time</th>
                <th class="font-weight-medium text-subtitle-1">Charge</th>
                <th class="font-weight-medium text-subtitle-1">Asset ID</th>
                <th class="font-weight-medium text-subtitle-1">Mode</th>
              </tr>
            </thead>
            <tbody>
              <tr
                v-for="event in events"
                :key="event.id"
                :class="event.title"
                class="month-event"
              >
                <td>{{ event.id }}</td>
                <td>{{ event.title }}</td>
                <td>{{ formatDate(event.datetime) }}</td>
                <td>{{ event.charge }} BDT</td>
                <td>{{ event.asset_id }}</td>
                <td>
                  <h5
                    class="
                      font-weight-medium
                      text-no-wrap text-body-2 text-grey-darken-1
                    "
                  >
                    {{ event.active_mode }}
                  </h5>
                </td>
              </tr>
            </tbody>
          </template>
        </v-table>
      </v-card-text>
    </v-card>
    
    <v-col class="hidden-md-and-up">
      <v-row cols="12" v-for="event in events" :key="event.id">
        <EventCard :event="event"/>
      </v-row>
    </v-col>
  </div>
</template>
