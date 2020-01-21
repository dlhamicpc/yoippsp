import VueRouter from 'vue-router';
import bankRouter from './BankRoutes.js';

let routes = [
    ...bankRouter,
];


export default new VueRouter({
    mode: 'history',
    routes
});