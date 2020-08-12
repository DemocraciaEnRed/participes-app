<template>
  <div class="card rounded shadow-sm objective-card">
    <div class="card-body">
      <div class="d-flex align-items-center is-clickable" @click="showMore = !showMore">
        <div class="mr-4 category-icon-container" :style="`background-color: ${objective.category.background_color}`">
          <i class="fa-lg fa-fw" :class="objective.category.icon" :style="`color: ${objective.category.color}`"></i>
        </div>
        <div class="w-100">
          <span class="text-smallest" :style="`color:${objective.category.color}`">{{objective.category.title}}</span><br>
          <span class="text-dark is-700">{{objective.title}}</span>
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

        </div>
        <div class="ml-1">
          <span class="text-primary"><i class="fas fa-lg fa-fw" :class="{'fa-chevron-up': showMore, 'fa-chevron-down': !showMore}"></i></span>
        </div>
      </div>
      <div v-if="showMore">
        <hr>
        <div class="row my-2">
          <div class="col-md-6 col-lg-8">
            <b>Ultimas metas</b>
            <div class="my-1 d-flex justify-content-between align-items-center goal-container" v-for="goal in objective.latest_goals" :key="`goals_${goal.id}`">
              <span class="text-truncate w-100"><a :href="goal.url" class="text-dark">{{goal.title}}</a></span>
              <div class="progress my-0 mx-1'" style="height: 10px; width: 150px">
                <div class="progress-bar" :class="`bg-${goal.status}`" role="progressbar" :style="`width:${goal.progress_percentage}%`" :aria-valuenow="goal.progress_percentage" aria-valuemin="0" aria-valuemax="100"></div>
              </div>
              <span class="goal-percentage text-smallest is-700 ml-1">{{goal.progress_percentage}}%</span>
            </div>  
          </div>
          <div class="col-md-6 col-lg-4">
            <b>Ultimos reportes</b>
            <div class="my-1 d-flex justify-content-between align-items-center report-container" v-for="report in objective.latest_reports" :key="`reports_${report.id}`">
              <span class="text-truncate w-100"><i class="far fa-file text-primary"></i>&nbsp;<a :href="report.url" class="text-dark w-100">&nbsp;{{report.title}}</a></span>
              <span class="report-icon text-smaller ml-1"><i :class="`fas ${getReportIcon(report.type)} text-primary`"></i></span>
            </div>  
          </div>
        </div>
        <div class="mt-4 text-right">
          <a :href="objective.url" class="btn btn-outline-primary">Ver más&nbsp;<i class="fas fa-arrow-right"></i></a>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import GoalsDoughnut from './GoalsDoughnut';

export default {
  props: ['objective'],
  data(){
    return {
      showMore: false,
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
        labels: ['Alcanzadas','En progreso','Demoradas','Inactivas'],
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

<style lang="scss" scoped>
.objective-card{
  .goal-container{
    .goal-percentage {
       min-width: 30px;
       text-align: center;
    }
  }
  .report-container{
    .report-icon {
       min-width: 30px;
       text-align: center;
    }
  }

}
</style>