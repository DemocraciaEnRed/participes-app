<template>
<div class="d-flex justify-content-between">
  <p v-if="!isFetching">Pagina {{paginatorData.meta.current_page }} de {{paginatorData.meta.last_page}}</p>
  <p v-else><i>Cargando...</i></p>
  <nav aria-label="Pagination">
    <ul class="pagination justify-content-end">
      <li class="page-item" :class="!paginatorData.links.prev && 'disabled'">
        <a class="page-link text-white" @click="fetchLink(paginatorData.links.prev)" tabindex="-1">Anterior</a>
      </li>
      <li class="page-item" :class="!paginatorData.links.next && 'disabled'">
        <a class="page-link text-white" @click="fetchLink(paginatorData.links.next)">Siguiente</a>
      </li>
    </ul>
  </nav>
</div>
</template>

<script>

export default {
  props: ['paginatorData'],
  data(){
    return {
      isFetching: false,
    }
  },
  methods: {
    fetchLink: function(link){
      if(!link) return
      this.isFetching = true;
      this.$http.get(link)
      .then( response => {
        this.$emit('updateData', response.data)
      })
      .catch( err => {
        this.$emit('error', err)
      })
      .finally( () => {
        this.isFetching = false;
      })
    }
  }
}
</script>

<style lang="scss" scoped>
.page-link:not(.disabled){
  cursor: pointer;  
}
</style>