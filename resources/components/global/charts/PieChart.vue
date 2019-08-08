<script>
import { Pie } from "vue-chartjs";

export default {
  extends: Pie,
  props: {
    chartData: {
      default: () => ({
        labels: ["Request", "Conencted", "Invalid"],
        datasets: [
          {
            data: [40, 39, 10],
            backgroundColor: ["#2196f3", "#4caf50", "#4caf50"]
          }
        ]
      })
    },
    chartOption: {
      default: () => ({
        responsive: true,
        maintainAspectRatio: false,
        legend: {
          position: "right"
        }
      })
    }
  },
  mounted() {
    const gradient = this.$refs.canvas
      .getContext("2d")
      .createLinearGradient(0, 0, 0, 450);

    gradient.addColorStop(0, "rgba(255, 0,0, 0.5)");
    gradient.addColorStop(0.5, "rgba(255, 0, 0, 0.25)");
    gradient.addColorStop(1, "rgba(255, 0, 0, 0)");

    this.chartData.datasets[0].backgroundColor.splice(0, 0, gradient);

    this.renderChart(this.chartData, this.chartOption);
  }
};
</script>

<style>
.Chart {
  background: #212733;
  border-radius: 15px;
  box-shadow: 0px 2px 15px rgba(25, 25, 25, 0.27);
  margin: 25px 0;
}

.Chart h2 {
  margin-top: 0;
  padding: 15px 0;
  color: rgba(255, 0, 0, 0.5);
  border-bottom: 1px solid #323d54;
}
</style>
