<template>
    <div>

        <div class="chart-card mb-3">
            <Bar
                :chart-options="chartOptions"
                :chart-data="chartData"
                :chart-id="chartId"
                :dataset-id-key="datasetIdKey"
                :plugins="plugins"
                :css-classes="firsbar"
                :styles="styles"
                :width="width"
                :height="150"
            />
        </div>
        <div class="chart-card">
            <Bar
                :chart-options="chartOptions"
                :chart-data="chartDataPie"
                :chart-id="chartId"
                :dataset-id-key="datasetIdKey"
                :plugins="plugins"
                :css-classes="firsbar"
                :styles="styles"
                :width="width"
                :height="150"
            />
        </div>
    </div>
</template>

<script>

// chart => chart.js npm i vue-chartjs chart.js
import { Bar } from 'vue-chartjs/legacy'
import { Chart as ChartJS, Title, Tooltip, Legend, BarElement, CategoryScale, LinearScale } from 'chart.js'

// ChartJS.register(Title, Tooltip, Legend, BarElement, CategoryScale, LinearScale)

export default{
    mounted() {
        this.getSatatData();

    },
  methods: {
   async  getSatatData(){
         const url ='/api/home'
        await this.$store.dispatch('getData', url);
    }
  },
    components:{Bar  },

  data () {
    return {
      chartData: {
        labels: [ ],
        datasets: [ {
            type:'line',
            label: 'Commands By Months 2022',
            data:[],
            fill: false,
            borderColor: 'rgb(75, 192, 192)',
            tension: 0.1,
        },

        ]
      },
       chartDataPie : {
         labels: [ ],
        datasets: [{
            label: 'Cars By production company',
            data: [],
            backgroundColor: [
            'rgb(255, 99, 132)',
            'rgb(54, 162, 235)',
            'rgb(255, 205, 86)'
            ],
            hoverOffset: 4
        }]
      },
      chartOptions: {
        responsive: true
      },

   }
  },
  watch: {
    commandByMonths(val, oldVal) {
      for(var i=0;i< val.length;i++){
        this.chartData.datasets[0].data.push(val[i].CommandsCount)
        this.chartData.labels.push(val[i].month)
      }

    },
     carsBymfcmp(val, oldVal) {
      for(var i=0;i< val.length;i++){
        this.chartDataPie.datasets[0].data.push(val[i].carscount)
        this.chartDataPie.labels.push(val[i].mfcmptitle)
      }

    },
  },
  computed:{
     commandByMonths: function () {
       return this.$store.state.stateData.commandByMonths

    },
    carsBymfcmp: function () {
       return this.$store.state.stateData.carbycmp

    },

  }

}

</script>

<style>

/*========== VARIABLES CSS ==========*/
:root {
  --header-height: 3.5rem;
  --nav-width: 219px;
 /**========== darkmode =======*/
 --dark-pr-color:#000000;
 --dark-sc-color: #2B2B2B;
 --dark-tr-color:#080218;
 --dark-fr-color:#3F0071;
 --dark-fv-color:#610094;

 --text-seconde-color-dark: #E3E3E3;
 --text-color-dark:#F1F1F1;
 --text-seconde-color-dark: #E3E3E3;
  /*========== Colors ==========*/
  --my-pr-color:  #232D65;
  --my-sc-color: #929DD9;
  --my-tr-color: #A8B0E0;
  --first-color:   #f4f5f7d3;
  --first-color-light: #fefefe;
  --title-color: #19181B;
  --text-color:   #a9aec0d3;
  --text-color-light:   #bec4d4d3;
  --body-color: #F9F6FD;
  --container-color: #FFFFFF;

  /*========== Font and typography ==========*/
  --body-font: 'Poppins', sans-serif;
  --normal-font-size: .938rem;
  --small-font-size: .75rem;
  --smaller-font-size: .75rem;

  /*========== Font weight ==========*/
  --font-medium: 500;
  --font-semi-bold: 600;

  /*========== z index ==========*/
  --z-fixed: 100;
}

/*** dark mode start ***/
body.dark-theme .chart-card{
 background:var(--dark-sc-color);
}

/*** dark mode end ***/
.chart-card{
    width: 100%;
    /* height: 400px; */
    background: #fff;
     box-shadow: rgba(14, 30, 37, 0.12) 0px 2px 4px 0px, rgba(14, 30, 37, 0.32) 0px 2px 16px 0px;
}
.firsbar{
     height: 400px !important;
}

</style>
