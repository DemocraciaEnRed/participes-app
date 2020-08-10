<template>
    <div class="media pl-3 mb-3 pr-3" style="margin-left: 80px;">
      <img :src="reply.user.avatar ? reply.user.avatar.thumbnail_path : '/img/default-avatar.png'" alt="" class="align-self-start mr-3 rounded-circle" style="width: 32px">
      <div class="media-body">
        <p class="text-smaller mb-0"><i class="fas fa-shield-alt fa-fw"></i><b>{{`${reply.user.name} ${reply.user.surname}`}}</b></p>
        <div class="animate__animated animate__flash mb-2" v-if="showConfirmDelete">
          <p class="mb-2 text-smaller">¿Esta seguro que quiere eliminar el comentario?</p>
          <button class="btn btn-outline-danger btn-sm"><i class="fas fa-trash"></i>&nbsp;Eliminar</button>
          <button class="btn btn-outline-dark btn-sm" @click="toggleConfirmDelete">Cancelar</button>
        </div>
        <div v-show="!showConfirmDelete">
          <p class="text-smaller mb-0">{{reply.content}}</p>
          <p class="text-smaller mb-0 text-muted">{{reply.created_at}}</p>
        </div>
      </div>
      <div class="ml-2" v-if="reply.delete_url">
        <p class="text-center text-muted mb-1" v-if="reply.delete_url"><a class="is-clickable link-light" @click="toggleConfirmDelete"><i class="fas fa-times fa-fw"></i></a></p>
      </div>
    </div>
</template>

<script>
export default {
  props: ['reply'],
  data(){
    return {
      showConfirmDelete: false,
    }
  },
  methods: {
    toggleConfirmDelete: function(){
      this.showConfirmDelete = !this.showConfirmDelete
    },
    deleteComment: function(){
      this.$http.delete(this.reply.delete_url)
      .then( response => {
        this.$emit('fetchComments');
      })
    },
  }
}
</script>

<style>

</style>