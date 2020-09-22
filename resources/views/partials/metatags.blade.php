<!-- Primary Meta Tags -->
<title>{{app_setting('app_social_title',config('app.name', 'Laravel'))}}</title>
<meta name="title" content="{{app_setting('app_social_title',config('app.name', 'Laravel'))}}">
<meta name="description" content="{{app_setting('app_social_description')}}">

<!-- Open Graph / Facebook -->
<meta property="og:type" content="website">
<meta property="og:url" content="{{URL::to('/')}}">
<meta property="og:title" content="{{app_setting('app_social_title',config('app.name', 'Laravel'))}}">
<meta property="og:description" content="{{app_setting('app_social_description')}}">
<meta property="og:image" content="{{URL::to('/')}}{{app_setting('app_social_image','/social-sharer.png')}}">

<!-- Twitter -->
<meta property="twitter:card" content="summary_large_image">
<meta property="twitter:url" content="{{URL::to('/')}}">
<meta property="twitter:title" content="{{app_setting('app_social_title',config('app.name', 'Laravel'))}}">
<meta property="twitter:description" content="{{app_setting('app_social_description')}}">
<meta property="twitter:image" content="{{URL::to('/')}}{{app_setting('app_social_image','/social-sharer.png')}}">