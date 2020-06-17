

require('./bootstrap');
import VueRouter from 'vue-router'
import UserInfo from './components/UserInfo'
import Home from './components/Home'
import Schedule from './components/Schedule'
import NotFound from './components/NotFound'
import LunchBreak from './components/LunchBreak'
import FirstBreak from './components/FirstBreak'
import LastBreak from './components/LastBreak'
import Clocks from './components/Clocks'
import Others from './components/Others'
import Idle from './components/Idle'
import RealtimeClocks from './components/RealtimeClocks'
import { Form, HasError, AlertError } from 'vform';
import NProgress from 'nprogress'
import VueBootstrap4Table from 'vue-bootstrap4-table'
import RealtimeFirstBreak from './components/RealtimeFirstbreak'
import RealtimeLunchBreak from './components/RealtimeLunch'
import RealtimeOthers from './components/RealtimeOthers'
import Reactivate from './components/Reactivate'
/*import '../node_modules/bootstrap/dist/css/bootstrap.min.css'*/
import moment from 'moment'
/*import IdleVue from 'idle-vue';*/
import './../../../node_modules/nprogress/nprogress.css'
import DigitalClock from "vue-digital-clock";
window.Vue = require('vue');
window.Form = Form;
Vue.use(VueRouter)
window.Fire =  new Vue();
import VueCountdown from '@chenfengyuan/vue-countdown';

Vue.component(VueCountdown.name, VueCountdown);
const eventsHub = new Vue();
/*Vue.use(IdleVue, {
  eventEmitter: eventsHub,
  idleTime: 900000, // 3 seconds,
  startAtIdle: false
});*/
Vue.component('example-component', require('./components/ExampleComponent.vue'));
Vue.component(HasError.name, HasError)
Vue.component('digital-clock',DigitalClock)
Vue.component(AlertError.name, AlertError)
Vue.filter('dateWithTime',function(created){
  return moment(created).format('MMM DD YYYY, h:mm:ss a');
});
Vue.component('vue-bootstrap4-table',VueBootstrap4Table)
import swal from 'sweetalert2'
window.swal = swal;

const toast = swal.mixin({
  toast: true,
  position: 'top-end',
  showConfirmButton: false,
  timer: 3000
});

window.toast = toast;

let routes = [
    {
        path:'/home',
        component:Home
    },
    {
        path:'/schedules',
        component:Schedule
    },
    {
      path:'/clocks',
      component:Clocks
    },
    {
        path:'/firstbreaklogs',
        component:FirstBreak
    },
    {
        path:'/lunchbreaklogs',
        component:LunchBreak
    },
    {
      path:'/lastbreaklogs',
      component:LastBreak
    },
    {
      path:'/realtimeclocks',
      component:RealtimeClocks
    },
    {
      path:'/realtimeothers',
      component:RealtimeOthers
    },
    {
      path:'/realtimefirstbreak',
      component:RealtimeFirstBreak
    },
    {
      path:'/realtimelunch',
      component:RealtimeLunchBreak
    },
    {
      path:'/idlelogs',
      component:Idle
    },
    {
      path:'/otherslogs',
      component:Others
    },
    {
        path:'/userinfo',
        component:UserInfo
    },
    {
        path:'/reactivate',
        component:Reactivate
    },
    {
        path:'*',
        component:NotFound
    }
];

const router = new VueRouter({
    mode: 'history',
    routes
})
router.beforeResolve((to, from, next) => {
  if (to.name) {
      NProgress.start()
  }
  next()
})

router.afterEach((to, from) => {
  NProgress.done()
})

const app = new Vue({
    el: '#app',
    router,
    data () {
    return {
      messageStr: 'Hello',
      time:1000,
      events:['click','mousemove','mousedown','scroll','keypress','load'],
      warningTimer:null,
      logoutTimer:null,
      warningZone:false,
    }
  },
  computed: {
    second() {
      return this.time / 1000;
    },
  
  },
  mounted(){
    this.events.forEach(function(event){
      window.addEventListener(event,this.resetTimer)
    },this);
    this.setTimers();
  },
  destroyed(){
    this.events.forEach(function(event){
      window.removeEventListener(event,this.resetTimer);
    },this)
  },

  /*onIdle() {
    
        axios.post('/idle').then((response) => {
          alert('You are on Idle Press OK To Avoid Auto Logout');
        });
  },*/
  methods:{
    setTimers(){
      this.warningTimer = setTimeout(this.warningMessage,15*60*1000)
      this.logoutTimer = setTimeout(this.logOutUser,20*60*1000);
      this.warningZone = false;
    },
    warningMessage(){
       axios.post('/idle').then((response) => {
          alert('You are on Idle Press OK To Avoid Auto Logout');
        });
    },
    logOutUser(){
      axios.post('/logoutclock').then((response) => {
        
      })
    },
    resetTimer(){
      clearTimeout(this.warningTimer);
      clearTimeout(this.logoutTimer);
      this.setTimers();
    }
  }
 /* onActive() {
    alert('Hey You are not in IDLE')
  },*/
});
