<script>
import { updateEventData } from './EventChartData';

export default {
  data: () => ({
    chartData: {},
    elementVisible: true,
  }),

  mounted() {
      this.fetchChartData();
  },

  methods: {
    async fetchChartData() {
      this.chartData = await updateEventData();
    }
  }
}
</script>


<template>
  <!-- ------------------------------------ -->
  <!-- html -->
  <!-- ------------------------------------ -->
  <v-card>
    <v-card-text class="pa-7">
      <div class="d-sm-flex align-center mb-5">
        <div>
          <h3 class="text-h6 title font-weight-medium">Events Overview</h3>
        </div>
        <v-spacer></v-spacer>
        <div class="ml-auto">
          <div class="d-flex align-center">
            <div class="d-flex align-center px-2">
              <span class="text-primary">
                <span class="text-overline">
                  <i class="mdi mdi-brightness-1 mx-1"></i>
                </span>
                <span class="font-weight-regular">Category</span>
              </span>
            </div>
          </div>
        </div>
      </div>
      <div v-show="elementVisible">
        <apexchart
          type="bar"
          height="280px"
          :series="chartData.series"
          :options="chartData.chartOptions"
        ></apexchart>
      </div>
    </v-card-text>
  </v-card>
</template>


