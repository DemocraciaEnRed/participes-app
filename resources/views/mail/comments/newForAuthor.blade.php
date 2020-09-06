@php
$avatarPath = isset($comment->user->avatar) ? ( $useThumbnail ? asset($comment->user->avatar->thumbnail_path) : asset($comment->user->avatar->path) ) : asset('img/default-avatar.png');    
@endphp

@component('mail::message')
# ¡Hola {{$user->name}}! 👋

Han hecho un nuevo comentario 💬 en tu reporte **{{$report->title}}** en Partícipes 

@component('mail::panel')
<img src="{{$avatarPath}}" style="height: 32px; margin-right: 10px; border-radius:32px; vertical-align:bottom;"/>  **{{$comment->user->fullname}}**  

{{Str::limit($comment->content, 200, $end=' [...]')}}
@endcomponent

Podes entrar al reporte hacienco clic en la web de Participes 👇

@component('mail::button', ['url' => route('reports.index', ['reportId' => $report->id])])
🔍 Ver reporte
@endcomponent

Muchas gracias, <br>
{{ config('app.name') }} 😉
@endcomponent
