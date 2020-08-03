<template>
  <section>
    <mapbox
      :access-token="accessToken"
      :map-options="mapOption"
      @map-init="mapInitialized"
    />
    <input type="hidden" name="map_center" v-model="newMapCenter">
    <input type="hidden" name="map_geometries" v-model="newMapGeometries">
    <input type="hidden" name="map_zoom" v-model.number="newZoom">
    <input type="hidden" name="map_lat" v-model.number="newLat">
    <input type="hidden" name="map_long" v-model.number="newLong">
    <br>
    <button type="button" @click="submitNewPosition" class="btn btn-primary"><i class="fas fa-save"></i>&nbsp;Guardar</button>
    <button type="button" v-if="initCollection != null" @click="cleanMap" class="btn btn-light"><i class="fas fa-trash"></i>&nbsp;Eliminar mapa</button>
    <button ref="submit" style="display:none;">Submit</button>
  </section>
</template>

<script>
import Mapbox from 'mapbox-gl-vue'
import center from '@turf/center';
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

  components: { Mapbox },
  data() {
    return {
      mapOption: {
        style: this.mapStyle,
        center: [this.long, this.lat],
        zoom: this.zoom,
      },
      map: null,
      draw: null,
      newLat: this.lat,
      newLong: this.long,
      newZoom: this.zoom,
      newMapCenter: null,
      newMapGeometries: null,
      theStyles: [
        {
          'id': 'gl-draw-polygon-fill-inactive',
          'type': 'fill',
          'filter': ['all',
            ['==', 'active', 'false'],
            ['==', '$type', 'Polygon'],
            ['!=', 'mode', 'static']
          ],
          'paint': {
            'fill-color': '#3bb2d0',
            'fill-outline-color': '#3bb2d0',
            'fill-opacity': 0.15
          }
        },
        {
          'id': 'gl-draw-polygon-fill-active',
          'type': 'fill',
          'filter': ['all', ['==', 'active', 'true'], ['==', '$type', 'Polygon']],
          'paint': {
            'fill-color': '#fbb03b',
            'fill-outline-color': '#fbb03b',
            'fill-opacity': 0.2
          }
        },
        {
          'id': 'gl-draw-polygon-midpoint',
          'type': 'circle',
          'filter': ['all',
            ['==', '$type', 'Point'],
            ['==', 'meta', 'midpoint']],
          'paint': {
            'circle-radius': 5,
            'circle-color': '#fbb03b'
          }
        },
        {
          'id': 'gl-draw-polygon-stroke-inactive',
          'type': 'line',
          'filter': ['all',
            ['==', 'active', 'false'],
            ['==', '$type', 'Polygon'],
            ['!=', 'mode', 'static']
          ],
          'layout': {
            'line-cap': 'round',
            'line-join': 'round'
          },
          'paint': {
            'line-color': '#3bb2d0',
            // 'line-dasharray': [0.5, 2],
            'line-width': 2.5
          }
        },
        {
          'id': 'gl-draw-polygon-stroke-active',
          'type': 'line',
          'filter': ['all', ['==', 'active', 'true'], ['==', '$type', 'Polygon']],
          'layout': {
            'line-cap': 'round',
            'line-join': 'round'
          },
          'paint': {
            'line-color': '#fbb03b',
            'line-dasharray': [0.5, 2],
            'line-width': 2.5
          }
        },
        {
          'id': 'gl-draw-line-inactive',
          'type': 'line',
          'filter': ['all',
            ['==', 'active', 'false'],
            ['==', '$type', 'LineString'],
            ['!=', 'mode', 'static']
          ],
          'layout': {
            'line-cap': 'round',
            'line-join': 'round'
          },
          'paint': {
            'line-color': '#3bb2d0',
            'line-dasharray': [0.5, 2],
            'line-width': 2.5
          }
        },
        {
          'id': 'gl-draw-line-active',
          'type': 'line',
          'filter': ['all',
            ['==', '$type', 'LineString'],
            ['==', 'active', 'true']
          ],
          'layout': {
            'line-cap': 'round',
            'line-join': 'round'
          },
          'paint': {
            'line-color': '#fbb03b',
            'line-dasharray': [0.5, 2],
            'line-width': 2.5
          }
        },
        {
          'id': 'gl-draw-polygon-and-line-vertex-stroke-inactive',
          'type': 'circle',
          'filter': ['all',
            ['==', 'meta', 'vertex'],
            ['==', '$type', 'Point'],
            ['!=', 'mode', 'static']
          ],
          'paint': {
            'circle-radius': 7,
            'circle-color': '#fff'
          }
        },
        {
          'id': 'gl-draw-polygon-and-line-vertex-inactive',
          'type': 'circle',
          'filter': ['all',
            ['==', 'meta', 'vertex'],
            ['==', '$type', 'Point'],
            ['!=', 'mode', 'static']
          ],
          'paint': {
            'circle-radius': 5,
            'circle-color': '#fbb03b'
          }
        },
        {
          'id': 'gl-draw-point-point-stroke-inactive',
          'type': 'circle',
          'filter': ['all',
            ['==', 'active', 'false'],
            ['==', '$type', 'Point'],
            ['==', 'meta', 'feature'],
            ['!=', 'mode', 'static']
          ],
          'paint': {
            'circle-radius': 9,
            'circle-opacity': 1,
            'circle-color': '#fff'
          }
        },
        {
          'id': 'gl-draw-point-inactive',
          'type': 'circle',
          'filter': ['all',
            ['==', 'active', 'false'],
            ['==', '$type', 'Point'],
            ['==', 'meta', 'feature'],
            ['!=', 'mode', 'static']
          ],
          'paint': {
            'circle-radius': 7,
            'circle-color': '#3bb2d0'
          }
        },
        {
          'id': 'gl-draw-point-stroke-active',
          'type': 'circle',
          'filter': ['all',
            ['==', '$type', 'Point'],
            ['==', 'active', 'true'],
            ['!=', 'meta', 'midpoint']
          ],
          'paint': {
            'circle-radius': 9,
            'circle-color': '#fff'
          }
        },
        {
          'id': 'gl-draw-point-active',
          'type': 'circle',
          'filter': ['all',
            ['==', '$type', 'Point'],
            ['!=', 'meta', 'midpoint'],
            ['==', 'active', 'true']],
          'paint': {
            'circle-radius': 7,
            'circle-color': '#fbb03b'
          }
        },
        {
          'id': 'gl-draw-polygon-fill-static',
          'type': 'fill',
          'filter': ['all', ['==', 'mode', 'static'], ['==', '$type', 'Polygon']],
          'paint': {
            'fill-color': '#404040',
            'fill-outline-color': '#404040',
            'fill-opacity': 0.1
          }
        },
        {
          'id': 'gl-draw-polygon-stroke-static',
          'type': 'line',
          'filter': ['all', ['==', 'mode', 'static'], ['==', '$type', 'Polygon']],
          'layout': {
            'line-cap': 'round',
            'line-join': 'round'
          },
          'paint': {
            'line-color': '#404040',
            'line-width': 2
          }
        },
        {
          'id': 'gl-draw-line-static',
          'type': 'line',
          'filter': ['all', ['==', 'mode', 'static'], ['==', '$type', 'LineString']],
          'layout': {
            'line-cap': 'round',
            'line-join': 'round'
          },
          'paint': {
            'line-color': '#404040',
            'line-width': 2
          }
        },
        {
          'id': 'gl-draw-point-static',
          'type': 'circle',
          'filter': ['all', ['==', 'mode', 'static'], ['==', '$type', 'Point']],
          'paint': {
            'circle-radius': 5,
            'circle-color': '#404040'
          }
        }
      ]
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
        },
        styles: this.theStyles 
      })
      map.addControl(this.draw)
      if(this.initCollection){
        this.draw.add(this.initCollection)
      }
      map.on('draw.create', (e) => {
        console.log(e.features)
      });
    },
    submitNewPosition: function(){
      let collection = this.draw.getAll();
      if(collection.features.length == 0){
        this.cleanMap()
        return;
      }
      let theCenter = center(collection)
      this.newLong = theCenter.geometry.coordinates[0]
      this.newLat = theCenter.geometry.coordinates[1]
      this.newZoom = this.map.getZoom().toFixed(2);
      this.newMapCenter = JSON.stringify(theCenter)
      this.newMapGeometries = JSON.stringify(collection)
      this.$nextTick(() => {
        this.$refs.submit.click()
      })
    },
    cleanMap: function(){
      this.newLong = null
      this.newLat = null
      this.newZoom = null
      this.newMapCenter = null
      this.newMapGeometries = null
      this.$nextTick(() => {
        this.$refs.submit.click()
      })
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