window.Vue = require('vue');
import websiteAccountComponentRegistration from "./website_account_registration";
import loaderComponentRegistration from "./loaderComponentRegistration";

let allComponentRegistered = [
    websiteAccountComponentRegistration(),
    loaderComponentRegistration(),
];

export default allComponentRegistered;