<template>
  <section>
      <new-comment :url="commentUrl" :user="user" v-if="user" @fetchComments="fetchComments"></new-comment>
    <div v-if="isLoading">
      <div class="alert alert-light">
        <i class="fas fa-sync fa-spin"></i>&nbsp;Cargando comentarios
      </div>
    </div>
    <div v-else>
      <comment v-for="comment in comments" :key="`comment${comment.id}`" :comment="comment" :user="user" @fetchComments="fetchComments"></comment>
      <paginator v-if="paginatorData.links && !isFetching" :paginatorData="paginatorData" @updateData="updateData" />

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