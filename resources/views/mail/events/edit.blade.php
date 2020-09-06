@php
    $titleEncode = urlencode($event->title);
    $descriptionEncode = urlencode('Mas información: ' . route('events.index',['eventId' => $event->id]));
    $locationEncode = urlencode($event->address);
    $startTime = urlencode($event->date->format('Ymd\THis'));
    $endTime = urlencode($event->date->addHour()->format('Ymd\THis'));
    $ctz = urlencode('America/Argentina/Buenos_Aires');
@endphp

@component('mail::message')
# ¡Atención {{$user->name}}! 👏👏

Han editado el evento **{{$event->title}}** en Partícipes 🗓️ y como estas suscripto a un objetivo relacionado con el evento, nos parecio oportuno avisarte. 😮

El evento se llevará a cabo el @justdate($event->date) a las @justtime($event->date). Te invitamos a que veas el evento editado en la web de Participes 👇

@component('mail::button', ['url' => route('events.index', ['eventId' => $event->id])])
🔍 Ver mas información
@endcomponent 

Si tenes que re-agendarlo en tu calendario, ¡No te preocupes! Te dejamos un práctico boton para que lo re-agendes en tu Google Calendar 👇

@component('mail::button', ['url' => 'https://calendar.google.com/calendar/r/eventedit?action=TEMPLATE&text='.$titleEncode.'&details='.$descriptionEncode.'&location='.$locationEncode.'&dates='.$startTime.'/'.$endTime.'&ctz='.$ctz])
📅 Agregar a Google Calendar 
@endcomponent

Muchas gracias, <br>
{{ config('app.name') }} 😉
@endcomponent