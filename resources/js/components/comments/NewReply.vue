<template>
  <div class="media pl-3 mb-3 pr-3" style="margin-left: 80px;">
      <img :src="user.avatar ? user.avatar.thumbnail_path : '/img/default-avatar.png'" alt="" class="align-self-start mr-3 rounded-circle" style="width: 32px">
      <div class="media-body">
        <p class="text-smaller mb-1"><b>{{`${user.name} ${user.surname}`}}</b></p>
        <p class="text-smaller mb-0" style="white-space: pre-line;" v-if="sent && success">{{comment}}</p>
        <div class="form-group mb-2">
        <textarea v-model="comment" rows="2" class="form-control text-smaller" placeholder="Deje aquí su respuesta..." v-if="!sent" :disabled="isLoading"></textarea>
        </div>
        <button class="btn btn-outline-primary text-smallest btn-sm" @click="submit" v-if="!isLoading && !sent"><i class="fas fa-paper-plane"></i>&nbsp;Guardar</button>
        <p class="text-smaller mb-0 animate__animated animate__flash animate__infinite text-primary" v-if="isLoading && !sent"><i class="fas fa-spin fa-sync"></i>&nbsp;Enviando respuesta...</p>
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
        this.$toasted.success('¡Se ha guardado su respuesta!',{icon: 'check', duration: 5000})
      })
      .catch( error => {
        this.sent = true
        this.error = true
        this.$toasted.error('Hubo un error al guardar su respuesta',{icon: 'exclamation-triangle', duration: 5000})
      })
      .finally( () => {
        this.isLoading = false;
      })
    }
  }
}
</script>
