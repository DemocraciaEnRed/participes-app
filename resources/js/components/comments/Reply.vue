<template>
    <div class="media pl-3 mb-3 pr-3" style="margin-left: 80px;">
      <img :src="reply.user.avatar ? reply.user.avatar.thumbnail_path : '/img/default-avatar.png'" alt="" class="align-self-start mr-3 rounded-circle" style="width: 32px">
      <div class="media-body">
        <p class="text-smaller mb-0"><b>{{`${reply.user.name} ${reply.user.surname}`}}</b><span v-if="reply.author_member_objective" class="text-info">&nbsp;&nbsp;&nbsp;<i class="fas fa-shield-alt"></i> Equipo</span><span v-if="reply.user.organization"><br><span class="text-primary text-smallest"><i class="fas fa-house-user"></i> {{reply.user.organization}}</span></span></p>
        <div class="animate__animated animate__flash mb-2" v-if="showConfirmDelete">
          <p class="mb-2 text-smaller">¿Esta seguro que quiere eliminar el comentario?</p>
          <button class="btn btn-outline-danger btn-sm" @click="deleteReply"><i class="fas fa-trash"></i>&nbsp;Eliminar</button>
          <button class="btn btn-outline-dark btn-sm" @click="toggleConfirmDelete">Cancelar</button>
        </div>
        <div v-show="!showConfirmDelete && !showEditForm">
          <p class="text-smaller mb-0 nl2br">{{reply.content}}</p>
          <p class="text-smaller mb-0 text-muted">{{reply.created_at}}<span v-if="reply.edited">&nbsp;(Editado, {{reply.updated_at}})</span></p>
        </div>
         <div class="animate__animated animate__flash mb-2" v-if="showEditForm">
          <div class="form-group mb-2">
            <textarea v-model="commentText" rows="2" class="form-control text-smaller" placeholder="Deje aquí su comentario..." :disabled="isLoading"></textarea>
          </div>
          <button class="btn btn-outline-primary text-smallest btn-sm" @click="submitEdit" v-if="!isLoading && !sent"><i class="fas fa-pencil-alt"></i>&nbsp;Guardar</button>
          <p class="text-smaller mb-0 animate__animated animate__flash animate__infinite text-primary" v-if="isLoading && !sent"><i class="fas fa-spin fa-sync"></i>&nbsp;Editando...</p>
        </div>
      </div>
      <div class="ml-2" v-if="reply.delete_url || reply.edit_url">
        <p class="text-center text-muted my-1" v-if="reply.edit_url"><a class="is-clickable link-light" @click="toggleShowEditForm"><i class="fas fa-pencil-alt fa-fw"></i></a></p>
        <p class="text-center text-muted mb-1" v-if="reply.delete_url"><a class="is-clickable link-light" @click="toggleConfirmDelete"><i class="fas fa-times fa-fw"></i></a></p>
      </div>
    </div>
</template>

<script>
export default {
  props: ['reply', 'user'],
  data(){
    return {
      showConfirmDelete: false,
      showEditForm: false,
      commentText: null,
      isLoading: false,
      sent: false,
    }
  },
  mounted: function(){
    this.commentText = this.reply.content
  },
  methods: {
    toggleShowEditForm: function(){
      this.showConfirmDelete = false
      this.showEditForm = !this.showEditForm
    },
    toggleConfirmDelete: function(){
      this.showEditForm = false
      this.showConfirmDelete = !this.showConfirmDelete
    },
    deleteReply: function(){
      this.$http.delete(this.reply.delete_url)
      .then( response => {
        this.$emit('fetchComments');
      })
    },
    submitEdit: function(){
      if(!this.commentText || !this.user) return
      this.isLoading = true;
      this.sent = false
      this.$http.put(this.reply.edit_url,{
        content: this.commentText
      })
      .then( response => {
        this.sent = true
        this.$toasted.success('Se ha editado el comentario',{icon: 'check', duration: 5000})
        this.reply.content = this.commentText
        this.showEditForm = false
        // this.$emit('fetchComments');
      })
      .catch( error => {
        this.$toasted.error('Hubo un error al editar el comentario',{icon: 'exclamation-triangle', duration: 5000})
      })
      .finally( () => {
        this.isLoading = false;
      })
    },
  }
}
</script>

<style>

</style>