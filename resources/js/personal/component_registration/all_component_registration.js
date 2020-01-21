window.Vue = require('vue');
import personalAccountComponentRegistration from "./personal_account_registration";
import loaderComponentRegistration from "./loaderComponentRegistration";

let allComponentRegistered = [
    personalAccountComponentRegistration(),
    loaderComponentRegistration(),
];

export default allComponentRegistered;