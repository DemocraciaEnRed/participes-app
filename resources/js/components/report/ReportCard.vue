<template>
  <div class="card shadow-sm border-secondary ml-0 ml-sm-3 mb-3">
    <div class="card-body text-secondary">
      <p class="mb-3 float-lg-right ml-lg-4  text-secondary text-right"><i class="text-primary" :class="`fas ${getReportIcon(report.type)}`"></i>&nbsp;{{report.type_label}}</p>
      <p class="text-smaller my-2"><i :class="`far fa-dot-circle text-${report.goal.status}`"></i>&nbsp;<a :href="report.goal.url" class="text-secondary">{{report.goal.title}}</a></p>
      <h5 class="is-700 my-2"><a :href="report.url" class="text-secondary">{{report.title}}</a></h5>
      <p class="text-smaller mb-0">{{shortString(report.content, 250)}}</p>
      <p class="text-muted text-smaller mt-1 mb-2">Publicado {{report.published_at}}</p>
      <h6 class="is-600" v-if="report.latest_comments.length">Ultimos comentarios&nbsp;&nbsp;<a :href="`${report.url}#comentarios`" class="text-smallest is-400">Ver todos<i class="fas fa-arrow-right fa-fw"></i></a></h6>
      <simple-comment v-for="comment in report.latest_comments" :key="comment.id" :comment="comment"></simple-comment>
      <div class="div d-flex justify-content-between mt-4">
        <div v-if="report.testimony === undefined">
          <a :href="loginUrl" class="btn btn-outline-success btn-sm my-1">Estoy de acuerdo&nbsp;<i class="fas fa-check"></i>&nbsp;{{report.positive_testimonies_count}}</a>
          <a :href="loginUrl" class="btn btn-outline-info btn-sm my-1">Quiero sumar información&nbsp;<i class="far fa-comment"></i>&nbsp;{{report.comments_count}}</a>
        </div>
        <div v-else>
          <button @click="toggleLike(report.testimony_url, $event)" class="btn btn-outline-success btn-sm my-1" v-if="report.testimony === null">Estoy de acuerdo&nbsp;<i class="fas fa-check"></i>&nbsp;{{report.positive_testimonies_count}}</button>
          <button @click="toggleLike(report.testimony_url, $event)" class="btn btn-success btn-sm my-1" v-else>Estoy de acuerdo&nbsp;<i class="fas fa-check"></i>&nbsp;{{report.positive_testimonies_count}}</button>
          <a :href="`${report.url}#comentarios`" class="btn btn-outline-info btn-sm my-1">Quiero sumar información&nbsp;<i class="far fa-comment"></i>&nbsp;{{report.comments_count}}</a>
        </div>
        <div>
          <a :href="report.url" class="btn btn-link btn-sm">Detalles<i class="fas fa-arrow-right fa-fw"></i></a>
        </div>
      </div>
    </div>
  </div>

</template>

<script>
import SimpleComment from './SimpleComment'

export default {
  props: ['report','loginUrl'],
  components: {
    SimpleComment
  },
  data(){
    return {

    }
  },
  methods: {
    toggleLike: function(url, event){
      event.target.disabled = true;
      this.$http.post(url)
      .then( response => {
        this.toggleLikeReport()
      })
      .catch( error => {
        this.$toasted.error('Ocurrio un error enviando tu feedback', {icon: 'exclamation-triangle'})
        console.error(error)
      })
      .finally( () => {
        event.target.disabled = false;
      })
    },
    toggleLikeReport: function(){
      if(this.report.testimony === null) {
        this.$toasted.success('¡Gracias por el feedback!', {icon: 'check'})
        this.report.positive_testimonies_count++
        this.report.testimony = {
          value: true
        };
      } else {
        this.$toasted.success('Tu feedback se elimino correctamente', {icon: 'check'})
        this.report.positive_testimonies_count--
        this.report.testimony = null
      }
    }
  }
}
</script>

<style>

</style>