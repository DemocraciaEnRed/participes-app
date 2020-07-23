<template>
  <li class="list-group-item notification-item d-flex justify-content-between" :class="{'notification-read': read}">
    <div :class="{'animate__animated animate__flash': ok}">
    <slot></slot>
    </div>
    <div class="ml-2 pt-2 text-center">
      <a class="is-clickable text-info" @click="markNotification" v-if="!read && !loading && !ok && !error"><i class="fas fa-check fa-lg"></i></a>
      <i class="text-light fas fa-spin fa-sync fa-lg" v-else-if="!read && loading && !ok && !error"></i>
      <i class="text-light far fa-frown-open fa-lg" v-else-if="!read && !loading && error"></i>
      <i class="text-light far fa-envelope-open fa-lg" v-else-if="read && !loading && !error"></i>
      <span v-if="ok" class="text-success text-smallest"><br>Ok</span>
      <span v-if="error" class="text-danger text-smallest"><br>Error</span>
    </div>
  </li>
</template>

<script>
export default {
  // props: {
  //   notification: {
  //     type: Object,
  //     required: true
  //   },
  //   formUrl: {
  //     type: 'string'
  //   }
  // },
  props: ['formUrl', 'notification'],
  data(){
    return {
      read: this.notification.read_at ? true : false,
      loading: false,
      ok: false,
      error: false,
    }
  },
  methods: {
    markNotification: function(){
      if(this.read) return
      this.loading = true
      this.$http.put(this.formUrl)
      .then(response => {
        this.ok = true
        this.read = true
      })
      .catch( err => {
        this.error = true
        console.error(err)
      })
      .finally( () => {
        this.loading = false
      })

    }
  }
}
</script>

<style lang="scss" scoped>
.notification-item{
  line-height: 1.2;
  &.notification-read {
    color: #95a5a6;
    a {
      color: #A0C1D7;
      &:hover{
        color: #6eabd4;

      }
    }
  }
}
</style>