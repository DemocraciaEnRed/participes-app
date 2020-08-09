<script>
import { Bar } from "vue-chartjs";

export default {
  extends: Bar,
  props: ["chartData"],
  data() {
    return {
      options: {
        responsive: true,
        maintainAspectRatio: false,
        legend: {
          display: false
        },
        scales: {
          yAxes: [{
            display: false,
            ticks: { beginAtZero: true }
          }],
          xAxes: [{
            display: false,
          }]
        }
      }
    };
  },
  mounted: function() {
    // Overwriting base render method with actual data.
    this.renderChart({
      labels: this.labels,
      datasets: this.datasets
    },
    this.options);
  },
  computed: {
    datasets: function() {
      return [
        {
          label: 'Reportes',
          backgroundColor: '#2c59fb',
          data: this.chartData.map( data => data.count )
        }
      ]
    },
    labels: function() {
      return this.chartData.map( data => {
        return data.date.split('T')[0]
      })
    }
  }
};
</script>
