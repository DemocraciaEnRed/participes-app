<template>
  <section>
    <mapbox
      :access-token="accessToken"
      :map-options="mapOption"
      @map-init="mapInitialized"
      @map-load="mapLoaded"
    />
    <div class="alert alert-dark my-3" v-if="currentMarkers.length == 0 && !isLoading">
      <i class="fas fa-info-circle"></i>&nbsp; No hay reportes geolocalizados
    </div>
    <paginator class="mt-3" v-if="paginatorData.meta && paginatorData.meta.last_page > 1 && paginated" :paginatorData="paginatorData" @updateData="updateData" />
  </section>
</template>

<script>
import Mapbox from 'mapbox-gl-vue'

export default {
  props: {
    fetchUrl: {
      type: String,
      required: true,
    },
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
   paginated: {
     type: Boolean,
     default: true
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
      isLoading: true,
      reports: [],
      paginatorData: {
        links: null,
        meta: null,
      },
      currentMarkers: [],
    }
  },
  methods: {
    fetchReports: function(){
      this.isLoading = true
      this.$http.get(this.fetchUrl)
      .then( response => {
        this.reports = response.data.data
        this.paginatorData = {
            links: response.data.links,
            meta: response.data.meta
          }
        this.addMarkers();
      })
      .catch( error => {
        console.error(error)
      })
      .finally( () => {
        this.isLoading = false
      })
    },
    mapInitialized: function(map) {
      this.map = map
    },
    mapLoaded: function(map){
      this.fetchReports();
    },
    addMarkers: function(){
      if(this.currentMarkers.length){
        this.currentMarkers.forEach( marker => {
          marker.remove();
        })
      }
      this.currentMarkers = this.reports.map( report => {
        let el = document.createElement('div');
        el.className = 'report-marker';

        // create the popup
        let theHtml = `<div class="report-popup">`
        theHtml += `<p class="text-smaller text-muted mb-1"><i class="fas ${this.getReportIcon(report.type)} text-primary"></i>&nbsp;&nbsp;${report.type_label}</p>`
        theHtml += `<p class="report-title mb-3"><a href="${report.url}" class="text-primary" target="_blank">${report.title}</a></p>`
        theHtml += `<p class="text-smaller text-muted mb-0"><i class="far fa-comment"></i>&nbsp;${report.comments_count} comentarios<br><i class="far fa-thumbs-up"></i>&nbsp;${report.positive_testimonies_count} - <i class="far fa-clock"></i>&nbsp;${report.published_at}</p>`
        theHtml += `</div>`
        let popup = new mapboxgl.Popup({ offset: 25 }).setHTML(theHtml);

        let marker = new mapboxgl.Marker(el).setLngLat([report.map_long,report.map_lat]).setPopup(popup).addTo(this.map)
        return marker
      })
    },
    updateData: function(data){
      this.reports = data.data
      this.paginatorData = {
        links: data.links,
        meta: data.meta
      }
      this.addMarkers();
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