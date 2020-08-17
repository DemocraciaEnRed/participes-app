<template>
  <div class="card rounded shadow-sm">
    <div class="card-body">
      <div class="d-flex align-items-center">
        <div class="mr-4 category-icon-container" :style="`background-color: ${objective.category.background_color}`">
          <i class="fa-lg fa-fw" :class="objective.category.icon" :style="`color: ${objective.category.color}`"></i>
        </div>
        <div class="w-100">
          <span class="text-smallest" :style="`color:${objective.category.color}`">{{objective.category.title}}</span><br>
          <a :href="objective.url" class="text-dark is-700">{{objective.title}}</a><br>
          <span class="text-muted text-smallest" v-if="objective.tags.length > 0">{{objective.tags.join(' ')}}</span>
          </div>
        <div class="mx-1 d-flex">
          <div class="text-center mx-2">
            <span class="is-700 is-size-5"><i class="far fa-file fa-fw text-primary"></i>{{objective.reports_count}}</span><br><span class="text-smaller">reportes</span>
          </div>
          <div class="mx-2">
          <goals-doughnut :chartData="chartData" :styles="chartStyle"></goals-doughnut>
          </div>
          <div class="text-center mx-2">
            <span class="is-700 is-size-5"><i class="fas fa-medal fa-fw text-primary"></i>{{objective.goals_count}}</span><br><span class="text-smaller">metas</span>
          </div>
          <div class="ml-2 align-self-center">
            <a :href="objective.url" class="text-primary"><i class="fas fa-2x fa-fw fa-arrow-alt-circle-right"></i></a>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import GoalsDoughnut from '../../home/GoalsDoughnut';

export default {
  props: ['objective'],
  data(){
    return {
      styles: {
        height: 45
      }
    }
  },
  components: {
    GoalsDoughnut
  },
  computed: {
    chartData: function(){
      return {
        labels: ['Alcanzadas','En progreso','No cumplida','Inactivas'],
        data: [
          this.objective.goals_status.reached ?? 0,
          this.objective.goals_status.ongoing ?? 0,
          this.objective.goals_status.delayed ?? 0,
          this.objective.goals_status.inactive ?? 0,
        ],
        labelsColors: ['#2eda54','#ffa51e','#f15454','#7e7e7e']
      }
    },
    chartStyle: function(){
      return {
        height: `${this.styles.height}px`,
        width: `${this.styles.height}px`,
        position: 'relative'
      }
    }
  }
}
</script>

<style>

</style>