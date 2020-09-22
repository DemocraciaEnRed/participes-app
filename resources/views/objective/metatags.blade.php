<!-- Primary Meta Tags -->
<title>{{$objective->title}} - {{app_setting('app_social_title',config('app.name', 'Laravel'))}}</title>
<meta name="title" content="{{$objective->title}} - {{app_setting('app_social_title',config('app.name', 'Laravel'))}}">
<meta name="description" content="¡Conocé acerca del objetivo y monitorealo entrando en Partícipes!">

<!-- Open Graph / Facebook -->
<meta property="og:type" content="website">
<meta property="og:url" content="{{route('objectives.index',['objectiveId' => $objective->id])}}">
<meta property="og:title" content="{{$objective->title}} - {{app_setting('app_social_title',config('app.name', 'Laravel'))}}">
<meta property="og:description" content="¡Conocé acerca del objetivo y monitorealo entrando en Partícipes!">
<meta property="og:image" content="{{URL::to('/')}}{{app_setting('app_social_image','/social-sharer.png')}}">

<!-- Twitter -->
<meta property="twitter:card" content="summary_large_image">
<meta property="twitter:url" content="{{route('objectives.index',['objectiveId' => $objective->id])}}">
<meta property="twitter:title" content="{{$objective->title}} - {{app_setting('app_social_title',config('app.name', 'Laravel'))}}">
<meta property="twitter:description" content="¡Conocé acerca del objetivo y monitorealo entrando en Partícipes!">
<meta property="twitter:image" content="{{URL::to('/')}}{{app_setting('app_social_image','/social-sharer.png')}}">