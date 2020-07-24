<template>
<section>
  <div class="form-group" v-for="inputKey in inputFieldKeys" :key="inputKey">
    <div class="input-group" v-show="!inputFieldKeysHidden.includes(inputKey)">
      <div class="custom-file" v-if="!inputFieldKeysDeleted.includes(inputKey)">
        <input type="file" class="custom-file-input" :name="`${name}`" :accept="accept" :id="`fileLoader${name}`" @change="handleFileChange">
        <label class="custom-file-label" :for="`fileLoader${name}`">
          <span v-show="inputCount == 1">Haga clic para agregar un archivo</span>
          <span v-show="inputCount > 1">Haga clic para agregar otro archivo</span>
        </label>
        <!-- <input type="file" class="custom-file-input" :name="`${name}`" id="fileLoader${name}" > -->
      </div>
    </div>
  </div>
  <div class="form-group" v-if="theFiles.length">
    <p v-for="(file,i) in theFiles" class="d-flex justify-content-between mb-1" :key="`file${i}`">
      <span><i class="far fa-file text-primary fa-lg"></i> {{file.name}}&nbsp;&nbsp;<span class="text-smallest text-muted">{{formatBytes(file.size,2)}}</span></span>
      <a @click="deyeet(file.id)" class="text-danger is-clickable"><i class="fas fa-times"></i></a>
      </p>
      <p class="text-smaller mb-1" v-if="isMultiple">Cantidad de archivos: {{theFiles.length}} - Tamaño total: {{formatBytes(totalSize,2)}}</p>
  </div>
</section>
</template>

<script>
export default {
  props: ['name','multiple','accept'],
  data(){
    return {
      theFiles: [],
      inputCount: 1,
      inputFieldKeys: ['inputField1'],
      inputFieldKeysHidden: [],
      inputFieldKeysDeleted: []
    }
  },
  methods: {
    handleFileChange: function(e){
      let fileData = {
        id: this.inputCount,
        name: e.target.files[0].name,
        size: e.target.files[0].size
      }
      if(this.isMultiple){
        this.theFiles.push(fileData)
        this.inputFieldKeysHidden.push(`inputField${this.inputCount}`)
        this.inputCount++
        this.inputFieldKeys.push(`inputField${this.inputCount}`)
      } else {
        this.inputFieldKeysHidden.push(`inputField${this.inputCount}`)
        this.theFiles = [fileData]
      }
      // console.log(e.target.files)
    },
    deyeet: function(id){
        this.theFiles = this.theFiles.filter( f => {
          return f.id != id
        })
      if(this.isMultiple){
        this.inputFieldKeysDeleted.push(`inputField${id}`)
      } else {
        this.inputFieldKeysHidden = []
      }
    },
    formatBytes: function(bytes, decimals = 2) {
        if (bytes === 0) return '0 Bytes';

        const k = 1024;
        const dm = decimals < 0 ? 0 : decimals;
        const sizes = ['Bytes', 'KB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB'];

        const i = Math.floor(Math.log(bytes) / Math.log(k));

        return parseFloat((bytes / Math.pow(k, i)).toFixed(dm)) + ' ' + sizes[i];
    }
  },
  computed: {
    isMultiple: function(){
      if(this.multiple != undefined){
        return true
      }
      return false
    },
    totalSize: function(){
      if(this.theFiles.length == 0){
        return 0
      }
      const reducer = (accumulator, file) => accumulator + file.size;
      return this.theFiles.reduce(reducer,0)
    }
  }
}
</script>

<style lang="scss" scoped>

</style>