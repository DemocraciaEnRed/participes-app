<template>
  <section>
    <div class="form-row">
      <div class="col">
        <div class="input-group">
          <div class="input-group-prepend">
            <span class="input-group-text">Etiqueta</span>
          </div>
          <input type="text"  class="form-control" v-model="inputLabel">
        </div>
        
      </div>
      <div class="col">
        <div class="input-group">
          <div class="input-group-prepend">
            <span class="input-group-text">https://</span>
          </div>
          <input type="text" class="form-control" v-model="inputUrl">
        </div>
      </div>
      <div class="col-auto">
        <a @click="addUrl" class="btn btn-primary text-white"><i class="fas fa-plus"></i></a>
      </div>
    </div>
    <input type="hidden" :name="`${name}[${label}]`" v-for="(url,label,i) in urlList" :key="`tag${i}`" :value="url">
    <div class="url-list mt-3 mb-3">
    <span class="url badge badge-primary" v-for="(url,label,i) in urlList" :key="`url${i}`">
      <span><i class="fas fa-link"></i>&nbsp;<a :href="url" class="text-white" target="_blank">{{label}}</a></span>
      <a @click="removeUrl(label)"><i class="fas fa-times"></i></a> 
    </span>
    </div>
  </section>
</template>

<script>
export default {
  props: {
    urls: {
      type: Object,
      required: false
    },
    name: {
      type: String,
      required: true
    },
  },
  data(){
    return {
      inputLabel: '',
      inputUrl: '',
      urlList: {}
    }
  },
  mounted: function(){
    console.log(this.urls)
    if(this.urls) this.urlList = Object.assign({}, this.urls)
  },
  methods: {
    addUrl: function(){
      if(this.inputUrl.length == 0) return
      if(this.inputLabel.length == 0) return
      let exists = Object.keys(this.urlList).some((k) => {
          return this.urlList[k] === `https://${this.inputUrl}`;
      });
      if(exists) {
        this.inputLabel = null;
        this.inputUrl = null;
        return false
      }
      this.urlList[this.inputLabel] = `https://${this.inputUrl}`;
      this.inputLabel = null;
      this.inputUrl = null;
      return true
    },
    removeUrl: function(index){
      let aux =  Object.assign({}, this.urlList);
      delete aux[index];
      this.$set(this, 'urlList', aux)
    }
  }
}
</script>

<style lang="scss" scoped>
.url {
  font-size: 14px;
  padding: 5px 8px;
  margin: 0px 8px 5px 0px
}
.url span a {
  opacity: 1.0;
}
.url a {
  cursor: pointer;
  opacity: 0.6;
}
.url a:hover {
  opacity: 1.0
}
.url .remove {
  vertical-align: bottom;
  top: 0;
}
.url a {
  margin: 0 0 0 .3em;
}
</style>