@if($notification->data['type'] == 'new-report')
  @include('utils.notifications.newReport', ['notification' => $notification])
@else
  <p>-error-</p>
@endif