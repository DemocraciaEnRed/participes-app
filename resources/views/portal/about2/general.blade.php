@extends('layouts.app')

@section('content')
@include('portal.about2.header')
@include('portal.about2.buttons')
<div id="about">
	<div id="about-one" class="container">
		<div class="row justify-content-center">
			<div class="col-lg-6 align-self-center column-text text-center text-lg-left">
				<h3 class="text-primary mb-3 ml-3 is-600">¿Que es<br>partícipes digital?</h3>
				<div class="bg-white pt-4 pb-4 px-3 custom-border">
					Es una plataforma de monitoreo ciudadano que te permite hacer seguimiento de objetivos y metas de gobiernos.
				</div>
				<br>
			</div>
			<div class="col-lg-6 column-picture">
				<img src="https://i.pinimg.com/originals/ab/91/4e/ab914e881da790a5b2eb0028ab1e9e4d.jpg" class="image is-centered shadow custom-border">
			</div>
		</div>
	</div>
	<div id="about-two" class="container">
		<div class="row justify-content-center">
			<div class="col-lg-5 column-picture">
				<img src="https://i.pinimg.com/originals/ab/91/4e/ab914e881da790a5b2eb0028ab1e9e4d.jpg" class="image is-centered shadow custom-border">
			</div>
			<div class="col-lg-7 align-self-center column-text text-center text-lg-right">
				<h3 class="text-primary mb-3 ml-3 is-600">¿Quienes somos <br>Partícipes Rosario?</h3>
				<div class="bg-white pt-4 pb-4 px-3 custom-border">
					Somos una red de organizaciones de la Ciudad de Rosario que creemos en la importancia de un gobierno abierto. Es por eso que relevamos políticas públicas en nuestra ciudad, apoyados en reportes constantes y organizados.
				</div>
				<br>
			</div>
		</div>
	</div>
	<div id="about-three" class="container text-center text-lg-left">
		<div class="row justify-content-center">
			<div class="col-lg-3">
				<h3 class="text-primary is-600">¿Cómo<br>participo?</h3>
			</div>
			<div class="col-lg-9 align-self-center">
				Partícipes digital está dirigido a organizaciones de la sociedad civil y ciudadanía interesada y comprometida en el monitoreo ciudadano de las problemáticas públicas de sus ciudades, con el fin de generar incidencia.
			</div>
		</div>
		<br>
		<div class="row justify-content-center">
			<div class="col-lg-4">
				<h3 class="text-info is-600 mb-3">01</h3>
				<p><b>Informate</b> sobre monitoreos de políticas públicas realizados por organizaciones de la sociedad civil y ciudadanía de forma sencilla y colaborativa.</p>
			</div>
			<div class="col-lg-4">
				<h3 class="text-info is-600 mb-3">02</h3>
				<p><b>Validá</b> la información sobre avances de metas o compromisos de gobierno, comentaá y sumate a comunidades temáticas.</p>

			</div>
			<div class="col-lg-4">
				<h3 class="text-info is-600 mb-3">03</h3>
				<p><b>Involucrate:</b> Conectate con otros actores de la sociedad civil y potencia tu capacidad de incidencia.</p>

			</div>
		</div>
	</div>
</div>
<div id="final-about" class="text-center text-lg-right">
	<div class="bg-white">
			<img src="https://laverdadonline.com/wp-content/uploads/2018/05/24-5-monumento.jpg" class="final-about-picture custom-border shadow image is-centered d-lg-none" alt="">
		<div class="container first-container">
			<div class="row justify-content-end">
				<div class="col-lg-6">
					<h3 class="text-primary is-600">Mas alla de la ciudad</h3>
				</div>
			</div>
		</div>
	</div>
	<div class="bg-primary">
		<div class="container second-container pt-4 pb-4 pb-lg-5">
			<div class="row justify-content-between">
				<div class="col-lg-5 d-none d-lg-block">
			<div class="picture-container">
			<img src="https://laverdadonline.com/wp-content/uploads/2018/05/24-5-monumento.jpg" class="img-fluid custom-border shadow" alt="">
			</div>
				</div>
				<div class="col-lg-6 text-white">
					sta plataforma surge del proyecto <b>Partícipes</b> de fortalecimiento de procesos de rendición de cuentas en </b>Córdoba, Buenos Aires, Rosario y Mendoza</b> a través del monitoreo ciudadano de políticas públicas, facilitado por el uso de herramientas tecnológicas y nuevos canales de comunicación. Este proyecto es coordinado por la Fundación Avina y es financiado por la Unión Europea.
				</div>
			</div>
		</div>
	</div>
</div>
@endsection