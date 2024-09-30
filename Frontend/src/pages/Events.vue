<script>
import EventCard from "@/components/cards/EventCard.vue";
import store from "@/store";
import { format } from 'date-fns';

export default {
    data() {
        return {
          events: {},
          selectedOption: "All",
          options: ["All", "Live", "Dead"], 
        }
    },

    components() {
      EventCard
    },
      
    mounted() {
      this.fetchEvents()
    },

    watch: {
      selectedOption() {
        this.filterEvents();
      }
    },

    methods: {  
      async fetchEvents() {
        try {
          await store.dispatch('fetchEvents', {type: 'All'});
          this.events = store.getters.getEvents('All');
          console.log('events fetchEvents', this.events);
        } catch (error) {
          console.error("Fetching events failed", error);
        }
      },
      
      async filterEvents() {
        try {
          await store.dispatch('fetchEvents', {type: this.selectedOption});
          this.events = store.getters.getEvents(this.selectedOption);
          console.log('events filterEvents', this.events);
        } catch (error) {
          console.error("Fetching events failed", error);
        }
      },
      

      clickCreateEvent() {        
          store.commit('SET_DRAWER_EVENT_ID', null);
          store.commit('openEventDrawer');
      },
      
        formatDate(date) {
            return format(date, 'MMMM dd, yyyy, hh:mm a');
        }
    },
}
</script>

<template>
  <div>
    <v-card flat class="w-100 h-100 mb-4">
      <v-card-text>
        <v-container fluid>
          <v-row align="center">
            <v-col cols="12" md="6">
              <h2 class="title text-h6 font-weight-medium">Events</h2>
            </v-col>
            <v-col cols="12" md="6">
              <div class="d-flex justify-space-between gap-10" style="height: 10px;">
                <v-select
                  v-model="selectedOption"
                  :items="options"
                  variant="outlined"
                  color="secondary"
                  density="compact"
                  persistent-hint
                  single-line
                  @change="filterEvents"
                ></v-select>
                <v-btn variant="outlined" color="secondary" @click="clickCreateEvent">
                  Add new Event
                </v-btn>
              </div>
            </v-col>
          </v-row>
        </v-container>

        <v-table class="month-table mt-7 hidden-sm-and-down">
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
