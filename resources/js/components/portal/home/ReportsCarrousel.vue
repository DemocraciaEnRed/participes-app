<template>
  <div class="section" v-if="!isLoading">
    <hooper :settings="hooperSettings" style="height: 100%">
      <slide class="px-2" v-for="report in reports" :key="`report-${report.id}`">
        <div class="report-card-carrousel card shadow-sm">
          <div class="card-body d-flex align-start flex-column">
            <p class="text-muted mb-1 align-self-start text-smaller"> <i :class="`fas ${getIcon(report.type)}`"></i>&nbsp;{{report.type_label}}</p>
            <h5 class="is-600 m-0"><a :href="`/reportes/${report.id}`">{{shortString(report.title, 250)}}</a></h5>
            <div class="mt-auto">
              <div class="row align-self-strech">
                <div class="col text-center text-muted">
                  <i class="far fa-comment fa-fw"></i>&nbsp;0
                </div>
                <div class="col text-center text-muted">
                  2020-05-20
                </div>
              </div>
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
          <!-- <hooper-navigation slot="hooper-addons"></hooper-navigation> -->
          <hooper-pagination slot="hooper-addons"></hooper-pagination>
    </hooper>
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
    getIcon: function(type){
      switch(type){
        case 'post':
          return 'fa-bullhorn'
          break;
        case 'progress':
          return 'fa-fast-forward'
          break;
        case 'milestone':
          return 'fa-medal'
          break;
        default:
          return 'fa-file'
      }
      return 'fa-question-circle'
    }
  },
}
</script>

<style>

</style>