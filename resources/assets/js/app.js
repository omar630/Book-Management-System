require('./bootstrap');
window.Vue = require('vue');

import App from './views/App.vue';
import VueRouter from 'vue-router'
import VueAxios from 'vue-axios';
import axios from 'axios';
import {routes} from './routes';
import Auth from './auth.js';
window.auth = new Auth();

Vue.use(VueRouter)
Vue.use(VueAxios, axios);

window.axios = axios;

const router = new VueRouter({
  mode: 'history',
  routes
});
window.Event = new Vue;

router.beforeEach((to, from, next) => {
  if (to.matched.some(record => record.meta.auth)) {                
    if (!auth.check()) {
      next({
        path: '/api/login',
        query: { redirect: to.fullPath }
      });

      return;
    }
  }
  next();
})
const app = new Vue({
 router: router,
 render: h => h(App),
}).$mount("#app");
