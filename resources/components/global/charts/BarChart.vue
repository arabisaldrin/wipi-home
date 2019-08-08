<script>
import { Bar } from "vue-chartjs";

export default {
  extends: Bar,
  props: {
    chartData: {
      default: () => undefined
    },
    chartOption: {
      default: () => ({
        responsive: true,
        maintainAspectRatio: false
      })
    }
  },
  data() {
    return {
      gradient: null,
      gradient2: null
    };
  },
  watch: {
    chartData: {
      deep: true,
      handler: function() {
        this.gradient = this.$refs.canvas
          .getContext("2d")
          .createLinearGradient(0, 0, 0, 450);
        this.gradient2 = this.$refs.canvas
          .getContext("2d")
          .createLinearGradient(0, 0, 0, 450);

        this.gradient.addColorStop(0, "rgba(255, 0,0, 0.5)");
        this.gradient.addColorStop(0.5, "rgba(255, 0, 0, 0.25)");
        this.gradient.addColorStop(1, "rgba(255, 0, 0, 0)");

        this.gradient2.addColorStop(0, "rgba(0, 231, 255, 0.9)");
        this.gradient2.addColorStop(0.5, "rgba(0, 231, 255, 0.25)");
        this.gradient2.addColorStop(1, "rgba(0, 231, 255, 0)");

        this.chartData.datasets[0].backgroundColor = this.gradient;
        this.chartData.datasets[1].backgroundColor = this.gradient2;

        this.renderChart(this.chartData, this.chartOption);
      }
    }
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
