<template>
<div>
  <div class="row">
    <div class="col col-12 col-md-auto">
      <div class="mb-3" v-show="!hasDataUrl">

        <croppa v-model="myCroppa"
          :width="300"
          :height="300"
          :file-size-limit="8*1024*1024"
          :quality="2"
          accept="image/jpeg"
          class="shadow-sm"
          placeholder="Haga clic en Cargar Imagen"
          :placeholder-font-size="12"
          :disabled="false"
          :prevent-white-space="true"
          :show-remove-button="false"
          :disable-click-to-choose="true"
          :disable-rotation="true"
          :zoom-speed="7"
          @file-size-exceed="handleCroppaFileSizeExceed"
          @file-type-mismatch="handleCroppaFileTypeMismatch"
          @image-remove="handleImageRemove"
        ></croppa>
      </div>
      <img :src="dataUrl" class="rounded-circle img-thumbnail shadow-sm mb-3" v-show="hasDataUrl" width="300" alt="">
    </div>
    <div class="col" v-if="!isLoading && !(success || error)">
      <div v-if="myCroppa && !myCroppa.hasImage() && !hasDataUrl" class="animate__animated animate__flash">
        <h5 class="font-weight-bold">1. Elija una foto</h5>
        <p>Debe ser una imagen JPG/JPEG, hasta un limite de 8 MB.</p>
        <button class="btn btn-light" @click="myCroppa.chooseFile()"><i class="fas fa-search"></i>&nbsp;Cargar imagen</button>
      </div>
      <div v-if="myCroppa && myCroppa.hasImage() && !hasDataUrl" class="animate__animated animate__flash">
        <h5 class="font-weight-bold">2. ¡Acomode su avatar!</h5>
        <p>Acomode la foto, puede hacer zoom y centrarlo.</p>
        <p>Cuando este conforme haga clic en <i class="fas fa-cut"></i>&nbsp;<b>Listo</b> o puede <i class="fas fa-trash"></i>&nbsp;<b>Descartar</b> la imagen y volver a comenzar.</p>
        <button class="btn btn-primary" @click="cropImage"><i class="fas fa-cut"></i>&nbsp;¡Listo!</button>
        <button class="btn btn-light" @click="myCroppa.remove()"><i class="fas fa-trash"></i>&nbsp;Descartar</button>
      </div>
      <div v-if="myCroppa && myCroppa.hasImage() && hasDataUrl" class="animate__animated animate__flash">
        <h6 class="font-weight-bold">3. ¡Ua-lá! ¿Que tal?</h6>
        <p>Si le gusta su nuevo avatar, haga clic en <i class="fas fa-upload"></i>&nbsp;<b>Subir avatar</b></p>
        <p>O puede volver a <i class="fas fa-cut"></i>&nbsp;<b>Cortar</b> la imagen o <i class="fas fa-trash"></i>&nbsp;<b>Descartar</b> y volver a comenzar</p>
        <button class="btn btn-primary" @click="submit"><i class="fas fa-upload"></i>&nbsp;Subir avatar</button>
        <button class="btn btn-light" @click="dataUrl = null"><i class="fas fa-cut"></i>&nbsp;Cortar</button>
        <button class="btn btn-light" @click="restartAll"><i class="fas fa-trash"></i>&nbsp;Descartar</button>
      </div>
      <br>
    </div>
    <div class="col" v-if="isLoading && !(success || error)">
      <div class="alert alert-light">
          <strong><i class="fas fa-sync fa-spin"></i>&nbsp;Cargando avatar...</strong>
      </div>

    </div>
    <div class="col" v-if="!isLoading && (success || error)">
      <div class="alert alert-success" v-if="success">
          <strong><i class="fas fa-check"></i>&nbsp;{{ success }}</strong>
      </div>
      <div class="alert alert-danger" v-if="error">
          <strong><i class="fas fa-times"></i>&nbsp;{{ error }}</strong>
      </div>
    </div>
  </div>
</div>
</template>

<script>
import Croppa from 'vue-croppa';

export default {
  props: ['formUrl','crsfToken'],
  components: {
  'croppa': Croppa.component
  },
  data(){
    return {

    myCroppa: null,
    dataUrl: null,
    success: false,
    error: false,
    isLoading: false
    }
  },
  methods: {
    cropImage: function(){
      this.dataUrl = this.myCroppa.generateDataUrl('image/jpeg', 0.8)
    },
    restartAll: function(){
      this.myCroppa.remove();
      this.dataUrl = null;
    },
    handleCroppaFileSizeExceed(){
      alert('Excede el tamaño maximo: 8MB')
    },
    handleCroppaFileTypeMismatch(){
      alert('Tipo de archivo no soportado, utilice imagenes .jpg o .jpeg')
    },
    handleImageRemove(){
      this.dataUrl = null;
    },
    submit() {
      if(!this.dataUrl) return true;
      this.isLoading = true
      var formData = new FormData();
      formData.append("_token", this.crsfToken);
      formData.append("avatar", this.dataUrl);
      this.$http.post(this.formUrl, formData, {
          headers: {
            'Content-Type': 'multipart/form-data'
          }
      }).then(response => {
        this.success = response.data.message 
      }).catch( err => {
        console.error(err)
        this.error = err.response.data.message
      }).finally( () => {
        this.isLoading = false;
      })
    }
  },
  computed: {
    hasDataUrl: function(){
      if(this.dataUrl != null) return true
      return false
    }
  }
}
</script>

<style>

</style>