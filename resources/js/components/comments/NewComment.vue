<template>
  <div class="media p-3" v-if="!sent">
      <img :src="user.avatar ? user.avatar.thumbnail_path : '/img/default-avatar.png'" alt="" class="align-self-start mr-3 rounded-circle" style="width: 64px">
      <div class="media-body">
        <p class="text-smaller mb-1"><b>{{`${user.name} ${user.surname}`}}</b></p>
        <div class="form-group mb-2">
        <textarea v-model="comment" rows="2" class="form-control text-smaller" placeholder="Deje aquí su comentario..." :disabled="isLoading"></textarea>
      </div>
      <button class="btn btn-outline-primary text-smallest btn-sm" @click="submit" v-if="!isLoading && !sent"><i class="fas fa-paper-plane"></i>&nbsp;Guardar</button>
        <p class="text-smaller mb-0 animate__animated animate__flash animate__infinite text-primary" v-if="isLoading && !sent"><i class="fas fa-spin fa-sync"></i>&nbsp;Enviando comentario...</p>
    </div>
  </div>
</template>

<script>
export default {
  props: ['url', 'user'],
  data(){
    return {
      isLoading: false,
      comment: null,
      sent: false,
      success: false,
      error: false
    }
  },
  methods: {
    submit: function(){
      this.isLoading = true;
      if(!this.comment || !this.user) return
      this.$http.post(this.url, {
        content: this.comment
      })
      .then( response => {
        this.sent = true
        this.$toasted.success('Se ha guardado su comentario',{icon: 'check', duration: 5000})
        this.$emit('fetchComments')
      })
      .catch( error => {
        this.sent = true
        this.$toasted.error('Hubo un error al guardar su comentario',{icon: 'exclamation-triangle', duration: 5000})
      })
      .finally( () => {
        this.isLoading = false;
      })
    }
  }
}
</script>

<style>

</style>