export default function bankAccountComponentRegistration() {
        //Dashboard Partial Components

        Vue.component(
            'dashboard-profile',
            require('../components/account/bank/dashboard/partials/profile.vue').default
        );


        Vue.component(
            'dashboard-bank-logo',
            require('../components/account/bank/dashboard/partials/bank_logo.vue').default
        );


        Vue.component(
            'dashboard-need_help',
            require('../components/account/bank/dashboard/partials/need_help.vue').default
        );


        Vue.component(
            'dashboard-profile_completeness',
            require('../components/account/bank/dashboard/partials/profile_completeness.vue').default
        );


        Vue.component(
            'dashboard-recent_activity',
            require('../components/account/bank/dashboard/partials/recent_activity.vue').default
        );




        Vue.component(
            'transaction-activity',
            require('../components/account/bank/transaction/index.vue').default
        );


        Vue.component(
            'transaction_list',
            require('../components/account/bank/transaction/partials/transaction_list.vue').default
        );


        Vue.component(
            'transaction_modal',
            require('../components/account/bank/transaction/partials/transaction_modal.vue').default
        );

        Vue.component(
            'view-bank-details',
            require('../components/account/bank/settings/profile/partials/view_bank_details.vue').default
        );


        Vue.component(
            'edit-bank-details',
            require('../components/account/bank/settings/profile/partials/edit_bank_details.vue').default
        );


        Vue.component(
            'view-account-settings',
            require('../components/account/bank/settings/profile/partials/view_account_settings.vue').default
        );


        Vue.component(
            'edit-account-settings',
            require('../components/account/bank/settings/profile/partials/edit_account_settings.vue').default
        );


        Vue.component(
            'view-email',
            require('../components/account/bank/settings/profile/partials/view_email.vue').default
        );


        Vue.component(
            'edit-email',
            require('../components/account/bank/settings/profile/partials/edit_email.vue').default
        );


        Vue.component(
            'view-mobile-number',
            require('../components/account/bank/settings/profile/partials/view_mobile_number.vue').default
        );


        Vue.component(
            'edit-mobile-number',
            require('../components/account/bank/settings/profile/partials/edit_mobile_number.vue').default
        );


        Vue.component(
            'view-password',
            require('../components/account/bank/settings/profile/partials/view_password.vue').default
        );


        Vue.component(
            'edit-password',
            require('../components/account/bank/settings/profile/partials/edit_password.vue').default
        );


        Vue.component(
            'notification-history',
            require('../components/account/bank/notification_history/index.vue').default
        );




    
}




