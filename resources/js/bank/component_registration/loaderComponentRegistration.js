export default function loaderComponentRegistration() {
    
    Vue.component(
        'pulse-loader',
        require('../components/loaders/PulseLoader.vue').default
    );

    Vue.component(
        'grid-loader',
        require('../components/loaders/GridLoader.vue').default
    );

    Vue.component(
        'rotate-loader',
        require('../components/loaders/RotateLoader.vue').default
    );

    Vue.component(
        'bounce-loader',
        require('../components/loaders/BounceLoader.vue').default
    );

    Vue.component(
        'ring-loader',
        require('../components/loaders/RingLoader.vue').default
    );

}