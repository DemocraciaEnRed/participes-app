<template>
  <div class="section" v-if="!isLoading">
    <div class="d-flex align-items-center" v-if="reports.length > 0">
      <div class="is-clickable" @click="previousSlide"><i class="fas fa-chevron-left fa-2x text-primary pr-3"></i></div>
    <swiper ref="mySwiper" :options="swiperOptions" class="w-100">
      <swiper-slide  v-for="report in reports" :key="`report-${report.id}`">
        <div class="report-card-carrousel card shadow-sm">
          <div class="card-body d-flex align-start flex-column">
            <p class="text-muted mb-1 align-self-start text-smaller"> <i :class="`fas ${getReportIcon(report.type)} text-primary`"></i>&nbsp;&nbsp;{{report.type_label}}</p>
            <p class="is-700 h5 m-0"><a :href="`/reportes/${report.id}`">{{shortString(report.title, 70)}}</a></p>
            <div class="mt-auto">
              <span class="text-muted text-smaller"><i class="far fa-comment fa-fw"></i>&nbsp;{{report.comments_count}} comentarios<br><i class="far fa-thumbs-up fa-fw"></i> {{report.positive_testimonies_count}} - <i class="far fa-clock fa-fw"></i>&nbsp;{{report.published_at}}</span>
            </div>
          </div>
        </div>
      </swiper-slide>
      <swiper-slide v-if="paginatorData.meta.total > 10">
        <div class="report-card-carrousel card shadow-sm bg-primary">
            <div class="card-body d-flex align-items-end flex-column text-white">
                <h5 class="is-600 m-0">¡Hace clic para ver todos los reportes!</h5>
                <p class="mt-auto h2 mb-1"><a href="/reportes" class="text-white"><i class="fas fa-arrow-alt-circle-right"></i></a></p>
            </div>
        </div>
      </swiper-slide>
      <div class="swiper-pagination" slot="pagination"></div>
    </swiper>
      <div class="is-clickable" @click="nextSlide"><i class="fas fa-chevron-right fa-2x text-primary pl-3"></i></div>
    </div>
    <section class="p-5 text-center" v-else>
      <i class="fas fa-info-circle"></i>&nbsp; No hay reportes cargados en la plataforma
    </section>
  </div>
  <section class="p-5 text-center" v-else>
    <i class="fas fa-sync fa-spin"></i> Cargando...
  </section>
</template>

<script>
import { Swiper, SwiperSlide, directive } from 'vue-awesome-swiper'
export default {
  props: {
    fetchUrl: {
      type: String,
      required: true
    }
  },
  components: {
    Swiper,
    SwiperSlide
  },

  data() {
    return {
      isLoading: true,
      reports: [],
      paginatorData: {
        links: null,
        meta: null,
      },
      swiperOptions: {
        autoHeight: true,
        slidesPerView: 1,
        spaceBetween: 10,
        pagination: {
          el: '.swiper-pagination',
          clickable: true,
          type: 'bullets',
        },
        breakpoints: {
          576: {
            spaceBetween: 20,
            slidesPerView: 2
          },
          768: {
            slidesPerView: 3,
            spaceBetween: 20,
          },
          992: {
            slidesPerView: 4,
            spaceBetween: 20,
          }
        }
      }
      // hooperSettings: {
      //   itemsToShow: 1,
      //   centerMode: true,
      //   infiniteScroll: true,
      //   wheelControl: false,
      //   }
      // }
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
    previousSlide: function(){
      this.$refs.mySwiper.$swiper.slidePrev()
    },
    nextSlide: function(){
      this.$refs.mySwiper.$swiper.slideNext()
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

