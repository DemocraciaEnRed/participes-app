@if($notification->data['type'] == 'new-report')
  @include('utils.notifications.newReport', ['notification' => $notification])
@elseif($notification->data['type'] == 'edit-goal')
  @include('utils.notifications.editGoal', ['notification' => $notification])
@else
  <p>-error-</p>
@endif