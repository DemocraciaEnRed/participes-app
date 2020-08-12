<template>
  <div class="section" v-if="!isLoading">
      <objective-card class="my-3" v-for="objective in objectives" :key="`objective${objective.id}`" :objective="objective"></objective-card>
      <section class="p-5 text-center" v-if="objectives.length == 0">
        <i class="fas fa-info-circle"></i>&nbsp; No hay objetivos cargados en la plataforma
      </section>
  </div>
  <section class="p-5 text-center" v-else>
    <i class="fas fa-sync fa-spin"></i> Cargando...
  </section>
</template>

<script>
import ObjectiveCard from './ObjectiveCard'
export default {
  props: {
    fetchUrl: {
      type: String,
      required: true
    }
  },
  components: {
    ObjectiveCard
  },
  data() {
    return {
      isLoading: true,
      objectives: [],
      paginatorData: {
        links: null,
        meta: null,
      },
    }
  },
  beforeMount: function(){
    this.fetchObjectives();
  },
  methods: {
    fetchObjectives: function(){
      this.isLoading = true
      this.$http.get(this.fetchUrl)
      .then( response => {
        this.objectives = response.data.data
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
  },
}
</script>

<style>

</style>