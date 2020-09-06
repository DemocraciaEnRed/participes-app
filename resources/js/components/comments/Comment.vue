<template>
  <section>
    <div class="media pl-3 mb-3 pr-3">
      <img :src="comment.user.avatar ? comment.user.avatar.thumbnail_path : '/img/default-avatar.png'" alt="" class="align-self-start mr-3 rounded-circle" style="width: 64px">
      <div class="media-body">
        <p class="text-smaller mb-0"><b>{{`${comment.user.name} ${comment.user.surname}`}}</b><span v-if="comment.author_member_objective" class="text-info">&nbsp;&nbsp;&nbsp;<i class="fas fa-shield-alt"></i> Equipo</span></p>
        <div class="animate__animated animate__flash mb-2" v-if="showConfirmDelete">
          <p class="mb-2 text-smaller">¿Esta seguro que quiere eliminar el comentario?</p>
          <button class="btn btn-outline-danger btn-sm" @click="deleteComment"><i class="fas fa-trash"></i>&nbsp;Eliminar</button>
          <button class="btn btn-outline-dark btn-sm" @click="toggleConfirmDelete">Cancelar</button>
        </div>
        <div class="animate__animated animate__flash mb-2" v-if="showEditForm">
          <div class="form-group mb-2">
            <textarea v-model="commentText" rows="2" class="form-control text-smaller" placeholder="Deje aquí su comentario..." :disabled="isLoading"></textarea>
          </div>
          <button class="btn btn-outline-primary text-smallest btn-sm" @click="submitEdit" v-if="!isLoading"><i class="fas fa-pencil-alt"></i>&nbsp;Guardar</button>
          <p class="text-smaller mb-0 animate__animated animate__flash animate__infinite text-primary" v-if="isLoading"><i class="fas fa-spin fa-sync"></i>&nbsp;Editando...</p>
        </div>
        <div v-show="!showConfirmDelete && !showEditForm">
          <!-- <p class="text-smaller mb-0"><i class="fas fa-shield-alt fa-fw"></i><b>{{`${comment.user.name} ${comment.user.surname}`}}</b></p> -->
          <p class="text-smaller my-1 nl2br">{{comment.content}}</p>
          <p class="text-smaller my-1 text-muted text-italicsbpo">Comentó {{comment.created_at}}<span v-if="comment.edited">&nbsp;(Editado, {{comment.updated_at}})</span></p>
          <p class="text-smaller mb-0" v-if="comment.replies.length"><a @click="toggleShowReplies" class="text-primary is-clickable"><i class="fas fa-chevron-down"></i>&nbsp;Respuestas <span class="badge badge-primary align-middle">{{comment.replies.length}}</span></a></p>
        </div>
      </div>
      <div class="ml-2" v-if="(comment.reply_url || comment.delete_url || comment.edit_url) && user.email_verified_at">
        <p class="text-center text-muted mb-1 mt-2" v-if="comment.reply_url"><a class="is-clickable link-light" @click="toggleShowReplyForm"><i class="fas fa-reply fa-fw"></i></a></p>
        <p class="text-center text-muted my-1" v-if="comment.edit_url"><a class="is-clickable link-light" @click="toggleShowEditForm"><i class="fas fa-pencil-alt fa-fw"></i></a></p>
        <p class="text-center text-muted my-1" v-if="comment.delete_url"><a class="is-clickable link-light" @click="toggleConfirmDelete"><i class="fas fa-times fa-fw"></i></a></p>
      </div>
    </div>
    <new-reply v-if="showReplyForm" :url="comment.reply_url" :user="user"></new-reply>
    <div v-if="showReplies">
      <reply v-for="theReply in comment.replies" :key="`reply${theReply.id}`" :reply="theReply" @fetchComments="fetchComments" :user="user"></reply>
    </div>
  </section>
</template>

<script>
import NewReply from './NewReply.vue'
import Reply from './Reply.vue'

export default {
  props: ['comment', 'user'],
  components: {
    NewReply,
    Reply
  },
  data(){
    return {
      showReplies: false,
      showReplyForm: false,
      showConfirmDelete: false,
      showReplyText: false,
      showEditForm: false,
      isLoading: false,
      sent: false,
      commentText: null
    }
  },
  mounted: function(){
    this.commentText = this.comment.content
  },
  methods: {
    toggleShowReplyForm: function(){
      this.showConfirmDelete = false
      this.showEditForm = false
      this.showReplyForm = !this.showReplyForm
    },
    toggleShowReplies: function(){
      this.showConfirmDelete = false
      this.showEditForm = false
      this.showReplies = !this.showReplies
    },
    toggleShowEditForm: function(){
      this.showConfirmDelete = false
      this.showEditForm = !this.showEditForm
    },
    toggleConfirmDelete: function(){
      this.showConfirmDelete = !this.showConfirmDelete
      this.showEditForm = false
    },
    deleteComment: function(){
      this.$http.delete(this.comment.delete_url)
      .then( response => {
        this.$toasted.success('Se ha eliminado el comentario',{icon: 'check', duration: 5000})
        this.$emit('fetchComments');
      })
      .catch( error => {
        this.$toasted.error('Hubo un error al eliminar el comentario',{icon: 'exclamation-triangle', duration: 5000})
      })
    },
    submitEdit: function(){
      this.isLoading = true;
      if(!this.commentText || !this.user) return
      this.$http.put(this.comment.edit_url,{
        content: this.commentText
      })
      .then( response => {
        this.$toasted.success('Se ha editado el comentario',{icon: 'check', duration: 5000})
        this.comment.content = this.commentText;
        this.showEditForm = false;
        // this.$emit('fetchComments');
      })
      .catch( error => {
        this.$toasted.error('Hubo un error al editar el comentario',{icon: 'exclamation-triangle', duration: 5000})
      })
      .finally( () => {
        this.isLoading = false;
      })
    },
    fetchComments: function(){
      this.$emit('fetchComments');
    }
  }
}
</script>

<style>

</style>