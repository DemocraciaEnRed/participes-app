<template>
  <section>
    <mapbox
      :access-token="accessToken"
      :map-options="mapOption"
      @map-init="mapInitialized"
    />
    <input type="hidden" name="map_lat" v-model.number="newLat">
    <input type="hidden" name="map_long" v-model.number="newLong">
    <input type="hidden" name="map_zoom" v-model.number="newZoom">
    <br>
    <button @click="submitNewPosition" class="btn btn-primary"><i class="fas fa-save"></i>&nbsp;Guardar</button>
    <button ref="submit" style="display:none;">Submit</button>
  </section>
</template>

<script>
import Mapbox from 'mapbox-gl-vue'

export default {
  props: {
   accessToken: {
     type: String,
     required: true
   },
   mapStyle: {
     type: String,
     required: true
   },
   lat: {
     type: Number,
     default: -36.13810,
   },
   long: {
     type: Number,
     default: -63.67392,
   },
   zoom: {
     type: Number,
     default: 4
   }
  },
  components: { Mapbox },
  data() {
    return {
      mapOption: {
        style: this.mapStyle,
        center: [this.long, this.lat],
        zoom: this.zoom,
      },
      map: null,
      newLat: this.lat,
      newLong: this.long,
      newZoom: this.zoom,
    }
  },
  methods: {
    mapInitialized: function(map) {
      this.map = map
    },
    submitNewPosition: function(){
      let center = this.map.getCenter()
      this.newLat = center.lat
      this.newLong = center.lng
      this.newZoom = this.map.getZoom().toFixed(2)
      this.$nextTick(() => {
        this.$refs.submit.click()
      })
    }
  },
}
</script>

<style lang="scss" scoped>
#map {
  width: 100%;
  height: 500px;
}
</style>