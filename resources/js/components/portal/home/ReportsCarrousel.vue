<template>
  <div class="section" v-if="!isLoading">
    <hooper :settings="hooperSettings" v-if="reports.length > 0" style="height: 100%">
      <slide class="px-2" v-for="report in reports" :key="`report-${report.id}`">
        <div class="report-card-carrousel card shadow-sm">
          <div class="card-body d-flex align-start flex-column">
            <p class="text-muted mb-1 align-self-start text-smaller"> <i :class="`fas ${getReportIcon(report.type)} text-primary`"></i>&nbsp;&nbsp;{{report.type_label}}</p>
            <p class="is-700 h5 m-0"><a :href="`/reportes/${report.id}`">{{shortString(report.title, 70)}}</a></p>
            <div class="mt-auto">
              <span class="text-muted"><i class="far fa-comment fa-fw"></i>&nbsp;{{report.comments_count}} comentarios<br><i class="far fa-clock fa-fw"></i>&nbsp;{{report.published_at}}</span>
            </div>
          </div>
        </div>
      </slide>
      <slide class="px-2" v-if="paginatorData.meta.total > 10">
        <div class="report-card-carrousel card shadow-sm bg-primary">
            <div class="card-body d-flex align-items-end flex-column text-white">
                <h5 class="is-600 m-0">¡Hace clic para ver todos los reportes!</h5>
                <p class="mt-auto h2 mb-1"><a href="/reportes" class="text-white"><i class="fas fa-arrow-alt-circle-right"></i></a></p>
            </div>
        </div>
      </slide>
          <hooper-pagination slot="hooper-addons"></hooper-pagination>
    </hooper>
    <section class="p-5 text-center" v-else>
        <i class="fas fa-info-circle"></i>&nbsp; No hay reportes cargados en la plataforma
      </section>
  </div>
  <section class="p-5 text-center" v-else>
    <i class="fas fa-sync fa-spin"></i> Cargando...
  </section>
</template>

<script>
import { Hooper, Slide, Navigation as HooperNavigation, Pagination as HooperPagination  } from 'hooper';
export default {
  props: {
    fetchUrl: {
      type: String,
      required: true
    }
  },
  components: {
    Hooper,
    Slide,
    HooperNavigation,
    HooperPagination
  },
  data() {
    return {
      isLoading: true,
      reports: [],
      paginatorData: {
        links: null,
        meta: null,
      },
      hooperSettings: {
        itemsToShow: 1,
        centerMode: true,
        infiniteScroll: true,
        wheelControl: false,
        breakpoints: {
          576: {
            centerMode: false,
            itemsToShow: 2
          },
          768: {
            itemsToShow: 3,
            centerMode: false,
          },
          992: {
            itemsToShow: 4,
            centerMode: false,
          }
        }
      }
    }
  },
  beforeMount: function(){
    this.fetchReports();
  },
  methods: {
    fetchReports: function(){
      this.isLoading = true
      this.$http.get(this.fetchUrl)
      .then( response => {
        this.reports = response.data.data
        this.paginatorData = {
            links: response.data.links,
            meta: response.data.meta
          }
      })
      .catch( error => {
        console.error(error)
      })
      .finally( () => {
        this.isLoading = false
      })
    },
    getDate: function(date){
      let theDate = new Date(date);
      const offset = theDate.getTimezoneOffset()
      theDate = new Date(theDate.getTime() + (offset*60*1000))
      return theDate.toISOString().split('T')[0]
    }
  },
}
</script>

<style>

</style>