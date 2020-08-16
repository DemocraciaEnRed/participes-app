<!-- Primary Meta Tags -->
<title>{{$goal->title}} - Partícipes - Monitoreo Ciudadano</title>
<meta name="title" content="{{$goal->title}} - Partícipes - Monitoreo Ciudadano">
<meta name="description" content="Esta meta es parte del objetivo '{{$objective->title}}'. ¡Conocé mas acerca de la meta entrando en Partícipes!">

<!-- Open Graph / Facebook -->
<meta property="og:type" content="website">
<meta property="og:url" content="{{route('goals.index',['goalId' => $goal->id])}}">
<meta property="og:title" content="{{$goal->title}} - Partícipes - Monitoreo Ciudadano">
<meta property="og:description" content="Esta meta es parte del objetivo '{{$objective->title}}'. ¡Conocé mas acerca de la meta entrando en Partícipes!">
<meta property="og:image" content="{{URL::to('/')}}/sharer01.png">

<!-- Twitter -->
<meta property="twitter:card" content="summary_large_image">
<meta property="twitter:url" content="{{route('goals.index',['goalId' => $goal->id])}}">
<meta property="twitter:title" content="{{$goal->title}} - Partícipes - Monitoreo Ciudadano">
<meta property="twitter:description" content="Esta meta es parte del objetivo '{{$objective->title}}'. ¡Conocé mas acerca de la meta entrando en Partícipes!">
<meta property="twitter:image" content="{{URL::to('/')}}/sharer01.png">