let personalDir = '../components/account/personal/';

let personalRoutes = [

    {
        path: '/', 
        redirect: '/pa/dashboard'
    },

    {
        path: '/pa', 
        redirect: '/pa/dashboard'
    },

    {
        path: '/pa/dashboard', 
        component: require( '../components/account/personal/dashboard/index.vue' ).default
    },

    {
        path: '/pa/card', 
        component: require( '../components/account/personal/settings/card_and_bank/index.vue' ).default
    },

    {
        path: '/pa/profile', 
        component: require( '../components/account/personal/settings/profile/index.vue' ).default
    },

    {
        path: '/pa/notification_settings', 
        component: require( '../components/account/personal/settings/notification/index.vue' ).default
    },

    {
        path: '/pa/bill_payment_settings', 
        component: require( '../components/account/personal/settings/bill_payment/index.vue' ).default
    },

    {
        path: '/pa/notification_history', 
        component: require( '../components/account/personal/notification_history/index.vue' ).default
    },

    {
        path: '/pa/transactions',
        component: require( '../components/account/personal/transaction/index.vue' ).default
    },

    {
        path: '*',
        component: require( '../components/404.vue' ).default
    },

    {
        path: '*',
        redirect: '/pa/dashboard'
    },

/*
    {
        path: '/pa/water_payment', 
        component: require( '../components/account/personal/billpayments/water_payment/index.vue' ).default
    },

    {
        path: '/pa/electricity_payment', 
        component: require( '../components/account/personal/billpayments/electricity_payment/index.vue' ).default
    },

    {
        path: '/pa/dstv_payment', 
        component: require( '../components/account/personal/billpayments/dstv_payment/dashboard/index.vue' ).default
    },

    {
        path: '/pa/cinema_ticket', 
        component: require( '../components/account/personal/tickets/cinema_ticket/index.vue' ).default
    },

    {
        path: '/pa/airplane_ticket', 
        component: require( '../components/account/personal/tickets/airplane_ticket/index.vue' ).default
    },
    
    {
        path: '/pa/bus_ticket', 
        component: require( '../components/account/personal/tickets/bus_ticket/index.vue' ).default
    },

    {
        path: '/pa/exchange_rate', 
        component: require( '../components/account/personal/exchange_rate/index.vue' ).default
    },

    {
        path: '/pa/help', 
        component: require( '../components/account/personal/help/index.vue' ).default
    }, */
         
];

export default personalRoutes;

