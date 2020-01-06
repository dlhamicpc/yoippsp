let billPaymentProviderRoutes = [

    {
        path: '/', 
        redirect: '/bpa/dashboard'
    },

    {
        path: '/bpa', 
        redirect: '/bpa/dashboard'
    },

    {
        path: '/bpa/dashboard', 
        component: require( '../components/account/bill_payment_provider/dashboard/index.vue' ).default
    },

    {
        path: '/bpa/card', 
        component: require( '../components/account/bill_payment_provider/settings/card_and_bank/index.vue' ).default
    },

    {
        path: '/bpa/profile', 
        component: require( '../components/account/bill_payment_provider/settings/profile/index.vue' ).default
    },

    {
        path: '/bpa/notification_settings', 
        component: require( '../components/account/bill_payment_provider/settings/notification/index.vue' ).default
    },

    {
        path: '/bpa/notification_history', 
        component: require( '../components/account/bill_payment_provider/notification_history/index.vue' ).default
    },

    {
        path: '/bpa/transactions',
        component: require( '../components/account/bill_payment_provider/transaction/index.vue' ).default
    },

    {
        path: '/bpa/customer_list',
        component: require( '../components/account/bill_payment_provider/empty/index.vue' ).default
    },

    {
        path: '/bpa/bill_summary',
        component: require( '../components/account/bill_payment_provider/empty/index.vue' ).default
    },

    {
        path: '/bpa/payment_detail',
        component: require( '../components/account/bill_payment_provider/empty/index.vue' ).default
    },

    {
        path: '*',
        redirect: '/bpa/dashboard'
    },
         
];

export default billPaymentProviderRoutes;

