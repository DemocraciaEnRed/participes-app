import axios from 'axios'

axios.defaults.timeout = 15000;
// axios.defaults.baseURL = '/api-service';
axios.defaults.withCredentials = true

// axios.interceptors.request.use(
//     config => {
//         if (store.state.session) {
//             config.headers.Authorization = `Bearer ${store.state.session.token}`;
//         }
//         return config;
//     },
//     err => {
//         return Promise.reject(err);
//     });

// axios.interceptors.response.use(
//     response => {
//         return response;
//     },
//     error => {
//         console.error(error.response.data)
//         if (error.response) {
//             switch (error.response.status) {
//                 case 401:
//                     store.commit('logout');
//                     router.push({
//                         name: 'login',
//                         query: {redirect: router.currentRoute.fullPath}
//                     })
//                     break;
//                 case 403:
//                     router.push({
//                         name: '403'
//                     })
//                     break;
//                 // default:
//                 //     r    outer.replace({
//                 //         name: 'error'
//                 //     })
//             }
//         }
//         return Promise.reject(error.response.data)
//     });

export default axios;