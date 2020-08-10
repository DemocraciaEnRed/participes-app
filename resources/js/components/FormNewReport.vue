<template>
  <form :action="formUrl" method="POST" enctype="multipart/form-data">
				<h5 class="text-center mb-4 animate__animated animate__flash animate__slow">¿Que tipo de reporte va a crear?</h5>
		<ul class="nav nav-tabs justify-content-center">
			<li class="nav-item">
				<a class="nav-link text-primary is-clickable" @click="type = 'post'" :class="type == 'post' && 'active font-weight-bold'"><i class="fas fa-bullhorn"></i>&nbsp;&nbsp;Novedad</a>
			</li>
			<li class="nav-item">
				<a class="nav-link text-primary is-clickable" @click="type = 'progress'" :class="type == 'progress' && 'active font-weight-bold'"><i class="fas fa-fast-forward"></i>&nbsp;&nbsp;Avance</a>
			</li>
			<li class="nav-item">
				<a class="nav-link text-primary is-clickable" @click="type = 'milestone'" :class="type == 'milestone' && 'active font-weight-bold'"><i class="fas fa-medal"></i>&nbsp;&nbsp;Hito</a>
			</li>
		</ul>
		<input type="hidden" name="type" :value="type">
		<br>
		<section class="animate__animated animate__fadeIn" v-if="type">
			<div class="alert alert-light d-flex">
				<div class="mr-3">
					<i v-show="type == 'post'" class="mt-1 animate__animated animate__rubberBand fas fa-bullhorn fa-2x fa-fw"></i>
					<i v-show="type == 'progress'" class="mt-1 animate__animated animate__rubberBand fas fa-fast-forward fa-2x fa-fw"></i>
					<i v-show="type == 'milestone'" class="mt-1 animate__animated animate__rubberBand fas fa-medal fa-2x fa-fw"></i>
				</div>
				<div>
					<h5 class="">Un reporte de <span class="font-weight-bold">{{typeLabel}}</span></h5>
					<strong>Heads up!</strong> This <a href="#" class="alert-link">alert needs your attention</a>, but it's not super important.
				</div>
			</div>
			<div class="form-group">
				<label>Titulo del reporte</label>
				<input type="text" name="title" class="form-control" placeholder="" />
			</div>
			<div class="form-group">
      	<label>Descripción del reporte</label>
      	<textarea name="content" class="form-control" rows="4"></textarea>
				<!-- <text-editor name="content"/> -->
    	</div>
			<div class="form-group">
				<label>Tags del reporte</label>
				<input-tag name="tags" />
			</div>
			<div class="form-row">
      	<div class="col">
					<div class="form-group">
						<label>Fecha del reporte</label>
						<input name="date" type="date" class="form-control" />
          	<small class="form-text text-muted">Fecha en que ocurre el reporte. No puede ser una fecha futura.</small>
					</div>
				</div>
				<div class="col">
					<div class="form-group">
						<label>Nuevo estado de la meta</label>
							<div class="form-group">
								<select class="custom-select" name="status">
										<option value="" selected>- Mantener estado "{{statusLabel}}" -</option>
									 	<option v-if="goal.status != 'ongoing'" value="ongoing">En progreso</option>
										<option v-if="goal.status != 'delayed'" value="delayed" >Demorada</option>
										<option v-if="goal.status != 'inactive'" value="inactive" >Inactiva</option>
										<option v-if="goal.status != 'reached'" value="reached" disabled>Alcanzada</option>
								</select>
	          	<small class="form-text text-muted">Si el reporte indica un nuevo estado de la meta, puede definirlo aqui, si la meta no cambia su estado, puede dejarlo en "Mantener el estado"</small>
							</div>
          	<small class="form-text text-muted"></small>
					</div>
				</div>
			</div>
			<section v-if="type == 'progress'">
				<div class="form-group">
					<label>Avance de la meta</label>
					<p class="text-muted">Defina cuantas unidades de {{goal.indicator_unit}} se agrega al progreso de la meta</p>
					<div class="form-row">
						<div class="col-md-10">
      				<input type="range" class="custom-range mt-2" v-model.number="rangeInput" min="0" :max="goal.indicator_goal - goal.indicator_progress">
						</div>
						<div class="col-md-2">
      				<input type="number" class="form-control" name="progress" v-model.number="rangeInput" min="0">
						</div>
					</div>
				</div>
				<div class="row mb-3">
						<div class="col">
							<div class="card">
								<div class="card-body text-center">
								<h4 class="card-title text-primary font-weight-bold">{{progressNow}}%</h4>
								<h6 class="card-subtitle">Porcentaje actual de la meta</h6> 
								</div>
							</div>
						</div>
						<div class="col">
							<div class="card">
								<div class="card-body text-center">
								<h4 class="card-title text-info font-weight-bold">{{progressPercentage}}%</h4>
								<h6 class="card-subtitle">Porcentaje del avance</h6> 
								</div>
							</div>
						</div>
						<div class="col">
							<div class="card">
								<div class="card-body text-center">
								<h4 class="card-title text-primary font-weight-bold">{{progressTotal}}%</h4>
								<h6 class="card-subtitle">Porcentaje nuevo de la meta</h6> 
								</div>
							</div>
						</div>
					</div>
					<div class="alert alert-warning" v-if="rangeInput <= 0">
						<i class="fas fa-exclamation-triangle fa-fw"></i>&nbsp;¡No puede crear un reporte de avance y que el avance sea 0 o negativo!
					</div>
					<div class="alert alert-info" v-if="progressTotal > 100">
						<i class="fas fa-info-circle fa-fw"></i>&nbsp;<b>¡Atencion!</b> Esta por sobrepasar el 100% de la meta. Esté seguro que es lo que desea.
					</div>
			</section>
			<section v-if="type == 'milestone'">
				<div class="form-group">
					<label>¿En que fecha se alcanzó el hito?</label>
						<input name="milestone_date" type="date" class="form-control" />
          	<small class="form-text text-muted">Si la fecha en que el hito se alcanzó es distinta a la fecha del reporte, por favor, ingrese la fecha aquí. De no definirla, se define la fecha de hito alcanzado la misma fecha que el reporte.</small>
				</div>
				<div class="form-group">
					<label>Hito que se ha alcanzado</label>
					<div class="custom-control custom-radio" v-for="(milestone,i) in milestones" :key="`milestone${i}`">
						<input type="radio" :id="`radio${i}`" name="milestone" :value="milestone.id" class="custom-control-input" :disabled="milestone.completed">
						<label class="custom-control-label" :for="`radio${i}`">Hito #{{milestone.order}}: {{milestone.title}} <small class="text-success" v-show="milestone.completed">(Completado)</small></label>
					</div>
				</div>
			</section>
			<div class="form-group">
				<label>Album de fotos del reporte</label>
				<p class="form-text text-muted">Las fotos se verán en formato de album. En el reporte, tendran su previsualización. Ingrese solamente archivos en formato .JPG, .JPEG o .PNG, </p>
				<input-file name="photos[]" multiple accept="image/*"></input-file>
			</div>
			<div class="form-group">
				<label>Repositorio de archivos del reporte</label>
				<p class="form-text text-muted">Nota: A diferencia de las fotos del reporte, estas no se presentan con previsualizaciones.</p>
				<input-file name="files[]" multiple></input-file>
			</div>
			<br>
			<div class="form-group">
				<input type="hidden" name="_token" :value="crsfToken" />
				<button type="submit" class="btn btn-sm btn-primary">Crear reporte</button>
			</div>
		</section>
  </form>
