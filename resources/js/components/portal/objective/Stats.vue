<template>
  <section v-if="!isLoading">
    <div class="row justify-content-md-center">
      <div class="col-lg-4 text-center align-self-center text-center">
        <div class="row mb-2">
          <div class="col-6">
            <span class="h4 is-600"><i class="far fa-file"></i>&nbsp;&nbsp;{{reportsTotal}}</span><br><span class="text-smaller">Reportes</span>
            </div>
          <div class="col-6">
            <span class="h4 is-600"><i class="fas fa-medal"></i>&nbsp;&nbsp;{{goalsTotal}}</span><br><span class="text-smaller">Metas</span>
            </div>
        </div>
        <div class="row">
          <div class="col-6">
            <span class="h4 is-600"><i class="fas fa-box"></i>&nbsp;&nbsp;{{filesTotal}}</span><br><span class="text-smaller">Archivos</span>
            </div>
          <div class="col-6">
            <span class="h4 is-600"><i class="fas fa-binoculars"></i>&nbsp;&nbsp;{{subscribersTotal}}</span><br><span class="text-smaller">Suscriptores</span>
            </div>
        </div>
      </div>
      <div class="col-lg-4 text-center">
        <div class="row mb-2">
          <div class="col-6">
            <span class="h4 is-600"><i class="far fa-dot-circle fa-fw text-reached"></i>&nbsp;{{goalsReached}}</span><br><span class="text-smaller">Alcanzadas</span>
            </div>
          <div class="col-6">
            <span class="h4 is-600"><i class="far fa-dot-circle fa-fw text-ongoing"></i>&nbsp;{{goalsOngoing}}</span><br><span class="text-smaller">En progreso</span>
            </div>
        </div>
        <div class="row">
          <div class="col-6">
            <span class="h4 is-600"><i class="far fa-dot-circle fa-fw text-delayed"></i>&nbsp;{{goalsDelayed}}</span><br><span class="text-smaller">Demoradas</span>
            </div>
          <div class="col-6">
            <span class="h4 is-600"><i class="far fa-dot-circle fa-fw text-inactive"></i>&nbsp;{{goalsInactive}}</span><br><span class="text-smaller">Inactivas</span>
            </div>
          </div>
        </div>
      <div class="col-lg-4">
        <goals-doughnut :chartData="chartData" :styles="chartStyle" class="mb-3 mb-md-0"></goals-doughnut>
      </div>
    </div>
  </section>
  <section v-else>
    <slot></slot>
  </section>
</template>

<script>
import GoalsDoughnut from './GoalsDoughnut';
export default {
  props: {
    fetchUrl: {
      type: String,
      required: true
    }
  },
  components: {
    GoalsDoughnut
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
      filesTotal: 0,
      photosTotal: 0,
      // reportsData: [],
      styles: {
        height: '100',
        width: '150'
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
        this.filesTotal = response.data.data.files_total
        this.subscribersTotal = response.data.data.subscribers_total
        // this.reportsData = response.data.data.reports_data
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
    chartData: function(){
      return {
        labels: ['Alcanzadas','En progreso','Demoradas','Inactivas'],
        data: [
          this.goalsReached,
          this.goalsOngoing,
          this.goalsDelayed,
          this.goalsInactive,
        ],
        labelsColors: ['#2eda54','#ffa51e','#f15454','#7e7e7e']
      }
    },
    chartStyle: function(){
      return {
        height: `${this.styles.height}px`,
        // width: `${this.styles.width}px`,
        position: 'relative'
      }
    }
  }
}
</script>

<style>

</style>