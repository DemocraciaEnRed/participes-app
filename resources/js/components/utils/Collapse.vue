<template>
  <div>
    <div class="d-flex justify-content-between align-items-center is-clickable"  @click="showMore = !showMore">
      <div class="w-100">
        <slot name="title"></slot>
      </div>
      <div class="ml-1">
        <i class="fas fa-lg fa-fw" :class="{'fa-chevron-up': showMore, 'fa-chevron-down': !showMore}"></i>
      </div>
    </div>
    <transition name="fade">
        <div v-if="showMore">
          <slot name="content"></slot>
        </div>
    </transition>
  </div>
</template>

<script>
export default {
  props: {
    show: {
      type: Boolean,
      default: false
    }
  },
  data(){
    return {
      showMore: this.show
    }
  },
}
</script>

<style lang="scss" scoped>
.fade-enter-active, .fade-leave-active {
  transition: opacity .5s;
}
.fade-enter, .fade-leave-to /* .fade-leave-active below version 2.1.8 */ {
  opacity: 0;
}
</style>