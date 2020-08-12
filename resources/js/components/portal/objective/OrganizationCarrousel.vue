<template>
  <hooper :settings="hooperSettings" style="height: 150px">
    <slide v-for="org in slides" :key="`org-${org.id}`">
      <div class="media p-1 d-flex align-items-stretch" style="height: 150px">
        <img
          :src="org.logo ? `/${org.logo.path}` : '/img/default-avatar.png'"
          class="mr-3 rounded"
          style="width: 64px; height: 64px;"
        />
        <div class="media-body mr-5">
          <h6 class="is-600">{{org.name}}</h6>
          <p class="text-smallest mb-0">{{org.description}}</p>
        </div>
      </div>
    </slide>
    <hooper-navigation slot="hooper-addons"></hooper-navigation>
  </hooper>
</template>

<script>
import {
  Hooper,
  Slide,
  Navigation as HooperNavigation,
  Pagination as HooperPagination,
} from "hooper";
export default {
  props: ["slides"],
  components: {
    Hooper,
    Slide,
    HooperNavigation,
    HooperPagination,
  },
  data() {
    return {
      hooperSettings: {
        itemsToShow: 1,
        centerMode: true,
        infiniteScroll: false,
        wheelControl: false,
        vertical: true,
        // autoPlay: true
        // breakpoints: {
        //   576: {
        //     centerMode: false,
        //     itemsToShow: 2
        //   },
        //   768: {
        //     itemsToShow: 3,
        //     centerMode: false,
        //   },
        //   992: {
        //     itemsToShow: 4,
        //     centerMode: false,
        //   }
        // }
      },
    };
  },
};
</script>

<style>
</style>