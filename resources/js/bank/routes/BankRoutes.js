let bankRoutes = [

    {
        path: '/', 
        redirect: '/bank/dashboard'
    },

    {
        path: '/bank', 
        redirect: '/bank/dashboard'
    },

    {
        path: '/bank/dashboard', 
        component: require( '../components/account/bank/dashboard/index.vue' ).default
    },
    
    {
        path: '/bank/profile', 
        component: require( '../components/account/bank/settings/profile/index.vue' ).default
    },

    {
        path: '/bank/notification_settings', 
        component: require( '../components/account/bank/settings/notification/index.vue' ).default
    },

    {
        path: '/bank/notification_history', 
        component: require( '../components/account/bank/notification_history/index.vue' ).default
    },

    {
        path: '/bank/transactions',
        component: require( '../components/account/bank/transaction/index.vue' ).default
    },

    {
        path: '/bank/bank_managers',
        component: require( '../components/account/bank/empty/index.vue' ).default
    },

    {
        path: '/bank/bank_managers/*',
        component: require( '../components/account/bank/empty/index.vue' ).default
    },

    {
        path: '/bank/bank_managers/*/edit',
        component: require( '../components/account/bank/empty/index.vue' ).default
    },

    {
        path: '/bank/add_new_bank_manager',
        component: require( '../components/account/bank/empty/index.vue' ).default
    },

    {
        path: '/bank/add_new_bank_manager',
        component: require( '../components/account/bank/empty/index.vue' ).default
    },

    {
        path: '/bank/customer_list_card',
        component: require( '../components/account/bank/empty/index.vue' ).default
    },

    {
        path: '/bank/customer_list_account',
        component: require( '../components/account/bank/empty/index.vue' ).default
    },

    {
        path: '/bank/payment_detail',
        component: require( '../components/account/bank/empty/index.vue' ).default
    },

    {
        path: '*',
        redirect: '/bank/dashboard'
    },
         
];

export default bankRoutes;

