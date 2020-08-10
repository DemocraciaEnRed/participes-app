<template>
  <section>
    <div class="media pl-3 mb-3 pr-3">
      <img :src="comment.user.avatar ? comment.user.avatar.thumbnail_path : '/img/default-avatar.png'" alt="" class="align-self-start mr-3 rounded-circle" style="width: 64px">
      <div class="media-body">
        <p class="text-smaller mb-0"><i class="fas fa-shield-alt fa-fw"></i><b>{{`${comment.user.name} ${comment.user.surname}`}}</b></p>
        <div class="animate__animated animate__flash mb-2" v-if="showConfirmDelete">
          <p class="mb-2 text-smaller">¿Esta seguro que quiere eliminar el comentario?</p>
          <button class="btn btn-outline-danger btn-sm" @click="deleteComment"><i class="fas fa-trash"></i>&nbsp;Eliminar</button>
          <button class="btn btn-outline-dark btn-sm" @click="toggleConfirmDelete">Cancelar</button>
        </div>
        <div v-show="!showConfirmDelete">
          <!-- <p class="text-smaller mb-0"><i class="fas fa-shield-alt fa-fw"></i><b>{{`${comment.user.name} ${comment.user.surname}`}}</b></p> -->
          <p class="text-smaller mb-0">{{comment.content}}</p>
          <p class="text-smaller mb-1 text-muted text-italicsbpo">{{comment.created_at}}</p>
          <p class="text-smaller mb-0" v-if="comment.replies.length"><a @click="toggleShowReplies" class="text-primary is-clickable"><i class="fas fa-chevron-down"></i>&nbsp;Respuestas <span class="badge badge-primary align-middle">{{comment.replies.length}}</span></a></p>
        </div>
      </div>
      <div class="ml-2" v-if="comment.reply_url || comment.delete_url">
        <p class="text-center text-muted mb-1 mt-3" v-if="comment.reply_url"><a class="is-clickable link-light" @click="toggleShowReplyForm"><i class="fas fa-reply fa-fw"></i></a></p>
        <p class="text-center text-muted mb-1" v-if="comment.delete_url"><a class="is-clickable link-light" @click="toggleConfirmDelete"><i class="fas fa-times fa-fw"></i></a></p>
      </div>
    </div>
    <new-reply v-if="showReplyForm" :url="comment.reply_url" :user="user"></new-reply>
    <div v-if="showReplies">
      <reply v-for="theReply in comment.replies" :key="`reply${theReply.id}`" :reply="theReply" @fetchComments="fetchComments"></reply>
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
    }
  },
  methods: {
    toggleShowReplyForm: function(){
      this.showConfirmDelete = false
      this.showReplyForm = !this.showReplyForm
    },
    toggleShowReplies: function(){
      this.showConfirmDelete = false
      this.showReplies = !this.showReplies
    },
    toggleConfirmDelete: function(){
      this.showConfirmDelete = !this.showConfirmDelete
    },
    deleteComment: function(){
      this.$http.delete(this.comment.delete_url)
      .then( response => {
        this.$emit('fetchComments');
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