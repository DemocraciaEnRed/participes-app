<template>
<div class="d-flex align-items-center" v-if="slides.length > 0">
      <div class="is-clickable" @click="previousSlide"><i class="fas fa-chevron-left fa-lg pr-3"></i></div>
  <swiper ref="mySwiper" :options="swiperOptions">
    <swiper-slide v-for="org in slides" :key="`org-${org.id}`">
      <div class="media p-1 d-flex align-items-start">
        <img
          :src="org.logo ? `${org.logo.path}` : '/img/default-organization.png'"
          class="mr-3 rounded"
          width="64"
        />
        <div class="media-body mr-5 align-self-center">
          <h6 class="is-700 mb-1">{{org.name}}</h6>
          <span class="text-smaller text-muted">{{org.description}}</span>
        </div>
      </div>
    </swiper-slide>
    <div class="swiper-pagination" slot="pagination"></div>
  </swiper>
  <div class="is-clickable" @click="nextSlide"><i class="fas fa-chevron-right fa-lg pl-3"></i></div>
</div>
</template>

<script>
import { Swiper, SwiperSlide, directive } from 'vue-awesome-swiper'
export default {
  props: ["slides"],
  components: {
    Swiper,
    SwiperSlide
  },
  data() {
    return {
      swiperOptions: {
        autoHeight: true,
        pagination: {
          el: '.swiper-pagination',
          clickable: true,
          type: 'bullets',
        },
      }
    };
  },
  methods: {
    previousSlide: function(){
      this.$refs.mySwiper.$swiper.slidePrev()
    },
    nextSlide: function(){
      this.$refs.mySwiper.$swiper.slideNext()
    },
  }
};
</script>

<style>
</style>