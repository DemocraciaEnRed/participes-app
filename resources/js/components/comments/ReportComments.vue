<template>
  <section>
    <new-comment :url="commentUrl" :user="user" v-if="user" @fetchComments="fetchComments"></new-comment>
    <div v-if="isLoading">
      <div class="alert alert-light p-5 text-center">
        <i class="fas fa-sync fa-spin"></i>&nbsp;Cargando
      </div>
    </div>
    <div v-else>
      <comment v-for="comment in comments" :key="`comment${comment.id}`" :comment="comment" :user="user" @fetchComments="fetchComments"></comment>
      <div class="p-5 text-center" v-if="user && comments.length == 0">
          <h6 class="card-title mb-2"><i class="far fa-surprise"></i>&nbsp;¡El reporte no cuenta con comentarios!</h6>
          <p class="text-smaller mb-0">¡Sea el primero en dejar un comentario!</p>
      </div>
      <div class="p-5 text-center" v-if="!user && comments.length == 0">
        <h6 class="card-title mb-2"><i class="far fa-surprise"></i>&nbsp;¡Sea el primero en comentar!</h6>
        <p class="text-smaller mb-0">Inicie sesión para poder dejar un comentario en este reporte</p>
      </div>
      <paginator v-if="paginatorData.meta && paginatorData.meta.last_page > 1" :paginatorData="paginatorData" @updateData="updateData" />

    </div>
  </section>
</template>

<script>
import NewComment from './NewComment.vue'
import Comment from './Comment.vue'

export default {
  props: ['fetchUrl','commentUrl', 'user'],
  components: {
    NewComment,
    Comment
  },
  data(){
    return {
      isLoading: true,
      comments: [],
      paginatorData: {
        links: null,
        meta: null,
      },
    }
  },
  mounted: function(){
    this.fetchComments()
  },
  methods: {
    fetchComments: function(){
      this.isLoading = true
      this.$http.get(this.fetchUrl)
      .then( response => {
        this.comments = response.data.data
        this.paginatorData = {
            links: response.data.links,
            meta: response.data.meta
          }
      })
      .catch( error => {
        console.error(error)
      })
      .finally( () => {
        this.isLoading = false
      })
    },
    updateData: function(data){
      this.comments = data.data
      this.paginatorData = {
        links: data.links,
        meta: data.meta
      }
    }
  }
}
</script>

<style>

</style>