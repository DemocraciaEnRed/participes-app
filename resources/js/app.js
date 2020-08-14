/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');
import http from './axios'
import globals from './globals'
import VueScrollactive from 'vue-scrollactive';
import Toasted from 'vue-toasted';

window.Vue = require('vue');

Vue.use(VueScrollactive);
Vue.use(Toasted, {
    iconPack: 'fontawesome',
    theme: 'toasted-primary',
    className: 'custom-toast',
    // you can pass a single action as below
    action : {
        text : 'OK',
        onClick : (e, toastObject) => {
            toastObject.goAway(0);
        }
    }
})
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
Vue.component('paginator', require('./components/utils/Paginator.vue').default);
Vue.component('error-alert', require('./components/utils/ErrorAlert.vue').default);
Vue.component('input-file', require('./components/inputs/InputFile.vue').default);
Vue.component('input-user-avatar', require('./components/inputs/InputUserAvatar.vue').default);
Vue.component('portal-home-reports-carrousel', require('./components/portal/home/ReportsCarrousel.vue').default);
Vue.component('portal-home-stats', require('./components/portal/home/Stats.vue').default);
Vue.component('report-comments', require('./components/comments/ReportComments.vue').default);
Vue.component('portal-report-map', require('./components/portal/report/Map.vue').default);
Vue.component('portal-objective-stats', require('./components/portal/objective/Stats.vue').default);
Vue.component('portal-last-objectives', require('./components/portal/home/LastObjectives.vue').default);
Vue.component('objective-organizations-carrousel', require('./components/portal/objective/OrganizationCarrousel.vue').default);
Vue.component('map-reports', require('./components/maps/MapReports.vue').default);
Vue.component('collapse', require('./components/utils/Collapse.vue').default);
Vue.component('report-list', require('./components/report/ReportsList.vue').default);
Vue.component('report-album', require('./components/report/Album.vue').default);


Vue.prototype.$http = http

Vue.mixin(globals);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
});
