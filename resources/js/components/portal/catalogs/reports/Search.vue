<template>
  <section v-if="firstFetch">
    <input type="text" v-model="nameToSearch" class="form-control form-control-lg shadow-sm" placeholder="Buscar por titulo o tags">
    <small class="form-text text-muted">{{status}}</small>

    <section class="my-2">
      <div class="d-inline-block bg-white py-2 px-4 my-1 border rounded shadow-sm mr-2 is-clickable" :class="{'type-active': typeSelected == null}" @click="changeType(null)">
        <i class="fas fa-star"></i>&nbsp;Cualquier tipo
        </div>
      <div class="d-inline-block bg-white py-2 px-4 my-1 border rounded shadow-sm mr-2 is-clickable" :class="{'type-active': typeSelected == type.id}" v-for="type in types" :key="`type-${type.id}`" @click="changeType(type.id)">
        <i :class="`${type.icon} text-primary`"></i>&nbsp;{{type.title}}
        </div>
      <div class="d-inline-block bg-white py-2 px-4 my-1 border rounded shadow-sm mr-2 is-clickable" :class="{'mappeable-active': mappableReports == true}" @click="mappableReports = !mappableReports">
        <i class="fas fa-map-marked-alt text-primary"></i>&nbsp;Mapeable
      </div>
    </section>
    <!-- <section class="my-2">
      <div class="d-inline-block bg-white py-2 px-4 my-1 border rounded shadow-sm mr-2 is-clickable" :class="{'status-active': statusSelected == null}" @click="changeStatus(null)">
        <i class="fas fa-star"></i>&nbsp;Cualquier estado
        </div>
      <div class="d-inline-block bg-white py-2 px-4 my-1 border rounded shadow-sm mr-2 is-clickable" :class="{'status-active': statusSelected == status.id}" v-for="status in statuses" :key="`type-${status.id}`" @click="changeStatus(status.id)">
        <i class="far fa-dot-circle" :style="`color: ${status.color}`"></i>&nbsp;{{status.title}}
        </div>
    </section> -->
    <hr>
    <report-card class="my-3" v-for="report in reports" :key="`report${report.id}`" :report="report"></report-card>
    <div class="card shadow-sm" v-if="reports.length == 0">
      <div class="card-body p-5 text-center">
            <h6 class="card-title mb-2"><i class="far fa-surprise"></i>&nbsp;¡No se encontraron reportes con esos criterios de busqueda!</h6>
            <p class="text-smaller mb-0">Intente de nuevo o cambie los criterios de busqueda</p>
      </div>
    </div>
    <hr>
    <paginator v-if="paginatorData.links && !isLoading" :paginatorData="paginatorData" @updateData="updateData" />

  </section>
  <section v-else>
    <slot></slot>
  </section>
</template>

<script>
import debounce from "lodash/debounce";
import ReportCard from './ReportCard'
export default {
  props: ['fetchUrl','categories','querystring'],
  components: {
    ReportCard
  },
  data(){
    return {
      firstFetch: false,
      isLoading: true,
      nameToSearch: "",
      searchableString: null,
      status: 'Comience escribiendo el nombre',
      typeSelected: null,
      statusSelected: null,
      mappableReports: false,
      reports: [],
      paginatorData: {
        links: null,
        meta: null,
      },
      types: [
        {
          id: 'post',
          title: 'Novedad',
          icon: 'fas fa-bullhorn'
        },
        {
          id: 'progress',
          title: 'Avance',
          icon: 'fas fa-fast-forward'
        },
        {
          id: 'milestone',
          title: 'Hito',
          icon: 'fas fa-medal'
        },
      ],
      statuses: [
        {
          id: 'reached',
          title: 'Alcanzada',
          color: '#2eda54'
        },
        {
          id: 'ongoing',
          title: 'En progreso',
          color: '#ffa51e'
        },
        {
          id: 'inactive',
          title: 'Inactiva',
          color: '#7e7e7e'
        },
        {
          id: 'delayed',
          title: 'No cumplida',
          color: '#f15454'
        },
      ]
    }
  },
  created: function(){
    this.fetchReports()
  },
  methods: {
    changeType: function(typeId){
      this.typeSelected = typeId
      this.fetchReports();
    },
    changeStatus: function(statusId){
      this.statusSelected = statusId
      this.fetchReports();
    },
    fetchReports:  debounce(
      function(){
        this.isLoading = true
        this.$http.get(this.urlGet)
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
      }, 600),
    updateData: function(data){
      this.reports = data.data
      this.paginatorData = {
        links: data.links,
        meta: data.meta
      }
    }
  },
  computed: {
    urlGet: function() {
      let query = ['with=report_goal','order_by=updated_at,DESC','size=8'];
      if (this.searchableString != null) {
        query.push("s=" + this.searchableString);
      }
      if (this.typeSelected != null) {
        query.push("type=" + this.typeSelected);
      }
      if (this.statusSelected != null) {
        query.push("status=" + this.statusSelected);
      }
      if (this.mappableReports == true) {
        query.push("mappable=true");
      }
      return this.fetchUrl.concat(query.length > 0 ? "?" : "", query.join("&"));
    }
  },
  watch: {
    nameToSearch: function(newNameToSearch, oldNameToSearch) {
      this.status = "Tipeando...";
      if (newNameToSearch.length >= 3) {
        this.searchableString = newNameToSearch
        this.fetchReports();
      }
      else {
        this.searchableString = null
        this.status = "Por favor, escriba más caracteres para la busqueda";
        this.fetchReports();
      }
    },
    mappableReports: function(){
      this.fetchReports()
    }
  }
}
</script>

<style lang="scss" scoped>
.type-active{
  background-color: #2c59fb !important;
  color: #FFF !important;
  i{
  color: #FFF !important;
  }
}
.status-active{
  background-color: #2c59fb !important;
  color: #FFF !important;
  i{
  color: #FFF !important;
  }
}
.mappeable-active{
  background-color: #2c59fb !important;
  color: #FFF !important;
  i{
  color: #FFF !important;
  }
}
</style>