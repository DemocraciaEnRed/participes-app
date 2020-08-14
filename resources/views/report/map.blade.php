@if(!is_null($report->map_center))
  <div class="card shadow-sm mb-3">
    <div class="card-body p-3 p-lg-5">
      <h3 class="is-600 mb-3">Mapa del reporte</h3>
      <portal-report-map access-token="{{config('services.mapbox.key')}}" map-style="{{config('services.mapbox.style')}}" :lat="{{$report->map_lat}}" :long="{{$report->map_long}}" :zoom="{{$report->map_zoom}}" :init-collection="{{$report->map_geometries}}"></portal-report-map>
      
    </div>
  </div>
  @endif