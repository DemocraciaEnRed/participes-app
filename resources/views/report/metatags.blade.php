<!-- Primary Meta Tags -->
<title>{{$report->title}} - {{app_setting('app_social_title',config('app.name', 'Laravel'))}}</title>
<meta name="title" content="{{$report->title}} - {{app_setting('app_social_title',config('app.name', 'Laravel'))}}">
<meta name="description" content="{{Str::limit($report->content, 250, $end=' [...]')}}">

<!-- Open Graph / Facebook -->
<meta property="og:type" content="website">
<meta property="og:url" content="{{route('reports.index',['reportId' => $report->id])}}">
<meta property="og:title" content="{{$report->title}} - {{app_setting('app_social_title',config('app.name', 'Laravel'))}}">
<meta property="og:description" content="{{Str::limit($report->content, 250, $end=' [...]')}}">
<meta property="og:image" content="{{URL::to('/')}}{{app_setting('app_social_image','/social-sharer.png')}}">

<!-- Twitter -->
<meta property="twitter:card" content="summary_large_image">
<meta property="twitter:url" content="{{route('reports.index',['reportId' => $report->id])}}">
<meta property="twitter:title" content="{{$report->title}} - {{app_setting('app_social_title',config('app.name', 'Laravel'))}}">
<meta property="twitter:description" content="{{Str::limit($report->content, 250, $end=' [...]')}}">
<meta property="twitter:image" content="{{URL::to('/')}}{{app_setting('app_social_image','/social-sharer.png')}}">