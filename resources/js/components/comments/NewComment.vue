<template>
  <div class="media p-3">
      <img :src="user.avatar.thumbnail_path" alt="" class="align-self-start mr-3 rounded-circle" style="width: 64px">
      <div class="media-body">
        <p class="text-smaller mb-1"><b>{{`${user.name} ${user.surname}`}}</b></p>
        <!-- <p class="text-smaller mb-0" style="white-space: pre-line;" v-if="sent && success">{{comment}}</p> -->
        <div class="form-group mb-2">
        <textarea v-model="comment" rows="2" class="form-control text-smaller" placeholder="Deje aquí su comentario..." v-if="!sent" :disabled="isLoading"></textarea>
      </div>
      <button class="btn btn-outline-primary text-smallest btn-sm" @click="submit" v-if="!isLoading && !sent"><i class="fas fa-paper-plane"></i>&nbsp;Guardar</button>
        <p class="text-smaller mb-0 animate__animated animate__flash animate__infinite text-primary" v-if="isLoading && !sent"><i class="fas fa-spin fa-sync"></i>&nbsp;Enviando comentario...</p>
        <p class="text-smaller mb-0 animate__animated animate__flash text-success" v-if="sent && success"><i class="fas fa-check"></i> Su comentario ha sido guardado</p>
        <p class="text-smaller mb-0 animate__animated animate__flash text-danger" v-if="sent && error"><i class="fas fa-check"></i> Hubo un error guardando el comentario</p>
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
        this.success = true
        this.$emit('fetchComments')
      })
      .catch( error => {
        this.sent = true
        this.error = true
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