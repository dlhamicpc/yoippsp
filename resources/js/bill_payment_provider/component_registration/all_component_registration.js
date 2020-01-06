window.Vue = require('vue');
import billPaymentProviderAccountComponentRegistration from "./bill_payment_provider_account_registration";
import loaderComponentRegistration from "./loaderComponentRegistration";

let allComponentRegistered = [
    billPaymentProviderAccountComponentRegistration(),
    loaderComponentRegistration(),
];

export default allComponentRegistered;