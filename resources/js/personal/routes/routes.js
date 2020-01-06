import VueRouter from 'vue-router';
import personalRoutes from './PersonalRoutes';

let routes = [
    ...personalRoutes,
]


export default new VueRouter({
    mode: 'history',
    routes
});