<template>
  <section>
    <div class="media my-2">
      <img :src="comment.user.avatar ? comment.user.avatar.thumbnail_path : '/img/default-avatar.png'" alt="" class="align-self-start mr-3 rounded-circle" style="width: 32px">
      <div class="media-body">
        <div class="p-3 bg-ultralight rounded">

        <p class="text-smaller mb-0"><i class="fas fa-shield-alt fa-fw"></i><b>{{`${comment.user.name} ${comment.user.surname}`}}</b></p>
        <div v-show="!showConfirmDelete">
          <p class="text-smallest m-0">{{comment.content}}</p>
          <p class="text-smallest m-0 text-muted text-italicsbpo">{{comment.created_at}} - {{comment.replies_count}} Respuestas</p>
        </div>
        </div>
      </div>
    </div>
  </section>
</template>

<script>
export default {
  props: ['comment'],
  data(){
    return {

    }
  },
  methods: {

  }
}
</script>

<style>

</style>