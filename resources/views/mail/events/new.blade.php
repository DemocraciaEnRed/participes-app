@php
    $titleEncode = urlencode($event->title);
    $descriptionEncode = urlencode('Mas información: ' . route('events.index',['eventId' => $event->id]));
    $locationEncode = urlencode($event->address);
    $startTime = urlencode($event->date->format('Ymd\THis'));
    $endTime = urlencode($event->date->addHour()->format('Ymd\THis'));
    $ctz = urlencode('America/Argentina/Buenos_Aires');
@endphp

@component('mail::message')
# ¡Hola {{$user->name}}! 👋

Hay un nuevo evento en Partícipes 🗓️ y esta relacionado a un objetivo al que estas suscripto. ¡Creemos que te puede interesar participar! 🥳

El evento se llama **{{$event->title}}** y es el @justdate($event->date) a las @justtime($event->date). Te dejamos una breve descripción 👇

@component('mail::panel')
{{Str::limit($event->content, 150, $end=' [...]')}}
@endcomponent

@component('mail::button', ['url' => route('events.index', ['eventId' => $event->id])])
🔍 Ver mas información
@endcomponent 

¿Te gustaria agendarlo? 😀 ¡Hace clic en el siguiente link para agendarlo en tu google calendar! 

@component('mail::button', ['url' => 'https://calendar.google.com/calendar/r/eventedit?action=TEMPLATE&text='.$titleEncode.'&details='.$descriptionEncode.'&location='.$locationEncode.'&dates='.$startTime.'/'.$endTime.'&ctz='.$ctz])
📅 Agregar a Google Calendar 
@endcomponent

Muchas gracias, <br>
{{ config('app.name') }} 😉
@endcomponent
