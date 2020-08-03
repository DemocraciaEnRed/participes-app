<template>
  <section>
    <mapbox
      :access-token="accessToken"
      :map-options="{
        style: mapStyle,
        center: [-63.67392, -36.13810],
        zoom: 4,
      }"
      @map-init="mapInitialized"
    />
    <br>
    <button @click="myothertest" class="btn btn-primary">Test</button>
  </section>
</template>

<script>
import Mapbox from 'mapbox-gl-vue'
import center from '@turf/center';
export default {
  props: ['accessToken' ,'mapStyle', 'initCollection'],
  components: { Mapbox },
  data() {
    return {
      map: null,
      draw: null,
      featureId: null
    }
  },
  methods: {
    mapInitialized: function(map) {
      this.map = map
      this.draw = new MapboxDraw({
        displayControlsDefault: false,
        controls:{
          point: true,
          line_string: true,
          polygon: true,
          trash: true
        }
      })
      map.addControl(this.draw)
      if(this.initCollection){
        this.draw.add(this.initCollection)
      }
      map.on('draw.create', (e) => {
        if(this.featureId){
          // this.draw.delete(this.featureId)
        } 
        // this.featureId = e.features[0].id
        console.log(e.features)
      });
    },
    myothertest: function(){
      console.log('help?')
      console.log(this.draw.getAll())
      console.log(center(this.draw.getAll()))
      let thecenter = center(this.draw.getAll())
      let marker = new mapboxgl.Marker()
      .setLngLat(thecenter.geometry.coordinates)
      .addTo(this.map);
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