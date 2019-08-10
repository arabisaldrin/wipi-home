<script>
import { Pie } from "vue-chartjs";

export default {
  extends: Pie,
  props: {
    chartData: {
      default: () => ({
        labels: ["Red", "Conencted", "Invalid"],
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
  methods: {
    createGradient(r, g, b) {
      const gradient = this.$refs.canvas
        .getContext("2d")
        .createLinearGradient(0, 0, 0, 450);

      [[0, 0.5], [0.5, 0.25], [1, 0]].forEach(e => {
        gradient.addColorStop(e[0], `rgba(${r}, ${g},${b}, ${e[1]})`);
      });

      return gradient;
    }
  },
  mounted() {
    const gradient = this.createGradient(255, 0, 0);
    const gradient2 = this.createGradient(0, 231, 255);
    const gradient3 = this.createGradient(33, 150, 243);

    this.chartData.datasets[0].backgroundColor.splice(0, 0, gradient);
    this.chartData.datasets[0].backgroundColor.splice(1, 0, gradient2);
    this.chartData.datasets[0].backgroundColor.splice(1, 0, gradient3);

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
