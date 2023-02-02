<template>
  
</template>

<template>
  <div class="section">
    <div class="d-flex align-items-center" v-if="categories.length > 0">
      <div class="is-clickable" @click="previousSlide"><i class="fas fa-chevron-left fa-2x text-primary pr-3"></i></div>
      <swiper ref="myCategorySwiper" :options="swiperOptions" class="w-100">
        <swiper-slide  v-for="category in categories" :key="`category-${category.id}`">
          <div class="category-card-carrousel card shadow-sm is-clickable" @click="goTo(`/objetivos?category=${category.id}`)">
            <div class="card-body d-flex text-center align-items-center justify-content-center flex-column">
              <p :style="`color: ${category.color}`"> <i :class="`${category.icon} fa-3x`"></i></p>
              <h5 :style="`color: ${category.color}`" class="is-600 m-0">{{ category.title }}</h5>
            </div>
          </div>
        </swiper-slide>
        <div class="swiper-pagination" slot="pagination"></div>
      </swiper>
        <div class="is-clickable" @click="nextSlide"><i class="fas fa-chevron-right fa-2x text-primary pl-3"></i></div>
      </div>
      <section class="p-5 text-center" v-else>
        <i class="fas fa-info-circle"></i>&nbsp; No hay categorias cargadas en la plataforma
      </section>
    </div>
</template>

<script>
import { Swiper, SwiperSlide, directive } from 'vue-awesome-swiper'
export default {
  props: {
    categories: {
      type: Object,
      required: true
    }
  },
  components: {
    Swiper,
    SwiperSlide
  },
  data() {
    return {
      swiperOptions: {
        autoHeight: true,
        slidesPerView: 1,
        spaceBetween: 10,
        pagination: {
          el: '.swiper-pagination',
          clickable: true,
          type: 'bullets',
        },
        // centeredSlides: true,
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

  },
  methods: {
    goTo(url){
      // change the location
      window.location = url
    },
    // fetchReports: function(){
    //   this.isLoading = true
    //   this.$http.get(this.fetchUrl)
    //   .then( response => {
    //     this.reports = response.data.data
    //     this.paginatorData = {
    //         links: response.data.links,
    //         meta: response.data.meta
    //       }
    //   })
    //   .catch( error => {
    //     console.error(error)
    //   })
    //   .finally( () => {
    //     this.isLoading = false
    //   })
    // },
    previousSlide: function(){
      this.$refs.myCategorySwiper.$swiper.slidePrev()
    },
    nextSlide: function(){
      this.$refs.myCategorySwiper.$swiper.slideNext()
    },
    // getDate: function(date){
    //   let theDate = new Date(date);
    //   const offset = theDate.getTimezoneOffset()
    //   theDate = new Date(theDate.getTime() + (offset*60*1000))
    //   return theDate.toISOString().split('T')[0]
    // }
  },
}
</script>

