import methods from "@/components/methods";

export const eventData = {
  series: [
    {
      name: "Category",
      data: [],
    },
  ],
  chartOptions: {
    grid: {
      show: false,
      borderColor: "transparent",
      padding: { left: 0, right: 0, bottom: 0 },
    },
    plotOptions: {
      bar: { horizontal: false, columnWidth: "42%", borderRadius: 5 },
    },
    colors: ["#fb9778", "#03c9d7"],
    fill: { type: "solid", opacity: 1 },
    chart: {
      type: "bar",
      height: 270,
      offsetX: -15,
      toolbar: { show: false },
      foreColor: "#adb0bb",
      fontFamily: "DM sans",
      sparkline: { enabled: false },
    },
    dataLabels: { enabled: false },
    markers: { size: 0 },
    legend: { show: false },
    xaxis: {
      type: "category",
      categories: [],
    },
    yaxis: {
      show: true,
      min: 0,
      max: 100,
      tickAmount: 3,
    },
    stroke: {
      show: true,
      width: 5,
      lineCap: "butt",
      colors: ["transparent"],
    },
    tooltip: { theme: "dark" },
  },
};

export async function updateEventData() {
  try {
    const eventsNCounts = await methods.getEventCategoryCounts();
    var tempEventData = eventData;

    tempEventData.series[0].data = eventsNCounts.counts;
    tempEventData.chartOptions.xaxis.categories = eventsNCounts.categoryName;
    tempEventData.chartOptions.yaxis.min = Math.max(Math.min(...eventsNCounts.counts) * .8, 0);
    tempEventData.chartOptions.yaxis.max = Math.max(...eventsNCounts.counts) * 1.2;

    return tempEventData;
  } catch (error) {
    methods.handleUnauthorizedError(error, "Error fetching event data");
  }
}