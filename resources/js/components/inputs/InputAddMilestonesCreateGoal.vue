<template>
  <section>
    <div class="input-group mb-1">
    <input type="text"  class="form-control" v-model="inputMilestone" @keyup.enter="addMilestone" @keyup.188="addMilestoneWithoutComma">
      <div class="input-group-append">
        <button class="btn btn-secondary" type="button" @click="addMilestone"><i class="fas fa-plus"></i></button>
      </div>
    </div>
    <small class="form-text text-muted">Escriba el hito, y haga clic en <i class="fas fa-plus"></i> y presione <kbd>ENTER</kbd> o <kbd>,</kbd> para ingresar</small>
    <input type="hidden" :name="`${name}[]`" v-for="(milestone,i) in milestonesList" :key="`milestone${i}`" :value="milestone">
    <ul class="list-group mt-2">
      <li class="list-group-item text-secondary text-italics" v-if="milestonesList.length == 0">No hay hitos creados. La meta se creará sin hitos (puede crearlos mas tarde)</li>
      <li class="list-group-item d-flex justify-content-between align-items-center" v-for="(milestone,i) in milestonesList" :key="`mile${i}`">
        Hito #{{i+1}}: {{milestone}}
        <a @click="removeMilestone(i)" class="badge badge-primary badge-pill is-clickable text-white"><i class="fas fa-times fa-fx"></i></a>
        </li>
    </ul>
  </section>
</template>

<script>
export default {
  props: {
    name: {
      type: String,
      required: true
    },
  },
  data(){
    return {
      inputMilestone: '',
      milestonesList: []
    }
  },
  methods: {
    addMilestone: function(){
      if(this.inputMilestone.length == 0) return
      if(this.milestonesList.includes(this.inputMilestone)) {
        this.inputMilestone = null;
        return false
      }
      this.milestonesList.push(this.inputMilestone);
      this.inputMilestone = null;
      return true
    },
    addMilestoneWithoutComma: function(){
      this.inputMilestone = this.inputMilestone.substring(0, this.inputMilestone.length - 1);
      if(this.inputMilestone.length == 0) return
      if(this.milestonesList.includes(this.inputMilestone)) {
        this.inputMilestone = null;
        return false
      }
      this.milestonesList.push(this.inputMilestone);
      this.inputMilestone = null;
      return true
    },
    removeMilestone: function(index){
      this.milestonesList.splice(index,1);
    }
  }
}
</script>