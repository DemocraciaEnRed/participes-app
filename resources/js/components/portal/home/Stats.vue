<template>
  <section v-if="!isLoading">
      <div class="row">
        <div class="col">
          <p class=" text-center"><span class="h4 is-700"><i class="far fa-dot-circle fa-fw text-reached"></i>&nbsp;{{goalsReached}}</span><br><span class="text-smaller">Alcanzadas</span></p>
          </div>
        <div class="col">
          <p class=" text-center"><span class="h4 is-700"><i class="far fa-dot-circle fa-fw text-ongoing"></i>&nbsp;{{goalsOngoing}}</span><br><span class="text-smaller">En progreso</span></p>
          </div>
        <div class="col">
          <p class=" text-center"><span class="h4 is-700"><i class="far fa-dot-circle fa-fw text-delayed"></i>&nbsp;{{goalsDelayed}}</span><br><span class="text-smaller">Demoradas</span></p>
          </div>
        <div class="col">
          <p class=" text-center"><span class="h4 is-700"><i class="far fa-dot-circle fa-fw text-inactive"></i>&nbsp;{{goalsInactive}}</span><br><span class="text-smaller">Inactivas</span></p>
          </div>
      </div>
      <div class="progress mb-3">
        <div class="progress-bar bg-reached" role="progressbar" :style="`width: ${goalsReachedPercent}%`" :aria-valuenow="goalsReached" aria-valuemin="0" aria-valuemax="100">{{goalsReachedPercent}}%</div>
        <div class="progress-bar bg-ongoing" role="progressbar" :style="`width: ${goalsOngoingPercent}%`" :aria-valuenow="goalsOngoing" aria-valuemin="0" aria-valuemax="100">{{goalsOngoingPercent}}%</div>
        <div class="progress-bar bg-delayed" role="progressbar" :style="`width: ${goalsDelayedPercent}%`" :aria-valuenow="goalsDelayed" aria-valuemin="0" aria-valuemax="100">{{goalsDelayedPercent}}%</div>
        <div class="progress-bar bg-inactive" role="progressbar" :style="`width: ${goalsInactivePercent}%`" :aria-valuenow="goalsInactive" aria-valuemin="0" aria-valuemax="100">{{goalsInactivePercent}}%</div>
      </div>
      <div class="row">
        <div class="col-sm-4 align-self-center text-center">
          <p class="mb-2 mb-sm-0"><span class="h5 is-700"><i class="far fa-file text-primary"></i>&nbsp;&nbsp;{{reportsTotal}}</span><br class="d-none d-sm-block"><span class="d-sm-none">&nbsp;&nbsp;</span><span class="text-smaller">Reportes en los<br class="d-none d-sm-block"><span class="d-sm-none">&nbsp;</span>últimos 15 dias</span></p>
        </div>
        <div class="col-sm-8">
          <reports-chart :chart-data="reportsData" :styles="chartStyle"/>
        </div>
      </div>
  </section>
  <section v-else>
    <slot></slot>
  </section>
</template>

<script>
import ReportsChart from './ReportsChart';
export default {
  props: {
    fetchUrl: {
      type: String,
      required: true
    }
  },
  components: {
    ReportsChart
  },
  data() {
    return {
      isLoading: true,
      goalsTotal: 0,
      goalsReached: 0,
      goalsOngoing: 0,
      goalsDelayed: 0,
      goalsInactive: 0,
      reportsTotal: 0,
      reportsData: [],
      styles: {
        height: '100'
      }
    }
  },
  beforeMount: function(){
    this.fetchStats();
  },
  methods: {
    fetchStats: function(){
      this.isLoading = true
      this.$http.get(this.fetchUrl)
      .then( response => {
        this.goalsTotal = response.data.data.goals_total
        this.goalsReached = response.data.data.goals_reached
        this.goalsOngoing = response.data.data.goals_ongoing
        this.goalsDelayed = response.data.data.goals_delayed
        this.goalsInactive = response.data.data.goals_inactive
        this.reportsTotal = response.data.data.reports_total
        this.reportsData = response.data.data.reports_data
      })
      .catch( error => {
        this.$toasted.show('Hubo un error cargando las estadisticas', {icon: 'exclamation-triangle'})
        console.error(error)
      })
      .finally( () => {
        this.isLoading = false
      })
    },
  },
  computed: {
    goalsReachedPercent: function(){
      if(this.goalsTotal == 0) return 0;
      return ((this.goalsReached / this.goalsTotal)*100).toFixed()
    },
    goalsOngoingPercent: function(){
      if(this.goalsTotal == 0) return 0;
      return ((this.goalsOngoing / this.goalsTotal)*100).toFixed()
    },
    goalsDelayedPercent: function(){
      if(this.goalsTotal == 0) return 0;
      return ((this.goalsDelayed / this.goalsTotal)*100).toFixed()
    },
    goalsInactivePercent: function(){
      if(this.goalsTotal == 0) return 0;
      return ((this.goalsInactive / this.goalsTotal)*100).toFixed()
    },
    chartStyle: function(){
      return {
        height: `${this.styles.height}px`,
        position: 'relative'
      }
    }
  }
}
</script>

<style>

</style>