@switch($notification->data['type'])
  @case('new-goal')
    @include('utils.notifications.newGoal', ['notification' => $notification])
    @break
  @case('new-report')
    @include('utils.notifications.newReport', ['notification' => $notification])
    @break
  @case('new-event')
    @include('utils.notifications.newEvent', ['notification' => $notification])
    @break
  @case('edit-objective')
    @include('utils.notifications.editObjective', ['notification' => $notification])
    @break
  @case('edit-goal')
    @include('utils.notifications.editGoal', ['notification' => $notification])
    @break
  @case('edit-report')
    @include('utils.notifications.editReport', ['notification' => $notification])
    @break
  @case('edit-event')
    @include('utils.notifications.editEvent', ['notification' => $notification])
    @break
  @case('delete-objective')
    @include('utils.notifications.deleteObjective', ['notification' => $notification])
    @break
  @case('delete-goal')
    @include('utils.notifications.deleteGoal', ['notification' => $notification])
    @break
  @case('delete-report')
    @include('utils.notifications.deleteReport', ['notification' => $notification])
    @break
  @case('delete-event')
    @include('utils.notifications.deleteEvent', ['notification' => $notification])
    @break
  @case('join-team-objective')
    @include('utils.notifications.joinTeamObjective', ['notification' => $notification])
    @break
  @case('remove-team-objective')
    @include('utils.notifications.removeTeamObjective', ['notification' => $notification])
    @break
  @case('new-comment-report-for-author')
    @include('utils.notifications.newCommentAuthorReport', ['notification' => $notification])
    @break
  @case('new-comment-report-for-objective-team')
    @include('utils.notifications.newCommentTeamObjective', ['notification' => $notification])
    @break
  @case('new-reply-report')
    @include('utils.notifications.newReplyReport', ['notification' => $notification])
    @break
  @case('completed-goal-report')
    @include('utils.notifications.completedGoalReport', ['notification' => $notification])
    @break
  @default
    <p>-Error-</p>
    @break  
@endswitch