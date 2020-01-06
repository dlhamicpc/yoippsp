import VueRouter from 'vue-router';
import billPaymentProviderRouter from './BillPaymentProviderRoutes.js';

let routes = [
    ...billPaymentProviderRouter,
];


export default new VueRouter({
    mode: 'history',
    routes
});