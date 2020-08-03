/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');
import http from './axios'

window.Vue = require('vue');

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.component('notification-item', require('./components/NotificationItem.vue').default);
Vue.component('form-new-report', require('./components/FormNewReport.vue').default);
Vue.component('admin-search-user-new-admin', require('./components/AdminSearchUserNewAdmin.vue').default);
Vue.component('objective-search-user-add-team', require('./components/ObjectiveSearchUserAddTeam.vue').default);
Vue.component('paginator', require('./components/utils/Paginator.vue').default);
Vue.component('error-alert', require('./components/utils/ErrorAlert.vue').default);
Vue.component('content-visor', require('./components/utils/ContentVisor.vue').default);
Vue.component('input-tags', require('./components/inputs/InputTag.vue').default);
Vue.component('input-file', require('./components/inputs/InputFile.vue').default);
Vue.component('input-user-avatar', require('./components/inputs/InputUserAvatar.vue').default);
Vue.component('input-add-milestones-create-goal', require('./components/inputs/InputAddMilestonesCreateGoal.vue').default);
Vue.component('report-comments', require('./components/comments/ReportComments.vue').default);

Vue.component('mapita', require('./components/maps/Mapita.vue').default);
Vue.component('set-map-default', require('./components/maps/SetMapDefault.vue').default);
Vue.component('draw-map', require('./components/maps/DrawMap.vue').default);


Vue.prototype.$http = http

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
});
