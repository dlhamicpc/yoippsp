import VueRouter from 'vue-router';
import websiteRouter from './WebsiteRoutes.js';

let routes = [
    ...websiteRouter,
];


export default new VueRouter({
    mode: 'history',
    routes
});