</template>

<script>
// import debounce from "lodash/debounce";
// import TextEditor from "./inputs/TextEditor.vue"
import InputFile from "./inputs/InputFile.vue"
import InputTag from "./inputs/InputTag.vue"

export default {
  props: ["formUrl", "crsfToken", "goal", "objective", "milestones"],
	components: {
		// TextEditor,
		InputFile,
		InputTag
	},
  data() {
    return {
			type: null,
			rangeInput: 0
		};
  },
  mounted() {},
  methods: {},
	computed: {
		typeLabel: function(){
			if(!this.type) return ''
			switch(this.type){
				case 'post':
					return 'Novedad'
				case 'progress':
					return 'Avance'
				case 'milestone':
					return 'Hito'
			}
		},
		statusLabel: function(){
			if(!this.goal.status) return ''
			switch(this.goal.status){
				case 'ongoing':
					return 'En progreso'
				case 'delayed':
					return 'Demorada'
				case 'inactive':
					return 'Inactiva'
				case 'reached':
					return 'Alcanzada'
			}
		},
		progressNow: function(){
			return ((this.goal.indicator_progress / this.goal.indicator_goal)*100).toFixed()
		},
		progressPercentage: function(){
			if(this.rangeInput <= 0) return 0
			return ((this.rangeInput / this.goal.indicator_goal)*100).toFixed()
		},
		progressTotal: function(){
			if(this.rangeInput <= 0) return this.progressNow
			return (((this.goal.indicator_progress + this.rangeInput) / this.goal.indicator_goal)*100).toFixed()
		}
	},
  watch: {}
};
</script>
