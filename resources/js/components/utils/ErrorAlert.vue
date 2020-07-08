<template>
  <div class="alert alert-danger" role="alert">
    <p class="mb-0">Hubo un error contactandose con la API. (Codigo {{error.status}} {{error.status.text}}) <small> <a @click="toggleShowMore" class="text-dark is-clickable">{{more ? 'Ocultar' : 'Ver'}}</a></small></p>
    <div class="alert alert-light code-alert mt-2 mb-0 p-2" v-if="more" role="alert">
    <pre class="mb-0"><code>{{error.data}}</code></pre>

    </div>
  </div>
</template>

<script>
export default {
  props: ['error'],
  data(){
    return {
      more: false
    }
  },
  methods: {
    toggleShowMore: function(){
      this.more = !this.more;
    }
  }
}
</script>

<style lang="scss" scoped>
.code-alert pre{
  font-size: 10px;
  line-height: normal;
}
</style>