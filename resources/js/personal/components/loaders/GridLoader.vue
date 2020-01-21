<template>
  <div class="v-spinner" v-bind:style="containerStyle" v-show="loading">
    <div class="all-spiner">
      <div class="v-grid v-grid1" v-bind:style="[spinnerStyle,animationStyle,animationStyle1]">
      </div><div class="v-grid v-grid2" v-bind:style="[spinnerStyle,animationStyle,animationStyle2]">
      </div><div class="v-grid v-grid3" v-bind:style="[spinnerStyle,animationStyle,animationStyle3]">
      </div><div class="v-grid v-grid4" v-bind:style="[spinnerStyle,animationStyle,animationStyle4]">
      </div><div class="v-grid v-grid5" v-bind:style="[spinnerStyle,animationStyle,animationStyle5]">
      </div><div class="v-grid v-grid6" v-bind:style="[spinnerStyle,animationStyle,animationStyle6]">
      </div><div class="v-grid v-grid7" v-bind:style="[spinnerStyle,animationStyle,animationStyle7]">
      </div><div class="v-grid v-grid8" v-bind:style="[spinnerStyle,animationStyle,animationStyle8]">
      </div><div class="v-grid v-grid9" v-bind:style="[spinnerStyle,animationStyle,animationStyle9]">
      </div>
    </div>
  </div>
</template>

<script>
export default {
  
  name: 'GridLoader',

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
        borderRadius: this.radius
      }
    }
  },
  computed: {
    animationStyle () {
      return {
        animationName: 'v-gridStretchDelay',
        animationIterationCount: 'infinite',
        animationTimingFunction: 'ease',
        animationFillMode: 'both',
        display: 'inline-block'
      }
    },
    animationStyle1 () {
      return {
        animationDelay: this.delay(),
        animationDuration: this.duration()
      }
    },
    animationStyle2 () {
      return {
        animationDelay: this.delay(),
        animationDuration: this.duration()
      }
    },
    animationStyle3 () {
      return {
        animationDelay: this.delay(),
        animationDuration: this.duration()
      }
    },
    animationStyle4 () {
      return {
        animationDelay: this.delay(),
        animationDuration: this.duration()
      }
    },
    animationStyle5 () {
      return {
        animationDelay: this.delay(),
        animationDuration: this.duration()
      }
    },
    animationStyle6 () {
      return {
        animationDelay: this.delay(),
        animationDuration: this.duration()
      }
    },
    animationStyle7 () {
      return {
        animationDelay: this.delay(),
        animationDuration: this.duration()
      }
    },
    animationStyle8 () {
      return {
        animationDelay: this.delay(),
        animationDuration: this.duration()
      }
    },
    animationStyle9 () {
      return {
        animationDelay: this.delay(),
        animationDuration: this.duration()
      }
    },
    containerStyle () {
      return {
        width: parseFloat(this.size) * 3 + parseFloat(this.margin) * 6 + 'px',
        fontSize: 0
      }
    }
  },
  methods: {
    random (value) {
      return Math.random() * value
    },
    delay () {
      return ((this.random(100) / 100) - 0.2) + 's'
    },
    duration () {
      return ((this.random(100) / 100) + 0.6) + 's'
    },
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
  /* top: 56px; */
  left: 0;
  right: 0;
  bottom: 0;
  background-color: rgba(0,0,0,0.5); /* Black background with opacity */
  z-index: 100000; /* Specify a stack order in case you're using a different order for other elements */
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
    top: 50%;
    left: 50%;
    transform: translate(-50%,-50%);
    -ms-transform: translate(-50%,-50%);
  }
}

@-webkit-keyframes v-gridStretchDelay
{
    0%
    {
        -webkit-transform: scale(1);
                transform: scale(1);
    }
    50%
    {
        -webkit-transform: scale(0.5);
                transform: scale(0.5);
        -webkit-opacity: 0.7;             
                opacity: 0.7;
    }
    100%
    {
        -webkit-transform: scale(1);
                transform: scale(1);
        -webkit-opacity: 1;             
                opacity: 1;
    }
}

@keyframes v-gridStretchDelay
{
    0%
    {
        -webkit-transform: scale(1);
                transform: scale(1);
    }
    50%
    {
        -webkit-transform: scale(0.5);
                transform: scale(0.5);
        -webkit-opacity: 0.7;             
                opacity: 0.7;
    }
    100%
    {
        -webkit-transform: scale(1);
                transform: scale(1);
        -webkit-opacity: 1;             
                opacity: 1;
    }
}
</style>