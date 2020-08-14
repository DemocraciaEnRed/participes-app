<template>
  <swiper ref="mySwiper" :options="swiperOptions">
    <swiper-slide v-for="org in slides" :key="`org-${org.id}`">
      <div class="media p-1 d-flex align-items-stretch">
        <img
          :src="org.logo ? `/${org.logo.path}` : '/img/default-avatar.png'"
          class="mr-3 rounded"
          style="width: 64px; height: 64px;"
        />
        <div class="media-body mr-5">
          <h6 class="is-600">{{org.name}}</h6>
          <p class="mb-0">{{org.description}}</p>
        </div>
      </div>
    </swiper-slide>
    <div class="swiper-pagination" slot="pagination"></div>
  </swiper>
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
};
</script>

<style>
</style>