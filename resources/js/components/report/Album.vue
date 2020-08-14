<template>
  <div class="thumb-example">
    <!-- swiper2 Thumbs -->
    <swiper class="swiper gallery-thumbs" :options="swiperOptionThumbs" ref="swiperThumbs">
      <swiper-slide v-for="photo in photos" :key="`thumb-${photo.id}`" :style="`background-image: url(/${photo.thumbnail_path})`"></swiper-slide>
    </swiper>
    <!-- swiper1 -->
    <swiper class="swiper gallery-top" :options="swiperOptionTop" ref="swiperTop">
      <swiper-slide v-for="photo in photos" :key="photo.id">
        <a :href="`/${photo.path}`" target="_blank"><img :data-src="`/${photo.path}`" class="image mx-auto swiper-lazy"  alt=""></a>
        <div class="swiper-lazy-preloader swiper-lazy-preloader-white"></div>
      </swiper-slide>
      <div class="swiper-button-next swiper-button-black" slot="button-next"></div>
      <div class="swiper-button-prev swiper-button-black" slot="button-prev"></div>
    </swiper>
  </div>
</template>

<script>
  import { Swiper, SwiperSlide } from 'vue-awesome-swiper'

  export default {
    props: ['photos'],
    components: {
      Swiper,
      SwiperSlide
    },
    data() {
      return {
        swiperOptionTop: {
          loop: true,
          autoHeight: true,
          loopedSlides: this.photos.length, // looped slides should be the same
          // spaceBetween: 10,
          centeredSlides: true,
          lazy: true,
          navigation: {
            nextEl: '.swiper-button-next',
            prevEl: '.swiper-button-prev'
          }
        },
        swiperOptionThumbs: {
          loop: true,
          loopedSlides: this.photos.length, // looped slides should be the same
          spaceBetween: 10,
          centeredSlides: true,
          slidesPerView: 'auto',
          touchRatio: 0.2,
          slideToClickedSlide: true
        }
      }
    },
    mounted() {
      this.$nextTick(() => {
        const swiperTop = this.$refs.swiperTop.$swiper
        const swiperThumbs = this.$refs.swiperThumbs.$swiper
        swiperTop.controller.control = swiperThumbs
        swiperThumbs.controller.control = swiperTop
      })
    }
  }
</script>

<style lang="scss" scoped>
  .thumb-example {
    height: 100%;
    // background-color: ;
  }

  .swiper {
    .swiper-slide {
      background-size: cover;
      background-position: center;
    }

    &.gallery-top {
      height: 100%;
      width: 100%;
      .image{
        height: 100%;
        width: auto;
        max-width: 100%;
        max-height: 500px;
      }
    }
    &.gallery-thumbs {
      // height: 20%;
      box-sizing: border-box;
      padding: 10px 0;
    }
    &.gallery-thumbs .swiper-slide {
      width: 25%;
      height: 150px;
      opacity: 0.2;
      &:hover{
        cursor: pointer;
      }
    }
    &.gallery-thumbs .swiper-slide-active {
      opacity: 1;
    }
  }
</style>
