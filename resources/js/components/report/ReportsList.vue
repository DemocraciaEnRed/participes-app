<template>
  <section v-if="firstFetch">
    <div class="d-flex align-items-stretch" v-for="(report,index) in reports" :key="report.id">
      <div class="date-column d-none d-sm-block" :class="{'mb-3': index == reports.length - 1}" style="min-width: 85px;">
        <div class="date-pill w-100" v-if="showDate(index)">{{report.date.split('T')[0]}}</div>
        <div class="date-line"></div>
        <div class="last-one" v-if="index == reports.length - 1"></div>
      </div>
      <report-card :report="report" @fetch-more="fetchMore" :login-url="loginUrl"></report-card>
    </div>
      <div class="text-center">
        <button @click="fetchMore" v-if="canFetchMore" :disabled="isLoading" class="btn btn-outline-dark">
          <span v-if="isLoading"><i class="fas fa-sync fa-spin"></i>&nbsp;Cargando</span>
          <span v-else>Cargar mas reportes</span>
        </button>
      </div>
    <p class="text-muted" v-if="reports.length == 0">No hay reportes</p>
  </section>
  <section v-else>
    <slot></slot>
  </section>
</template>

<script>
import ReportCard from './ReportCard'
export default {
  props: ['fetchUrl', 'loginUrl'],
  components: {
    ReportCard
  },
  data(){
    return {
      isLoading: true,
      firstFetch: false,
      reports: [],
      paginatorData: {
        links: null,
        meta: null,
      },
    }
  },
  created: function(){
    this.fetchReports()
  },
  methods:{
    fetchReports: function(){
      this.isLoading = true
      this.$http.get(this.fetchUrl)
      .then( response => {
        this.reports = response.data.data
        this.paginatorData = {
          links: response.data.links,
          meta: response.data.meta
        }
        this.firstFetch = true
      })
      .catch( error => {
        this.$toasted.show('Hubo un error cargando los reportes', {icon: 'exclamation-triangle'})
        console.error(error)
      })
      .finally( () => {
        this.isLoading = false
      })
    },
    fetchMore: function(){
      this.isLoading = true
      this.$http.get(this.paginatorData.links.next)
      .then( response => {
        this.reports = this.reports.concat(response.data.data)
        this.paginatorData = {
          links: response.data.links,
          meta: response.data.meta
        }
      })
      .catch( error => {
        this.$toasted.show('Hubo un error cargando los reportes', {icon: 'exclamation-triangle'})
        console.error(error)
      })
      .finally( () => {
        this.isLoading = false
      })
    },
    showDate: function(index){
      if(index == 0) return true;
      let lastDate = this.reports[index-1].date.split('T')[0]
      let nowDate = this.reports[index].date.split('T')[0]
      if(nowDate == lastDate) return false
      return true
    },
  },
  computed:{
    canFetchMore: function(){
      if(!this.paginatorData.links) return false
      if(this.paginatorData.links.next != null) return true
      return false
    }
  }
}
</script>

<style lang="scss" scoped>

.date-column{
  position: relative;
}
.date-pill{
  z-index: 10;
  position: relative;
  top: 0px;
  padding: 3px 2px;
  border-radius: 10px;
  background-color: #FFF;
  border: 2px solid #343a40;
  font-size: 0.7em;
  font-weight: 800;
  color: #343a40;
  text-align: center;
}
.date-line{
	position: absolute;
	top: 0px;
	height: 100%;
	width: 2px;
	background-color: #343a40;
	margin: 0 auto;
	left: 50%;
	margin-right: -50%;
	transform: translate(-50%, 0%);
}
.last-one{
  position: absolute;
  height: 25px;
  width: 25px;
  bottom: 0;
  border: 2px solid #343a40;
  background-color: #FFF;
  border-radius: 25px;
  left: 50%;
  transform: translate(-50%, 0%);
}
</style>