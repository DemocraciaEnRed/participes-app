@component('mail::message')
# ¡Atención {{$user->name}}! 👏👏

Tenemos que informarte que han **eliminado** el objetivo **{{$objective->title}}** en Partícipes.

Como estas suscripto al objetivo, nos parecio importante avisarte. 😮

Muchas gracias, <br>
{{ config('app.name') }} 😉
@endcomponent