export default function billPaymentProviderAccountComponentRegistration() {
        //Dashboard Partial Components

        Vue.component(
            'dashboard-profile',
            require('../components/account/bill_payment_provider/dashboard/partials/profile.vue').default
        );


        Vue.component(
            'dashboard-balance',
            require('../components/account/bill_payment_provider/dashboard/partials/balance.vue').default
        );


        Vue.component(
            'dashboard-need_help',
            require('../components/account/bill_payment_provider/dashboard/partials/need_help.vue').default
        );


        Vue.component(
            'dashboard-profile_completeness',
            require('../components/account/bill_payment_provider/dashboard/partials/profile_completeness.vue').default
        );


        Vue.component(
            'dashboard-recent_activity',
            require('../components/account/bill_payment_provider/dashboard/partials/recent_activity.vue').default
        );


        Vue.component(
            'email-qrcode',
            require('../components/account/bill_payment_provider/dashboard/partials/email_qrcode.vue').default
        );

        Vue.component(
            'mobile-number-qrcode',
            require('../components/account/bill_payment_provider/dashboard/partials/mobile_number_qrcode.vue').default
        );


        Vue.component(
            'print-qrcode',
            require('../components/account/bill_payment_provider/dashboard/partials/print_qrcode.vue').default
        );


        Vue.component(
            'send-money',
            require('../components/account/bill_payment_provider/send/index.vue').default
        );


        Vue.component(
            'send-money-confirm',
            require('../components/account/bill_payment_provider/send/confirm.vue').default
        );


        Vue.component(
            'send-money-success',
            require('../components/account/bill_payment_provider/send/success.vue').default
        );


        Vue.component(
            'request-money',
            require('../components/account/bill_payment_provider/request/index.vue').default
        );


        Vue.component(
            'deposit-money',
            require('../components/account/bill_payment_provider/deposit/index.vue').default
        );


        Vue.component(
            'withdraw-money',
            require('../components/account/bill_payment_provider/withdraw/index.vue').default
        );


        Vue.component(
            'transaction-activity',
            require('../components/account/bill_payment_provider/transaction/index.vue').default
        );


        Vue.component(
            'transaction_list',
            require('../components/account/bill_payment_provider/transaction/partials/transaction_list.vue').default
        );


        Vue.component(
            'transaction_modal',
            require('../components/account/bill_payment_provider/transaction/partials/transaction_modal.vue').default
        );


        Vue.component(
            'balance-wallet',
            require('../components/account/bill_payment_provider/balance/index.vue').default
        );


        Vue.component(
            'view-card',
            require('../components/account/bill_payment_provider/settings/card_and_bank/partials/view_card.vue').default
        );


        Vue.component(
            'link-card',
            require('../components/account/bill_payment_provider/settings/card_and_bank/partials/link_card.vue').default
        );


        Vue.component(
            'edit-card',
            require('../components/account/bill_payment_provider/settings/card_and_bank/partials/edit_card.vue').default
        );


        Vue.component(
            'view-bank',
            require('../components/account/bill_payment_provider/settings/card_and_bank/partials/view_bank.vue').default
        );


        Vue.component(
            'link-bank',
            require('../components/account/bill_payment_provider/settings/card_and_bank/partials/link_bank.vue').default
        );


        Vue.component(
            'view-bill-payment-provider-details',
            require('../components/account/bill_payment_provider/settings/profile/partials/view_bill_payment_provider_details.vue').default
        );


        Vue.component(
            'edit-bill-payment-provider-details',
            require('../components/account/bill_payment_provider/settings/profile/partials/edit_bill_payment_provider_details.vue').default
        );


        Vue.component(
            'view-account-settings',
            require('../components/account/bill_payment_provider/settings/profile/partials/view_account_settings.vue').default
        );


        Vue.component(
            'edit-account-settings',
            require('../components/account/bill_payment_provider/settings/profile/partials/edit_account_settings.vue').default
        );


        Vue.component(
            'view-email',
            require('../components/account/bill_payment_provider/settings/profile/partials/view_email.vue').default
        );


        Vue.component(
            'edit-email',
            require('../components/account/bill_payment_provider/settings/profile/partials/edit_email.vue').default
        );


        Vue.component(
            'view-mobile-number',
            require('../components/account/bill_payment_provider/settings/profile/partials/view_mobile_number.vue').default
        );


        Vue.component(
            'edit-mobile-number',
            require('../components/account/bill_payment_provider/settings/profile/partials/edit_mobile_number.vue').default
        );


        Vue.component(
            'view-password',
            require('../components/account/bill_payment_provider/settings/profile/partials/view_password.vue').default
        );


        Vue.component(
            'edit-password',
            require('../components/account/bill_payment_provider/settings/profile/partials/edit_password.vue').default
        );


        Vue.component(
            'notification-history',
            require('../components/account/bill_payment_provider/notification_history/index.vue').default
        );


        Vue.component(
            'bill-management',
            require('../components/account/bill_payment_provider/bill_management/index.vue').default
        );


        Vue.component(
            'start-payment',
            require('../components/account/bill_payment_provider/bill_management/start_payment/index.vue').default
        );

    
}




