let websiteRoutes = [

    {
        path: '/', 
        redirect: '/wa/dashboard'
    },

    {
        path: '/wa', 
        redirect: '/wa/dashboard'
    },

    {
        path: '/wa/dashboard', 
        component: require( '../components/account/website/dashboard/index.vue' ).default
    },

    {
        path: '/wa/card', 
        component: require( '../components/account/website/settings/card_and_bank/index.vue' ).default
    },

    {
        path: '/wa/profile', 
        component: require( '../components/account/website/settings/profile/index.vue' ).default
    },

    {
        path: '/wa/notification_settings', 
        component: require( '../components/account/website/settings/notification/index.vue' ).default
    },

    {
        path: '/wa/notification_history', 
        component: require( '../components/account/website/notification_history/index.vue' ).default
    },

    {
        path: '/wa/transactions',
        component: require( '../components/account/website/transaction/index.vue' ).default
    },

    {
        path: '/wa/customer_list',
        component: require( '../components/account/website/empty/index.vue' ).default
    },

    {
        path: '/wa/payment_detail',
        component: require( '../components/account/website/empty/index.vue' ).default
    },

    {
        path: '/wa/api_documentation',
        component: require( '../components/account/website/api_documentation/index.vue' ).default
    },


    {
        path: '*',
        redirect: '/wa/dashboard'
    },
         
];

export default websiteRoutes;

