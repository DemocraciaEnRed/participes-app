<template>
  <section>
    <input type="text"  class="form-control" v-model="inputTag" @keyup.enter="addTag" @keyup.188="addTagWithoutComma">
    <input type="hidden" :name="`${name}[]`" v-for="(tag,i) in tagList" :key="`tag${i}`" :value="tag">
    <small class="form-text text-muted mt-2">Escriba su tag y presione  <kbd>ENTER</kbd> o <kbd>,</kbd> para ingresar</small>
    <div class="tag-list mt-3 mb-3">
    <span class="tag badge badge-primary" v-for="(tag,i) in tagList" :key="`tag${i}`">
      <span>{{tag}}</span>
      <a @click="removeTag(i)"><i class="fas fa-times"></i></a> 
    </span>
    </div>
  </section>
</template>

<script>
export default {
  props: {
    tags: {
      type: Array,
      required: false
    },
    name: {
      type: String,
      required: true
    },
  },
  data(){
    return {
      inputTag: '',
      tagList: []
    }
  },
  mounted: function(){
    if(this.tags) this.tagList = this.tags
  },
  methods: {
    addTag: function(){
      if(this.inputTag.length == 0) return
      if(this.tagList.includes(this.inputTag)) {
        this.inputTag = null;
        return false
      }
      this.tagList.push(this.inputTag);
      this.inputTag = null;
      return true
    },
    addTagWithoutComma: function(){
      this.inputTag = this.inputTag.substring(0, this.inputTag.length - 1);
      if(this.inputTag.length == 0) return
      if(this.tagList.includes(this.inputTag)) {
        this.inputTag = null;
        return false
      }
      this.tagList.push(this.inputTag);
      this.inputTag = null;
      return true
    },
    removeTag: function(index){
      this.tagList.splice(index,1);
    }
  }
}
</script>

<style lang="scss" scoped>
.tag {
  font-size: 14px;
  padding: 5px 8px;
  margin: 0px 8px 5px 0px
}
.tag a {
  cursor: pointer;
  opacity: 0.6;
}
.tag a:hover {
  opacity: 1.0
}
.tag .remove {
  vertical-align: bottom;
  top: 0;
}
.tag a {
  margin: 0 0 0 .3em;
}
</style>