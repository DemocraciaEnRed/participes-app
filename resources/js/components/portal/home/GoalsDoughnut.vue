<script>
import { Doughnut } from "vue-chartjs";
export default {
  extends: Doughnut,
  props: ["chartData"],
  data(){
    return {
      options: {
        responsive: true,
        tooltips: {
          enabled: false
        },
        legend: {
          display: false
        },
        maintainAspectRatio: false,
      }
    }
  },
  mounted: function() {
    // Overwriting base render method with actual data.
    this.renderChart({
      labels: this.chartData.labels,
      datasets: [{
        data: this.chartData.data,
        backgroundColor: this.chartData.labelsColors
      }]
    },
    this.options);
  },
  computed: {
    
  }
}
</script>