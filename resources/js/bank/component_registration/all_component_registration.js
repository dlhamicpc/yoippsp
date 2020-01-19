window.Vue = require('vue');
import bankAccountComponentRegistration from "./bank_account_registration";
import loaderComponentRegistration from "./loaderComponentRegistration";

let allComponentRegistered = [
    bankAccountComponentRegistration(),
    loaderComponentRegistration(),
];

export default allComponentRegistered;