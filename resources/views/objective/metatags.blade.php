<!-- Primary Meta Tags -->
<title>{{$objective->title}} - Partícipes - Monitoreo Ciudadano</title>
<meta name="title" content="{{$objective->title}} - Partícipes - Monitoreo Ciudadano">
<meta name="description" content="¡Conocé acerca del objetivo y monitorealo entrando en Partícipes!">

<!-- Open Graph / Facebook -->
<meta property="og:type" content="website">
<meta property="og:url" content="{{route('objectives.index',['objectiveId' => $objective->id])}}">
<meta property="og:title" content="{{$objective->title}} - Partícipes - Monitoreo Ciudadano">
<meta property="og:description" content="¡Conocé acerca del objetivo y monitorealo entrando en Partícipes!">
<meta property="og:image" content="{{URL::to('/')}}/sharer01.png">

<!-- Twitter -->
<meta property="twitter:card" content="summary_large_image">
<meta property="twitter:url" content="{{route('objectives.index',['objectiveId' => $objective->id])}}">
<meta property="twitter:title" content="{{$objective->title}} - Partícipes - Monitoreo Ciudadano">
<meta property="twitter:description" content="¡Conocé acerca del objetivo y monitorealo entrando en Partícipes!">
<meta property="twitter:image" content="{{URL::to('/')}}/sharer01.png">