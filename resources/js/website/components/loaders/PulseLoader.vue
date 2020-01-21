<template>
  <div class="v-spinner" v-show="loading">
    <div class="all-spiner">
      <div class="v-pulse v-pulse1" v-bind:style="[spinnerStyle,spinnerDelay1]">
      </div><div class="v-pulse v-pulse2" v-bind:style="[spinnerStyle,spinnerDelay2]">
      </div><div class="v-pulse v-pulse3" v-bind:style="[spinnerStyle,spinnerDelay3]">
      </div>
    </div>
  </div>
</template>

<script>
export default {
  mounted() {
            //console.log('Pulse Component mounted.')
        },
  
  name: 'PulseLoader',

  props: {
    loading: {
      type: Boolean,
      default: true
    },
    color: { 
      type: String,
      default: '#5dc596'
    },
    size: {
      type: String,
      default: '15px'
    },
    margin: {
      type: String,
      default: '2px'
    },
    radius: {
      type: String,
      default: '100%'
    }
  },
  data () {
    return {
      spinnerStyle: {
      	backgroundColor: this.color,
      	width: this.size,
        height: this.size,
      	margin: this.margin,
      	borderRadius: this.radius,
        display: 'inline-block',
        animationName: 'v-pulseStretchDelay',
        animationDuration: '0.75s',
        animationIterationCount: 'infinite',
        animationTimingFunction: 'cubic-bezier(.2,.68,.18,1.08)',
        animationFillMode: 'both'
      },
      spinnerDelay1: {
        animationDelay: '0.12s'
      },
      spinnerDelay2: {
        animationDelay: '0.24s'
      },
      spinnerDelay3: {
        animationDelay: '0.36s'
      }
    }
  }

}
</script>

<style>
.v-spinner
{
  position: fixed; /* Sit on top of the page content */
  display: block; /* Hidden by default */
  width: 100%; /* Full width (cover the whole page) */
  height: 100%; /* Full height (cover the whole page) */
  top: 56px;
  left: 0;
  right: 0;
  bottom: 0;
  background-color: rgba(0,0,0,0.5); /* Black background with opacity */
  z-index: 2; /* Specify a stack order in case you're using a different order for other elements */
  cursor: pointer; /* Add a pointer on hover */
}

.all-spiner {
  position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%,-50%);
  -ms-transform: translate(-50%,-50%);
}

@media screen and ( min-width:900px ){
  .all-spiner {
    position: absolute;
    top: 40%;
    left: 60%;
    transform: translate(-50%,-50%);
    -ms-transform: translate(-50%,-50%);
  }
}


@-webkit-keyframes v-pulseStretchDelay
{
    0%,
    80%
    {
        -webkit-transform: scale(1);
                transform: scale(1);
        -webkit-opacity: 1;             
                opacity: 1;
    }
    45%
    {
        -webkit-transform: scale(0.1);
                transform: scale(0.1);
        -webkit-opacity: 0.7;             
                opacity: 0.7;
    }
}

@keyframes v-pulseStretchDelay
{
    0%,
    80%
    {
        -webkit-transform: scale(1);
                transform: scale(1);
        -webkit-opacity: 1;             
                opacity: 1;
    }
    45%
    {
        -webkit-transform: scale(0.1);
                transform: scale(0.1);
        -webkit-opacity: 0.7;             
                opacity: 0.7;
    }
}
</style>