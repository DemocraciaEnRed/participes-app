<template>
  <mapbox
      :access-token="accessToken"
      :map-options="mapOption"
      @map-init="mapInitialized"
      @map-load="mapLoaded"
    />
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
    },
    initCollection: {
      type: Object
    }
  },
  data(){
    return {
      mapOption: {
        style: this.mapStyle,
        center: [this.long, this.lat],
        zoom: this.zoom,
      },
      map: null,
    }
  },
  methods: {
    mapInitialized: function(map) {
      this.map = map
    },
    mapLoaded: function(map){
      map.addSource('report-map', {
        'type': 'geojson',
        'data': this.initCollection
      })
      map.addLayer({
          'id': 'gl-draw-polygon-fill-inactive',
          'source': 'report-map',
          'type': 'fill',
          'filter': ['==', '$type', 'Polygon'],
          'paint': {
            'fill-color': '#3bb2d0',
            'fill-outline-color': '#3bb2d0',
            'fill-opacity': 0.15
          }
        });

      map.addLayer({
          'id': 'gl-draw-polygon-stroke-inactive',
          'type': 'line',
          'source': 'report-map',
          'filter': ['==', '$type', 'Polygon'],
          'layout': {
            'line-cap': 'round',
            'line-join': 'round'
          },
          'paint': {
            'line-color': '#3bb2d0',
            // 'line-dasharray': [0.5, 2],
            'line-width': 2.5
          }
        })
        
      map.addLayer({
          'id': 'gl-draw-line-inactive',
          'source': 'report-map',
          'type': 'line',
          'filter':  ['==', '$type', 'LineString'],
          'layout': {
            'line-cap': 'round',
            'line-join': 'round'
          },
          'paint': {
            'line-color': '#3bb2d0',
            'line-dasharray': [0.5, 2],
            'line-width': 2.5
          }
        })


      map.addLayer({

          'id': 'gl-draw-point-point-stroke-inactive',
          'source': 'report-map',
          'type': 'circle',
          'filter': ['==', '$type', 'Point'],
          'paint': {
            'circle-radius': 9,
            'circle-opacity': 1,
            'circle-color': '#fff'
          }
        })
        
      map.addLayer({
          'id': 'gl-draw-point-inactive',
          'source': 'report-map',
          'type': 'circle',
          'filter': ['==', '$type', 'Point'],
          'paint': {
            'circle-radius': 7,
            'circle-color': '#3bb2d0'
          }
        })
    }
  }
}
</script>

<style lang="scss" scoped>
#map {
  width: 100%;
  height: 500px;
}
</style>