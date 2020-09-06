@component('mail::message')
# ¡Hola {{$user->name}}! 👋

¡Felicidades! 🥳 Te han agregado como parte del equipo del objetivo **{{$objective->title}}**.

Tu nuevo rol en el equipo es de {{$role}}.

Podrás acceder al panel de administracion del objetivo entrando a *Mi panel / Mis objetivos*  o haciendo clic en el siguiente botón

@component('mail::button', ['url' => route('panel.objectives')])
🔍 Ver mis objetivos
@endcomponent 

Por último, te comentamos que automáticamente te hemos suscripto a las notificaciones del objetivo.

Muchas gracias, <br>
{{ config('app.name') }} 😉
@endcomponent
