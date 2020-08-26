<template>
  <div class="card rounded shadow-sm">
    <div class="card-body">
      <div class="d-flex align-items-center">
        <div class="mr-4 text-center d-none d-md-block">
          <p class="text-muted"><i  :class="`${report.type_icon} fa-lg text-primary`"></i><br>
          {{report.type_label}}</p>
        </div>
        <div class="w-100">
          <p class="mb-1 text-muted d-block d-md-none"><i  :class="`${report.type_icon} text-primary`"></i> {{report.type_label}}</p>
          <p class="my-1 text-smaller"><a :href="report.goal.url" class="text-dark"><i :class="`far fa-dot-circle text-${report.goal.status}`"></i> {{report.goal.title}}</a></p>
          <h5 class="my-1"><a :href="report.url" class="text-dark is-700">{{report.title}}</a></h5>
          <p class="m-0 text-muted text-smaller" v-if="report.tags && report.tags.length > 0">Tags: {{report.tags && report.tags.join(' / ')}}</p>
          <p class="m-0 text-muted text-smaller" v-else>Tags: Sin tags cargados</p>
          <p class="m-0 text-muted text-smaller">Publicado {{report.published_at}}</p>
          </div>
        <div class="mx-1 d-flex flex-column flex-md-row">
          <div class="text-center m-2" v-if="report.map_zoom">
            <span class="is-700 is-size-5"><i class="fas fa-map-marked-alt fa-fw text-primary"></i></span><br><span class="text-smaller">Mapeable</span>
          </div>
          <div class="text-center m-2">
            <span class="is-700 is-size-5"><i class="far fa-comments fa-fw text-primary"></i>&nbsp;{{report.comments_count}}</span><br><span class="text-smaller">Comentarios</span>
          </div>
          <div class="text-center m-2">
            <span class="is-700 is-size-5"><i class="fas fa-thumbs-up fa-fw text-primary"></i>&nbsp;{{report.positive_testimonies_count}}</span><br><span class="text-smaller">Feedbacks</span>
          </div>
        </div>
          <div class="ml-2 align-self-center">
            <a :href="report.url" class="text-primary"><i class="fas fa-2x fa-fw fa-arrow-alt-circle-right"></i></a>
          </div>
      </div>
    </div>
  </div>
</template>

<script>

export default {
  props: ['report'],
  data(){
    return {
      styles: {
        height: 45
      }
    }
  },
  components: {
    
  },
  computed: {
    
  }
}
</script>

<style>

</style>