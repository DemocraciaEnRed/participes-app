<!-- Primary Meta Tags -->
<title>{{$event->title}} - Partícipes - Monitoreo Ciudadano</title>
<meta name="title" content="{{$event->title}} - Partícipes - Monitoreo Ciudadano">
<meta name="description" content="{{Str::limit($event->content, 250, $end=' [...]')}}">

<!-- Open Graph / Facebook -->
<meta property="og:type" content="website">
<meta property="og:url" content="{{route('events.index',['eventId' => $event->id])}}">
<meta property="og:title" content="{{$event->title}} - Partícipes - Monitoreo Ciudadano">
<meta property="og:description" content="{{Str::limit($event->content, 250, $end=' [...]')}}">
<meta property="og:image" content="{{URL::to('/')}}/sharer01.png">

<!-- Twitter -->
<meta property="twitter:card" content="summary_large_image">
<meta property="twitter:url" content="{{route('events.index',['eventId' => $event->id])}}">
<meta property="twitter:title" content="{{$event->title}} - Partícipes - Monitoreo Ciudadano">
<meta property="twitter:description" content="{{Str::limit($event->content, 250, $end=' [...]')}}">
<meta property="twitter:image" content="{{URL::to('/')}}/sharer01.png">